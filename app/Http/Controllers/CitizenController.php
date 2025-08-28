<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\Citizen;
use App\Models\CitizenFile;
use App\Models\FinancialSupport;

// Importaciones
use App\Imports\CitizenImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index()
    {
        $citizens = Citizen::paginate(10);

        return view('citizens.index')->with('citizens', $citizens);
    }

    public function create()
    {
        return view('citizens.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $citizen = Citizen::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'curp' => $request->curp,
            'ine_number' => $request->ine_number,
            'ine_section' => $request->ine_section,
            'street' => $request->address,
            'colony' => $request->colony,
        ]);

        // Guardar archivo
        if ($request->hasFile('document')) {
            // Guardar datos en la base de datos
            $file = new CitizenFile;
            $file->citizen_id = $citizen->id;
            $file->name = $request->name;
            $file->slug = Str::slug('gaceta_' .  $request->name . '_' . $request->document_number);
            $file->description = $request->description;

            $document = $request->file('document');
            $filename = 'gaceta_' .  $request->name . '_' . $request->document_number . '.' . $document->getClientOriginalExtension();
            $location = public_path('files/citizens/');
            $document->move($location, $filename);

            $file->filename = $filename;
            $file->file_extension = $document->getClientOriginalExtension();
            $file->uploaded_by = Auth::user()->id;

            $file->save();
        }

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $citizen = Citizen::find($id);

        if (!$citizen) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ciudadano no encontrado'
                ], 404);
            }
            abort(404, 'Ciudadano no encontrado');
        }

        // Si la petición es AJAX, devolver JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'patient' => [
                    'id' => $citizen->id,
                    'name' => $citizen->name,
                    'curp' => $citizen->curp,
                    'phone' => $citizen->phone,
                    'email' => $citizen->email,
                    'address' => $citizen->address,
                    'ine_number' => $citizen->ine_number,
                    'ine_section' => $citizen->ine_section,
                    'address' => $citizen->address,
                ]
            ]);
        }

        // Si no es AJAX, devolver vista tradicional
        $files = CitizenFile::where('citizen_id', $id)->get();
        $financial_supports = FinancialSupport::where('citizen_id', $id)->get();

        return view('citizens.show')
            ->with('citizen', $citizen)
            ->with('files', $files)
            ->with('financial_supports', $financial_supports);
    }

    public function edit($id)
    {
        $citizen = Citizen::find($id);

        return view('citizens.edit')->with('citizen', $citizen);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
        ));

        $citizen = Citizen::find($id);

        $citizen->update([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'curp' => $request->curp,
            'ine_number' => $request->ine_number,
            'ine_section' => $request->ine_section,
            'street' => $request->street,
            'colony' => $request->colony,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $citizen = Citizen::find($id);
        $citizen->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->route('citizens.index');
    }

    public function import(Request $request)
    {
        $archivo = $request->file('import_file');
        $filename_excel = 'excel_importado_' . Carbon::now()->format('d_m_y_H_m_s') . '.'. $archivo->getClientOriginalExtension();
        $location = public_path('excel/');
        $archivo->move($location, $filename_excel);

        try {
            Excel::import(new CitizenImport, public_path('excel/' . $filename_excel));

            // Mensaje de session
            Session::flash('exito', 'La información se importó a tu base de datos sin errores. Los registros repetidos fueron ignorados automáticamente.');

            return redirect()->route('citizens.index');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator

                return redirect()->route('citizens.index')->with('errors', $errors);
            }
        }
    }
}
