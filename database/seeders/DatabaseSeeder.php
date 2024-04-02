<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Obat;
use App\Models\ObatKeluar;
use App\Models\ObatMasuk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'group' => 'admin',
            ],
            [
                'name' => 'Kepala Puskesmas',
                'email' => 'kepala@gmail.com',
                'group' => 'kepala',
            ],
            [
                'name' => 'Penanggung Jawab Gudang',
                'email' => 'gudang@gmail.com',
                'group' => 'gudang',
            ],
        ]);

        Obat::insert([
            [
                "nama" => "Paracetamol",
                "jenis" => "Analgesik",
                "satuan" => "Tablet",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);

        $paracetamol = [5158, 2588, 4370, 3747, 902, 2856, 1165, 1644, 1840, 1811, 2109, 1036, 2981, 2361, 1610, 4074, 2636, 2298, 4436, 3242, 2560, 2769, 2198, 3379, 5010, 4567, 4230, 2442, 3019, 3572, 3879, 4847, 5162, 5070, 5770, 2713, 4730, 3350, 4131, 2469, 5352, 3809, 4680];

        for ($i = 0; $i < count($paracetamol); $i++) {
            ObatMasuk::insert([
                [
                    "id_obat" => 1,
                    "tgl_masuk" => Carbon::parse('2020-01-01')->addMonths($i),
                    "permintaan" => $paracetamol[$i],
                    "qty" => $paracetamol[$i],
                    "expired" => now()->addYears(1),
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
            ]);
        }
        for ($i = 0; $i < count($paracetamol); $i++) {
            ObatKeluar::insert([
                [
                    "tgl_keluar" => Carbon::parse('2020-01-01')->addMonths($i),
                    "id_obat" => 1,
                    "qty" => $paracetamol[$i],
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
            ]);
        }
    }
}
