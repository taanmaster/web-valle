<?php

namespace App\Http\Controllers;

use App\Models\DocumentCertificate;
use Illuminate\Http\Request;

class DocumentCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('document_certificates.index');
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
    public function show($id)
    {
        $certificate = DocumentCertificate::findOrFail($id);
        return view('document_certificates.show', compact('certificate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentCertificate $documentCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentCertificate $documentCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $certificate = DocumentCertificate::findOrFail($id);
        $certificate->delete();

        return redirect()->route('document_certificates.index')
            ->with('message', 'Certificación eliminada correctamente.');
    }
}

