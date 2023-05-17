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
        Schema::create('alternatif_kategori', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('alternatif_id');
            $table->unsignedBigInteger('kategori_id');
            $table->float('nilai', unsigned: true);
            $table->timestamps();

            $table->foreign('alternatif_id')->references('id')->on('alternatifs');
            $table->foreign('kategori_id')->references('id')->on('kategoris');
            $table->primary(['alternatif_id', 'kategori_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternarif_kategori');
    }
};
