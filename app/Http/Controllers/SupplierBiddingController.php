<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use Illuminate\Http\Request;

class SupplierBiddingController extends Controller
{
    public function index()
    {
        return view('front.user_profiles.supplier.biddings.index');
    }

    public function show($id) {

        $mode = 3;
        $bidding = Bidding::findOrFail($id);

        return view('front.user_profiles.supplier.biddings.show', [
            'mode' => $mode,
            'bidding' => $bidding,
        ]);
    }
}
