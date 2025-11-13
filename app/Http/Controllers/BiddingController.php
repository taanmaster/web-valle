<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use Illuminate\Http\Request;

class BiddingController extends Controller
{
    public function index()
    {
        return view('acquisitions.bidding.index');
    }

    public function create()
    {
        $mode = 0;

        return view('acquisitions.bidding.create')->with('mode', $mode);
    }

    public function show($id)
    {
        $bidding = Bidding::findOrFail($id);

        $mode = 1;

        return view('acquisitions.bidding.show')->with([
            'bidding' => $bidding,
            'mode' => $mode,
        ]);
    }

    public function edit($id)
    {
        $bidding = Bidding::findOrFail($id);
        $mode = 2;

        return view('acquisitions.bidding.edit')->with([
            'bidding' => $bidding,
            'mode' => $mode,
        ]);
    }

    public function destroy($id)
    {
        $bidding = Bidding::findOrFail($id);
        $bidding->delete();

        return redirect()->route('acquisitions.biddings.index')->with('success', 'Licitación eliminada correctamente.');
    }
}
