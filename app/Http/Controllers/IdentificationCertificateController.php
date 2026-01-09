<?php

namespace App\Http\Controllers;

use App\Models\IdentificationCertificate;
use Illuminate\Http\Request;

class IdentificationCertificateController extends Controller
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
        return view('identification_certificates.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $certificate = IdentificationCertificate::findOrFail($id);
        return view('identification_certificates.show', compact('certificate'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $certificate = IdentificationCertificate::findOrFail($id);
        $certificate->delete();

        return redirect()->route('identification_certificates.index')
            ->with('message', 'Constancia eliminada correctamente.');
    }
}
