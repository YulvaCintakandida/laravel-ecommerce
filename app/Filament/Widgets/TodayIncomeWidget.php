<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodayIncomeWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $todayIncome = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');

        $todayOrders = Order::whereDate('created_at', today())->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($todayIncome, 0, ',', '.'))
                ->description('Total pendapatan dari pesanan yang selesai')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            
            Stat::make('Pesanan Hari Ini', $todayOrders)
                ->description('Jumlah pesanan hari ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Pesanan Pending', $pendingOrders)
                ->description('Menunggu diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}