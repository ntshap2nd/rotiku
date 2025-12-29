<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rotiku - Toko Roti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-8">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-amber-700">Rotiku</h1>

            <a href="{{ url('/admin') }}" class="text-sm text-gray-500 hover:underline">
                Login Admin
            </a>
        </header>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-xl font-semibold mb-4">Daftar Roti</h2>

        {{-- Jika belum ada produk --}}
        @if($produks->count() === 0)
            <p class="text-gray-500">Belum ada produk yang tersedia.</p>
        @else
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($produks as $produk)
                    <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">

                        {{-- Gambar produk --}}
                        @if($produk->gambar)
                            <img
                                src="{{ asset('storage/' . $produk->gambar) }}"
                                alt="{{ $produk->nama }}"
                                class="w-full h-40 object-cover rounded mb-3"
                            >
                        @endif

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $produk->nama }}</h3>

                            @if($produk->kategori)
                                <p class="text-xs text-gray-500 mb-1">
                                    Kategori: {{ $produk->kategori }}
                                </p>
                            @endif

                            <p class="text-amber-700 font-semibold">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                Stok: {{ $produk->stok }}
                            </p>
                        </div>

                        {{-- Tombol beli --}}
                        <div class="mt-4">
                            @if($produk->stok > 0)
                                <a href="{{ route('shop.order.form', $produk) }}"
                                   class="inline-block bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold px-4 py-2 rounded">
                                    Beli
                                </a>
                            @else
                                <span class="inline-block bg-gray-300 text-gray-600 text-sm font-semibold px-4 py-2 rounded">
                                    Habis
                                </span>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
