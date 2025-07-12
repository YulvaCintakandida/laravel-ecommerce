@extends('layouts.app')

@section('content')
    <div>
        <!-- Breadcrumbs -->
        <x-breadcrumb :items="[
            ['title' => 'My Orders', 'url' => route('orders.index'), 'icon' => 'heroicon-o-shopping-bag'],
            ['title' => 'Order #' . $order->id, 'current' => true, 'icon' => 'heroicon-o-envelope']
        ]" class="mb-6"/>

        <!-- Order Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold mb-2">Order #{{ $order->id }}</h1>
                <p class="text-gray-500">
                    <span>Placed on {{ $order->created_at->format('d M Y \a\t H:i') }}</span>
                </p>
            </div>

            <div class="mt-4 md:mt-0">
                @if($order->status == 'completed')
                    <div class="badge badge-soft badge-success gap-2 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ ucfirst($order->status) }}
                    </div>
                @elseif($order->status == 'processing')
                    <div class="badge badge-soft badge-warning gap-2 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ ucfirst($order->status) }}
                    </div>
                @elseif($order->status == 'canceled')
                    <div class="badge badge-soft badge-error gap-2 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ ucfirst($order->status) }}
                    </div>
                @else
                    <div class="badge badge-soft badge-neutral p-3">
                        {{ ucfirst($order->status) }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Information Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Order Summary -->
            <div class="card bg-base-100 shadow-lg border border-base-300 h-full">
                <div class="card-body">
                    <h2 class="card-title flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Order Summary
                    </h2>
                    <div class="divider my-1"></div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-medium">{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span>{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Time:</span>
                            <span>{{ $order->created_at->format('H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span>{{ $order->payment_method ?? 'Online Payment' }}</span>
                        </div>
                        @if($order->payment_status)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status:</span>
                                <span
                                    class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card bg-base-100 shadow-lg border border-base-300 h-full">
                <div class="card-body">
                    <h2 class="card-title flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Shipping Address
                    </h2>
                    <div class="divider my-1"></div>
                    <address class="not-italic">
                        <!-- <p class="font-medium">{{ $order->user->name }}</p> -->
                        <p>{{ $order->user->address }}</p>
                        <p class="mt-2">{{ $order->user->phone }}</p>
                    </address>
                </div>
            </div>

            <!-- Order Status -->
            <div class="card bg-base-100 shadow-lg border border-base-300 h-full">
                <div class="card-body">
                    <h2 class="card-title flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Order Status
                    </h2>
                    <div class="divider my-1"></div>

                    <div class="mb-2">
                        <div class="text-sm text-gray-500">Order placed on:</div>
                        <div class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    <ul class="steps steps-vertical">
                        <li class="step step-primary">Order Placed</li>
                        <li class="step {{ in_array($order->status, ['processing', 'completed']) ? 'step-primary' : '' }}">
                            Processing
                        </li>
                        <li class="step {{ $order->status == 'completed' ? 'step-primary' : '' }}">Completed</li>
                    </ul>

                    <div class="mt-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span
                                class="font-bold text-primary">Rp {{ number_format($order->total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card bg-base-100 shadow-lg border border-base-300 mb-8">
            <div class="card-body">
                <h2 class="card-title flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Order Items
                </h2>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="flex items-center gap-3">
                                    @if(isset($item->product->image))
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                             class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-base-300 rounded flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-medium">{{ $item->product->name }}</div>
                                        @if(isset($item->product->category))
                                            <div
                                                class="text-xs text-gray-500">{{ $item->product->category->name }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-right">
                                    Rp {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" class="text-right font-bold">Subtotal:</td>
                            <td class="text-right">
                                Rp {{ number_format($order->total + $order->discount_amount, 2, ',', '.') }}</td>
                        </tr>
                        @if($order->voucher)
                            <tr>
                                <td colspan="3" class="text-right font-bold">
                                    Discount ({{ $order->voucher->code }}):
                                </td>
                                <td class="text-right text-success">
                                    - Rp {{ number_format($order->discount_amount, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-right text-lg font-bold">Total:</td>
                            <td class="text-right text-lg font-bold text-primary">
                                Rp {{ number_format($order->total, 2, ',', '.') }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap justify-between gap-4 mb-8">
            <a href="{{ route('orders.index') }}"
               class="btn btn-outline text-primary border-primary hover:bg-primary hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Back to Orders
            </a>

            <div>
                @if($order->status === 'pending')
                    @if($order->payment_url)
                        <a href="{{ $order->payment_url }}" class="btn btn-primary gap-2 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                            </svg>
                            Continue Payment
                        </a>
                    @endif
                    
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-error gap-2 mr-2" onclick="return confirm('Are you sure you want to cancel this order?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel Order
                        </button>
                    </form>
                @endif
                <button class="btn bg-primary text-white hover:bg-primary-focus" onclick="window.print()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Order
                </button>
            </div>
        </div>
    </div>
@endsection
