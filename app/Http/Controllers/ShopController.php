<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Halaman utama: daftar produk
    public function index()
    {
        $produks = Produk::where('aktif', true)->get();

        return view('shop.index', compact('produks'));
    }

    // Form pembelian produk tertentu
    public function orderForm(Produk $produk)
    {
        return view('shop.order', compact('produk'));
    }

    // Proses simpan order
    public function orderStore(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'qty' => 'required|integer|min:1',
        ]);

        // hitung total harga
        $qty = $validated['qty'];
        $total = $produk->harga * $qty;

        // optional: cek stok
        if ($qty > $produk->stok) {
            return back()->withErrors([
                'qty' => 'Stok tidak mencukupi. Stok tersedia: ' . $produk->stok,
            ])->withInput();
        }

        // simpan order
        Order::create([
            'produk_id'    => $produk->id,
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'qty'          => $qty,
            'total_harga'  => $total,
            'status'       => 'pending',
        ]);

        // kurangi stok
        $produk->decrement('stok', $qty);

        return redirect()
            ->route('shop.index')
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi toko.');
    }
}
