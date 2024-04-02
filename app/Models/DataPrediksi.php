<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DataPrediksi extends Model
{
    use HasFactory;

    protected $table = "data_prediksi";
    protected $fillable = ["id_prediction", "tanggal", "x1", "x2", "x3", "x4", "x5", "x6", "x7", "x8", "x9", "x10", "x11", "x12", "y"];

    protected $casts = [
        'tanggal' => 'datetime:Y-m-d',
    ];
}
