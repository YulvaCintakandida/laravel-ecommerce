<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class TodayIncomeWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    
    protected int|string|array $columnSpan = 'full';
    
    // Filter properties
    public $month;
    public $year;
    
    public function mount()
    {
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('month')
                ->options([
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December',
                ])
                ->default(Carbon::now()->month)
                ->reactive()
                ->afterStateUpdated(fn () => $this->refreshStats()),
                
            Select::make('year')
                ->options(function () {
                    $years = [];
                    $currentYear = Carbon::now()->year;
                    for ($i = $currentYear - 2; $i <= $currentYear; $i++) {
                        $years[$i] = $i;
                    }
                    return $years;
                })
                ->default(Carbon::now()->year)
                ->reactive()
                ->afterStateUpdated(fn () => $this->refreshStats()),
        ];
    }
    protected function getStats(): array
    {
        $todayIncome = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');

        $todayOrders = Order::whereDate('created_at', today())->count();

        $pendingOrders = Order::where('status', 'settlement')->count();

        $monthlyRevenue = Order::where('status', Order::STATUS_COMPLETED)
        ->whereYear('created_at', $this->year)
        ->whereMonth('created_at', $this->month)
        ->sum('total');

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
            // Get monthly revenue
            Stat::make('Pendapatan ' . Carbon::createFromDate($this->year, $this->month, 1)->format('M Y'), 
            'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))                ->description('Total pendapatan dari pesanan yang selesai bulan ini')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}