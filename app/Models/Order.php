<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'produk_id',
        'nama_pelanggan',
        'qty',
        'total_harga',
        'status',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
