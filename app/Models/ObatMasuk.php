<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ObatMasuk extends Model
{
    use HasFactory;

    protected $table = "obat_masuk";
    protected $fillable = ["tgl_masuk", "id_obat", "permintaan", "qty", "expired"];

    public function obat(): HasOne
    {
        return $this->hasOne(Obat::class, "id", "id_obat");
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (ObatMasuk $data) {
            $data->obat->update(["stok" => $data->obat->stok + $data->qty]);
        });
    }
}
