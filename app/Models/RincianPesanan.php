<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RincianPesanan extends Model
{
    use HasFactory;
    protected $table = 'rincian_pesanan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pesanan',
        'id_layanan',
        'jumlah',
        'harga',
        'subtotal',
    ];

    function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }

    protected static function booted(): void
    {
        static::creating(function (RincianPesanan $rincianPesanan) {
            $rincianPesanan->subtotal = $rincianPesanan->harga * $rincianPesanan->jumlah;
        });
        static::created(function (RincianPesanan $rincianPesanan) {
            $pesanan = Pesanan::find($rincianPesanan->id_pesanan);
            $pesanan->total += $rincianPesanan->subtotal;
            $pesanan->save();
        });
    }
}
