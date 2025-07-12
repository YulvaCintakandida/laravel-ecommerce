<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Banner as BannerModel;

class Banner extends Component
{
    public $activeBanners;

    public function __construct()
    {
        $this->activeBanners = BannerModel::where('is_view', true)->get();
    }

    public function render()
    {
        return view('components.banner');
    }
}