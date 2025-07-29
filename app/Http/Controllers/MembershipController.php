<?php
// app/Http/Controllers/MembershipController.php
namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Midtrans\Transaction;

class MembershipController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }
    
    public function index()
    {
        $plans = MembershipPlan::where('is_active', true)->get();
        $user = Auth::user();
        
        return view('membership.index', compact('plans', 'user'));
    }
    
    public function checkout($planId)
    {
        $plan = MembershipPlan::findOrFail($planId);
        $user = Auth::user();
        
        // Cek apakah user sudah memiliki membership aktif
        if ($user->hasActiveMembership()) {
            return redirect()->route('membership.index')
                ->with('warning', 'Anda sudah memiliki membership VIP yang aktif hingga ' . 
                    $user->membership_expires_at->format('d M Y') . '.');
        }
        
        return view('membership.checkout', compact('plan', 'user'));
    }
    
    public function process(Request $request, $planId)
    {
        $plan = MembershipPlan::findOrFail($planId);
        $user = Auth::user();
        
        // Cek apakah user sudah memiliki membership aktif
        if ($user->hasActiveMembership()) {
            return redirect()->route('membership.index')
                ->with('warning', 'Anda sudah memiliki membership VIP yang aktif hingga ' . 
                       $user->membership_expires_at->format('d M Y') . '.');
        }
        
        DB::beginTransaction();
        try {
            // Create membership transaction record
            $transaction = MembershipTransaction::create([
                'user_id' => $user->id,
                'membership_plan_id' => $plan->id,
                'amount' => $plan->price,
                'status' => 'pending',
                'expires_at' => Carbon::now()->addMonths($plan->duration_months),
            ]);
            
            $paymentUrl = $this->createMidtransTransaction($transaction);
            
            // Update transaction with payment URL
            $transaction->update(['payment_url' => $paymentUrl]);
            
            DB::commit();
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('membership.index')
                ->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    
    private function createMidtransTransaction(MembershipTransaction $transaction)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'MEMBER-' . $transaction->id,
                'gross_amount' => $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone,
            ],
            'item_details' => [
                [
                    'id' => $transaction->membershipPlan->id,
                    'price' => $transaction->amount,
                    'quantity' => 1,
                    'name' => $transaction->membershipPlan->name,
                ]
            ],
            'callbacks' => [
                'finish' => route('membership.finish', ['transaction' => $transaction->id]),
                'error' => route('membership.error', ['transaction' => $transaction->id]),
            ],
            'notification_url' => route('membership.notification'),
        ];
        
        $response = Snap::createTransaction($params);
        return $response->redirect_url;
    }
    
    public function notification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();
            
            $orderId = $notification->order_id;
            $transactionId = str_replace('MEMBER-', '', $orderId);
            $transactionStatus = $notification->transaction_status;
            
            $transaction = MembershipTransaction::findOrFail($transactionId);
            
            // Check real status via Midtrans API
            $status = Transaction::status($orderId);
            
            if ($status->transaction_status === 'settlement') {
                $transaction->status = 'completed';
                $transaction->transaction_id = $status->transaction_id;
                $transaction->save();
                
                // Update user membership status
                $user = $transaction->user;
                $user->membership_type = 'vip';
                $user->membership_expires_at = $transaction->expires_at;
                $user->save();
            } elseif ($status->transaction_status === 'expire' || $status->transaction_status === 'cancel' || $status->transaction_status === 'deny') {
                $transaction->status = 'failed';
                $transaction->save();
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            \Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
    
    public function finish(MembershipTransaction $transaction)
    {
        try {
            $status = Transaction::status('MEMBER-' . $transaction->id);
            
            if ($status->transaction_status === 'settlement') {
                $transaction->status = 'completed';
                $transaction->transaction_id = $status->transaction_id;
                $transaction->save();
                
                // Update user membership status
                $user = $transaction->user;
                $user->membership_type = 'vip';
                $user->membership_expires_at = $transaction->expires_at;
                $user->save();
                
                return redirect()->route('membership.index')
                    ->with('success', 'Congratulations! Your VIP Membership is now active.');
            }
            
            return redirect()->route('membership.index')
                ->with('info', 'Your payment is being processed. Membership will be activated soon.');
                
        } catch (\Exception $e) {
            \Log::error('Payment finish error: ' . $e->getMessage());
            return redirect()->route('membership.index')
                ->with('error', 'Unable to check payment status.');
        }
    }
    
    public function error(MembershipTransaction $transaction)
    {
        return redirect()->route('membership.index')
            ->with('error', 'Payment was not completed. You can try again.');
    }
    
    public function history()
    {
        $transactions = Auth::user()->membershipTransactions()
            ->with('membershipPlan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('membership.history', compact('transactions'));
    }
}