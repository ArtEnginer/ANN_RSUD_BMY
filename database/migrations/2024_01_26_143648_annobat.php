<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ["Analgesik", "Antibiotik", "Lainnya"])->default('Lainnya');
            $table->unsignedBigInteger('stok')->default(0);
            $table->string('satuan')->default('Tablet');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('obat_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_obat');
            $table->date('tgl_masuk');
            $table->integer('permintaan');
            $table->integer('qty');
            $table->date('expired');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('obat_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_obat');
            $table->date('tgl_keluar');
            $table->integer('qty');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_obat');
            $table->json("layer");
            $table->unsignedInteger("epoch");
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('data_prediksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_prediction');
            $table->date('tanggal');
            $table->integer('x1');
            $table->integer('x2');
            $table->integer('x3');
            $table->integer('x4');
            $table->integer('x5');
            $table->integer('x6');
            $table->integer('x7');
            $table->integer('x8');
            $table->integer('x9');
            $table->integer('x10');
            $table->integer('x11');
            $table->integer('x12');
            $table->integer('y');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('hasil_prediksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_prediction');
            $table->json('raw');
            $table->json('scores');
            $table->json('network');
            $table->json('predicts');
            $table->integer('forecast');
            $table->integer('testmape');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
        Schema::dropIfExists('obat_masuk');
        Schema::dropIfExists('obat_keluar');
        Schema::dropIfExists('predictions');
        Schema::dropIfExists('data_prediksi');
        Schema::dropIfExists('hasil_prediksi');
    }
};
