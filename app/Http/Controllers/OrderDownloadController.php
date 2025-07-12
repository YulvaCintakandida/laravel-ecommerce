<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderDownloadController extends Controller
{
    public function __invoke(Order $order)
    {
        $pdf = Pdf::loadView('pdf.order', compact('order'));
        return $pdf->download("order-{$order->id}.pdf");
    }
}