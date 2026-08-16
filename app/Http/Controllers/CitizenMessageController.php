<?php

namespace App\Http\Controllers;

use App\Models\CitizenMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitizenMessageController extends Controller
{
    /**
     * Envía un mensaje a un ciudadano desde el backoffice. Genérico: cualquier
     * módulo con un botón "Contactar al Solicitante" apunta aquí, opcionalmente
     * ligando el mensaje a la solicitud que lo originó.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
            'related_model_type' => 'nullable|string|max:255',
            'related_model_id' => 'nullable|integer',
        ]);

        CitizenMessage::create([
            'user_id' => $request->user_id,
            'sent_by' => Auth::id(),
            'subject' => $request->subject,
            'body' => $request->body,
            'related_model_type' => $request->related_model_type,
            'related_model_id' => $request->related_model_id,
        ]);

        return back()->with('success', 'Mensaje enviado al ciudadano.');
    }
}
