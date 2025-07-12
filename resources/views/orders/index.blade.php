@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-primary">My Orders</h1>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Shop More
            </a>
        </div>

        @if($orders->count() > 0)
            <div class="shadow-lg rounded-lg overflow-hidden border border-base-300 mb-6">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                        <tr class="bg-primary bg-opacity-10">
                            <th class="text-white">Order #</th>
                            <th class="text-white">Date</th>
                            <th class="text-white">Total</th>
                            <th class="text-white">Status</th>
                            <th class="text-center text-white">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="font-medium">{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td>Rp {{ number_format($order->total, 2, ',', '.') }}</td>
                                <td>
                                    @if($order->status == 'completed')
                                        <div class="badge badge-success badge-outline gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    @elseif($order->status == 'processing')
                                        <div class="badge badge-warning badge-outline gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    @elseif($order->status == 'canceled')
                                        <div class="badge badge-error badge-outline gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    @else
                                        <div class="badge badge-neutral badge-outline">
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="btn btn-primary btn-sm btn-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>

        @else
            <div class="card bg-base-100 shadow-xl border border-base-300 text-center p-12">
                <figure class="mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                         stroke="currentColor" class="w-24 h-24 text-primary text-opacity-50">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title text-2xl text-primary">No Orders Yet</h2>
                    <p class="text-gray-500 max-w-md mx-auto my-4">You haven't placed any orders yet. Start shopping to
                        see your order history here.</p>
                    <div class="card-actions">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                            Browse Products
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
