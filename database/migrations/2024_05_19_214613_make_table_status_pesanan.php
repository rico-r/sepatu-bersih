<?php

use App\Models\Karyawan;
use App\Models\Layanan;
use App\Models\Pesanan;
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
        Schema::create('status_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pesanan::class, 'id_pesanan');
            $table->string('status', 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pesanan');
    }
};
