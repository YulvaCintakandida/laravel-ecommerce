<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesOverviewChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    // Aktifkan filter
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

        $sales = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->where('status', Order::STATUS_COMPLETED)
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $endDate = $startDate->copy()->endOfMonth();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $currentDate = $date->format('Y-m-d');
            $labels[] = $date->format('d M');
            $saleForDate = $sales->firstWhere('date', $currentDate);
            $data[] = $saleForDate ? (float) $saleForDate->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan (Rp)',
                    'data' => $data,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#2589d8',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
