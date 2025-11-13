<?php

namespace App\Http\Controllers;

use App\Models\SupplierMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(SupplierMessage $supplierMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplierMessage $supplierMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupplierMessage $supplierMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierMessage $supplierMessage)
    {
        //
    }

    /**
     * Marcar mensaje como leído
     */
    public function markAsRead($id)
    {
        $message = SupplierMessage::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $message->update(['status' => 'read']);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje marcado como leído'
        ]);
    }

    /**
     * Archivar mensaje
     */
    public function archive($id)
    {
        $message = SupplierMessage::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $message->update(['status' => 'archived']);

        return back()->with('success', 'Mensaje archivado correctamente.');
    }

    /**
     * Desarchivar mensaje
     */
    public function unarchive($id)
    {
        $message = SupplierMessage::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $message->update(['status' => 'read']);

        return back()->with('success', 'Mensaje restaurado correctamente.');
    }
}
