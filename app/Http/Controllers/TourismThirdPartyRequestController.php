<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TourismThirdPartyRequest;

class TourismThirdPartyRequestController extends Controller
{
    public function index()
    {
        return view('tourism.third_party_requests.index', [
            'requests' => TourismThirdPartyRequest::latest()->paginate(10),
        ]);
    }

    public function show($id)
    {
        $request = TourismThirdPartyRequest::findOrFail($id);

        $mode = 1;

        return view('tourism.third_party_requests.show', [
            'request' => $request,
            'mode' => $mode,
        ]);
    }

    public function destroy($id)
    {
        $request = TourismThirdPartyRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('tourism.third_party_requests.admin.index')->with('success', 'Solicitud eliminada correctamente.');
    }
}
