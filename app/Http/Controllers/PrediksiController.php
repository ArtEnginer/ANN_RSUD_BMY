<?php

namespace App\Http\Controllers;

use App\Models\DataPrediksi;
use App\Models\HasilPrediksi;
use App\Models\Obat;
use App\Models\ObatKeluar;
use App\Models\Prediksi as Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rubix\ML\CrossValidation\Metrics\SMAPE;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\NeuralNet\ActivationFunctions\ReLU;
use Rubix\ML\NeuralNet\CostFunctions\LeastSquares;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Optimizers\RMSProp;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Regressors\MLPRegressor;

class PrediksiController extends BaseApi
{
    protected $modelName = Model::class;

    public function index()
    {
        return $this->modelName::all()->load("obat", "data", "result");
    }

    public function store(Request $request)
    {
        // Membentuk layer-layer jaringan berdasarkan input dari request
        $layers = [];
        array_map(function ($layer) use (&$layers) {
            $layers[] = new Dense($layer);
            $layers[] = new Activation(new ReLU);
        }, $request->all()["layer"]);

        // Menginisialisasi model MLPRegressor dengan layer-layer yang dibentuk
        $estimator = new MLPRegressor($layers, 128, new RMSProp(0.001), 1e-3, $request->all()["epoch"], 1e-5, 3, 0.1, new LeastSquares(), new SMAPE());

        // Membuat entri baru dalam model Prediksi
        $data = $this->modelName::create($request->all());

        $fetch = [];
        $datasets = [];

        // Memproses data riwayat obat keluar untuk pembentukan dataset
        /** @var ObatKeluar $history */
        foreach (ObatKeluar::where("id_obat", $request->all()["id_obat"])->get() as $history) {
            $tgl = $history->tgl_keluar->setDay(1)->format("Y-m-d");
            if (in_array($tgl, array_keys($fetch))) {
                $fetch[$tgl]["qty"] += $history->qty;
            } else {
                $fetch[$tgl] = $history->toArray();
            }
        }

        // Membuat dataset yang akan digunakan untuk melatih model
        for ($i = 0; $i < sizeof($fetch) - 12; $i++) {
            $datasets[$i] = [
                "x1" => array_values($fetch)[0 + $i]["qty"],
                "x2" => array_values($fetch)[1 + $i]["qty"],
                "x3" => array_values($fetch)[2 + $i]["qty"],
                "x4" => array_values($fetch)[3 + $i]["qty"],
                "x5" => array_values($fetch)[4 + $i]["qty"],
                "x6" => array_values($fetch)[5 + $i]["qty"],
                "x7" => array_values($fetch)[6 + $i]["qty"],
                "x8" => array_values($fetch)[7 + $i]["qty"],
                "x9" => array_values($fetch)[8 + $i]["qty"],
                "x10" => array_values($fetch)[9 + $i]["qty"],
                "x11" => array_values($fetch)[10 + $i]["qty"],
                "x12" => array_values($fetch)[11 + $i]["qty"],
                "y" => array_values($fetch)[12 + $i]["qty"],
            ];

            // Menyimpan data prediksi dalam model DataPrediksi
            DataPrediksi::create(
                [
                    "id_prediction" => $data->id,
                    "tanggal" => array_values($fetch)[12 + $i]["tgl_keluar"],
                    ...$datasets[$i],
                ]
            );

            // Mengambil data untuk prediksi
            if ($i == sizeof($fetch) - 13) {
                $forecast = Unlabeled::build([
                    [
                        array_values($fetch)[1 + $i]["qty"],
                        array_values($fetch)[2 + $i]["qty"],
                        array_values($fetch)[3 + $i]["qty"],
                        array_values($fetch)[4 + $i]["qty"],
                        array_values($fetch)[5 + $i]["qty"],
                        array_values($fetch)[6 + $i]["qty"],
                        array_values($fetch)[7 + $i]["qty"],
                        array_values($fetch)[8 + $i]["qty"],
                        array_values($fetch)[9 + $i]["qty"],
                        array_values($fetch)[10 + $i]["qty"],
                        array_values($fetch)[11 + $i]["qty"],
                        array_values($fetch)[12 + $i]["qty"],
                    ]
                ]);
            }
        }

        $samples = [];
        $labels = [];

        foreach ($datasets as $ds) {
            $temp = $ds;
            unset($temp["y"]);
            $samples[] = array_values($temp);
            $labels[] = $ds["y"];
        }

        $dataset = new Labeled($samples, $labels, true);
        $tempds = $dataset;
        // Melatih model menggunakan dataset yang telah dibuat
        $estimator->train($tempds);

        $actual = $dataset->labels();
        $predict = $estimator->predict($tempds);
        $m = new SMAPE();
        $testMape = $m->score($predict, $actual);

        // Menyimpan hasil prediksi dalam model HasilPrediksi
        $hasil = HasilPrediksi::create([
            "id_prediction" => $data->id,
            "raw" => $fetch,
            "scores" => $estimator->scores(),
            "network" => [$dataset->samples(), $dataset->labels(), $datasets],
            "predicts" => $predict,
            "forecast" => $estimator->predict($forecast)[0],
            "testmape" => $testMape,
        ]);

        return $hasil;
    }
}
