<!DOCTYPE html>
<html>
<head>
    <title>Order #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        .table th, .table td { padding: 0.5rem; border: 1px solid #ddd; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Order #{{ $order->id }}</h1>
    
    <div style="margin-bottom: 2rem;">
        <h3>Customer Information</h3>
        <p>{{ $order->user->name }}<br>
        {{ $order->user->email }}<br>
        {{ $order->user->phone }}<br>
        {{ $order->user->address }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-right">Price</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right font-bold">Subtotal:</td>
                <td class="text-right">Rp {{ number_format($order->total + $order->discount_amount, 2, ',', '.') }}</td>
            </tr>
            @if($order->voucher)
                <tr>
                    <td colspan="3" class="text-right font-bold">Discount ({{ $order->voucher->code }}):</td>
                    <td class="text-right">-Rp {{ number_format($order->discount_amount, 2, ',', '.') }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="3" class="text-right font-bold">Total:</td>
                <td class="text-right font-bold">Rp {{ number_format($order->total, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>