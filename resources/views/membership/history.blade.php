<!-- resources/views/membership/history.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Membership Transaction History</h1>
    
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Plan</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>{{ $transaction->membershipPlan->name }}</td>
                        <td>Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>
                            @if($transaction->status == 'completed')
                                <span class="badge badge-success">Completed</span>
                            @elseif($transaction->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-error">Failed</span>
                            @endif
                        </td>
                        <td>{{ $transaction->expires_at ? $transaction->expires_at->format('d M Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
    
    <div class="mt-8">
        <a href="{{ route('membership.index') }}" class="btn btn-primary">Back to Membership Plans</a>
    </div>
</div>
@endsection