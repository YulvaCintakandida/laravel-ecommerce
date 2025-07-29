<?php
// app/Filament/Widgets/TopCustomersChartWidget.php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopCustomersChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Pelanggan Terbaik';

    protected static ?int $sort = 4;
    
    protected int|string|array $columnSpan = 'full';

    // Filter string
    public ?string $filter = null;

    protected function getFilters(): ?array
    {
        $filters = [];

        // Ambil tahun terkecil dan terbesar dari data Order
        $minYear = Order::min(DB::raw('YEAR(created_at)')) ?? now()->year;
        $maxYear = Order::max(DB::raw('YEAR(created_at)')) ?? now()->year;

        for ($year = $minYear; $year <= $maxYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $key = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT);
                $filters[$key] = Carbon::create($year, $month)->translatedFormat('F Y');
            }
        }

        return $filters;
    }

    protected function getData(): array
    {
        // Default: bulan dan tahun saat ini
        $selectedMonth = now()->month;
        $selectedYear = now()->year;

        if ($this->filter && preg_match('/(\d{4})-(\d{2})/', $this->filter, $matches)) {
            $selectedYear = (int) $matches[1];
            $selectedMonth = (int) $matches[2];
        }

        // Get top customers for the selected month - limit to top 10
        $topCustomers = Order::select('user_id', DB::raw('COUNT(*) as order_count'))
            ->where('status', 'completed')
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth)
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('order_count')
            ->limit(10)
            ->get();

        $labels = [];
        $data = [];
        $colors = [
            '#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56', '#9966FF',
            '#FF9F40', '#C9CBCF', '#7FD8BE', '#F7A1A1', '#5EBFA5'
        ];

        foreach ($topCustomers as $customer) {
            if ($customer->user) {
                $labels[] = mb_substr($customer->user->name, 0, 20) . (mb_strlen($customer->user->name) > 20 ? '...' : '');
                $data[] = $customer->order_count;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Order',
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Pelanggan',
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Order',
                    ],
                ],
            ],
        ];
    }
    
    // Heading dinamis berdasarkan filter
    public function getHeading(): string
    {
        if (!$this->filter) {
            return static::$heading ?? 'Pelanggan Terbaik';
        }
        
        if (preg_match('/(\d{4})-(\d{2})/', $this->filter, $matches)) {
            $year = (int) $matches[1];
            $month = (int) $matches[2];
            return 'Pelanggan Terbaik - ' . Carbon::create($year, $month)->translatedFormat('F Y');
        }
        
        return static::$heading ?? 'Pelanggan Terbaik';
    }
}