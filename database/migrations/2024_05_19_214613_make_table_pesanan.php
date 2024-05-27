<?php

use App\Models\Karyawan;
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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Karyawan::class, 'id_kasir');
            $table->integer('uang');
            $table->integer('kembalian');
            $table->integer('total')->default(0);
            // status = process, ready, done
            $table->string('status', 7)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
