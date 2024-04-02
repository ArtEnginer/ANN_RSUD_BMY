<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatKeluar as Model;
use Illuminate\Http\Request;

class KeluarController extends BaseApi
{
    protected $modelName = Model::class;

    public function index()
    {
        return $this->modelName::all()->load("obat");
    }

    public function store(Request $request)
    {
        if (Obat::find($request->all()['id_obat'])->stok < $request->all()['qty']) {
            return response()->json(['message' => 'Stok Obat Tidak Cukup'], 400);
        }
        $data = $this->modelName::create($request->all());
        return $data;
    }
}
