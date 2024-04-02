<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prediksi extends Model
{
    use HasFactory;

    protected $table = "predictions";
    protected $fillable = ["id_obat", "layer", "epoch"];

    protected $casts = [
        'layer' => "array",
    ];

    public function obat(): HasOne
    {
        return $this->hasOne(Obat::class, "id", "id_obat");
    }
    public function data(): HasMany
    {
        return $this->hasMany(DataPrediksi::class, "id_prediction", "id");
    }
    public function result(): HasOne
    {
        return $this->hasOne(HasilPrediksi::class, "id_prediction", "id");
    }
}
