<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mode = 0;

        return view('service_requests.index')->with('mode', $mode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mode = 0;

        return view('service_requests.create')->with('mode', $mode);
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
    public function show($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $mode = 1; // Show mode
        return view('service_requests.show')->with([
            'request' => $request,
            'mode' => $mode
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $mode = 2; // Edit mode
        return view('service_requests.edit')->with([
            'request' => $request,
            'mode' => $mode
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('institucional_development.requests.index')->with('success', 'Service request deleted successfully.');
    }
}
