<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beli {{ $produk->nama }} - Rotiku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    <div class="max-w-md mx-auto py-8">
        <a href="{{ route('shop.index') }}" class="text-sm text-gray-500 hover:underline">
            &larr; Kembali ke daftar roti
        </a>

        <h1 class="text-2xl font-bold text-amber-700 mt-4 mb-2">
            Beli {{ $produk->nama }}
        </h1>

        <div class="bg-white shadow rounded-lg p-4 mb-4">
            <p class="font-semibold text-gray-800">{{ $produk->nama }}</p>
            @if($produk->kategori)
                <p class="text-xs text-gray-500 mb-1">Kategori: {{ $produk->kategori }}</p>
            @endif
            <p class="text-amber-700 font-semibold">
                Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </p>
            <p class="text-sm text-gray-600">
                Stok tersedia: {{ $produk->stok }}
            </p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('shop.order.store', $produk) }}" method="POST" class="bg-white shadow rounded-lg p-4 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Pelanggan
                </label>
                <input type="text" name="nama_pelanggan"
                       value="{{ old('nama_pelanggan') }}"
                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Jumlah (Qty)
                </label>
                <input type="number" name="qty" min="1"
                       value="{{ old('qty', 1) }}"
                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2 rounded text-sm">
                Buat Pesanan
            </button>
        </form>
    </div>
    <div class="bg-white shadow rounded-lg p-4 mb-4">
    @if($produk->gambar)
        <img src="{{ asset('storage/' . $produk->gambar) }}"
             alt="{{ $produk->nama }}"
             class="w-full h-48 object-cover rounded mb-3">
    @endif

    <p class="font-semibold text-gray-800">{{ $produk->nama }}</p>
    @if($produk->kategori)
        <p class="text-xs text-gray-500 mb-1">Kategori: {{ $produk->kategori }}</p>
    @endif
    <p class="text-amber-700 font-semibold">
        Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}
    </p>
    <p class="text-sm text-gray-600">
        Stok tersedia: {{ $produk->stok }}
    </p>
</div>

</body>
</html>
