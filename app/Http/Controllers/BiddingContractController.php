<?php

namespace App\Http\Controllers;

use App\Models\BiddingContract;
use Illuminate\Http\Request;

class BiddingContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mode = 0;

        return view('acquisitions.contracts.index')->with('mode', $mode);
    }

    public function closed()
    {
        $mode = 1;

        return view('acquisitions.contracts.closed')->with('mode', $mode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BiddingContract $biddingContract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BiddingContract $biddingContract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BiddingContract $biddingContract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BiddingContract $biddingContract)
    {
        //
    }
}
