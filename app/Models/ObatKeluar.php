<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ObatKeluar extends Model
{
    use HasFactory;

    protected $table = "obat_keluar";
    protected $fillable = ["id_obat", "tgl_keluar", "qty"];

    protected $casts = [
        "tgl_keluar" => "datetime:Y-m-d",
    ];

    public function obat(): HasOne
    {
        return $this->hasOne(Obat::class, "id", "id_obat");
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (ObatKeluar $data) {
            $data->obat->stok - $data->qty < 0 ? $data->obat->update(["stok" => 0]) : $data->obat->update(["stok" => $data->obat->stok - $data->qty]);
        });
    }
}
