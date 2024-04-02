<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HasilPrediksi extends Model
{
    use HasFactory;

    protected $table = "hasil_prediksi";
    protected $fillable = ["id_prediction","raw", "scores", "network", "predicts", "forecast", "testmape"];

    protected $casts = [
        'raw' => "array",
        'scores' => "array",
        'network' => "array",
        'predicts' => "array",
    ];

    public function prediction(): HasOne
    {
        return $this->hasOne(Prediksi::class, "id", "id_prediction");
    }
}
