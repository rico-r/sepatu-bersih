<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_kasir',
        'total',
        'uang',
        'kembalian',
    ];


    function rincian()
    {
        return $this->hasMany(RincianPesanan::class, 'id_pesanan');
    }

    function kasir()
    {
        return $this->belongsTo(Karyawan::class, 'id_kasir');
    }

    function status_view()
    {
        switch ($this->status) {
            case 'process':
                return 'diproses';
            case 'ready':
                return 'selesai';
            default:
                return 'diambil';
        }
    }
}
