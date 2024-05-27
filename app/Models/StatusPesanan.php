<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class StatusPesanan extends Model
{
    use HasFactory;
    protected $table = 'status_pesanan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pesanan',
        'status',
    ];

    protected static function booted(): void
    {
        static::deleted(function (StatusPesanan $statusPesanan) {
            $pesanan = Pesanan::with('detail_status')->find($statusPesanan->id_pesanan);
            $pesanan->status = $pesanan->detail_status->last()->status;
            $pesanan->save();
        });
        static::created(function (StatusPesanan $statusPesanan) {
            $pesanan = Pesanan::find($statusPesanan->id_pesanan);
            $pesanan->status = $statusPesanan->status;
            $pesanan->save();
        });
    }
}
