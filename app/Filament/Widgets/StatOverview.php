<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatOverview extends BaseWidget
{
    // Opsional: kalau mau auto-refresh, bisa pakai polling
    // protected static ?string $pollingInterval = '10s';

    protected function getCards(): array
    {
        return [
            Card::make('Total Produk', Produk::count()),
            Card::make('Total Stok', Produk::sum('stok')),
            Card::make('Produk Aktif', Produk::where('aktif', true)->count()),
        ];
    }
}
