<?php
// app/Filament/Widgets/TopProductsChartWidget.php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopProductsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Produk Terlaris';

    protected static ?int $sort = 3;
    
    protected int|string|array $columnSpan = 'full';

    // Ganti filter properties dengan satu filter string
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

        // HAPUS BARIS INI:
        // $this->heading = 'Produk Terlaris - ' . Carbon::create($selectedYear, $selectedMonth)->translatedFormat('F Y');

        // Get top selling products for the selected month - limit to top 10
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) use ($selectedYear, $selectedMonth) {
                $query->where('status', 'completed')
                    ->whereYear('created_at', $selectedYear)
                    ->whereMonth('created_at', $selectedMonth);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->limit(10)
            ->get();

        $labels = [];
        $data = [];
        $colors = [
            '#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56', '#9966FF',
            '#FF9F40', '#C9CBCF', '#7FD8BE', '#F7A1A1', '#5EBFA5'
        ];

        foreach ($topProducts as $index => $item) {
            if ($item->product) {
                $labels[] = mb_substr($item->product->name, 0, 20) . (mb_strlen($item->product->name) > 20 ? '...' : '');
                $data[] = $item->total_quantity;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
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
                        'text' => 'Produk',
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Terjual',
                    ],
                ],
            ],
        ];
    }
    
    // Jika ingin menggunakan heading dinamis
    public function getHeading(): string
    {
        if (!$this->filter) {
            return static::$heading ?? 'Produk Terlaris';
        }
        
        if (preg_match('/(\d{4})-(\d{2})/', $this->filter, $matches)) {
            $year = (int) $matches[1];
            $month = (int) $matches[2];
            return 'Produk Terlaris - ' . Carbon::create($year, $month)->translatedFormat('F Y');
        }
        
        return static::$heading ?? 'Produk Terlaris';
    }
}