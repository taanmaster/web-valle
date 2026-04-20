<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BillableService;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function index()
    {
        $services  = BillableService::where('is_active', true)->orderBy('name')->get();
        $cart      = Auth::user()->cart()->with('items')->first();
        $cartCount = $cart ? $cart->items->sum('quantity') : 0;

        return view('front.services.index', compact('services', 'cartCount'));
    }
}
