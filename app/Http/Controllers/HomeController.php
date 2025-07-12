<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Flavour;
use App\Models\Banner;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
        public function index()
    {
        $activeBanners = Banner::where('is_view', true)->get();
        $availableVouchers = Voucher::where('end_date', '>', now())->get();
        $categories = Category::withCount('products')->get();
        $flavours = Flavour::withCount('products')->get();
        $bestSellers = Product::select('products.*')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByRaw('COUNT(order_items.id) DESC')
            ->limit(4)
            ->get();
        $latestProducts = Product::latest()->limit(8)->get();
    
        return view('home', compact(
            'activeBanners',
            'availableVouchers', 
            'bestSellers', 
            'latestProducts', 
            'categories', 
            'flavours'
        ));
    }
}
