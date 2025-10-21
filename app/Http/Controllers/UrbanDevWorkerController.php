<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

// Modelos
use App\Models\UrbanDevWorker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Importaciones
use App\Imports\UrbanDevWorkerImport;
use Maatwebsite\Excel\Facades\Excel;

class UrbanDevWorkerController extends Controller
{
    /**
     * Mostrar listado de Inspectores
     */
    public function inspectors()
    {
        $workers = UrbanDevWorker::inspectors()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('urban_dev.workers.inspectors')
            ->with('workers', $workers);
    }

    /**
     * Mostrar listado de Peritos
     */
    public function experts()
    {
        $workers = UrbanDevWorker::experts()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('urban_dev.workers.experts')
            ->with('workers', $workers);
    }

    /**
     * Mostrar listado de Fiscalización
     */
    public function auditors()
    {
        $workers = UrbanDevWorker::auditors()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('urban_dev.workers.auditors')
            ->with('workers', $workers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urban_dev.workers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_number' => 'required|unique:urban_dev_workers',
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'issue_date' => 'required|date',
            'validity_date_start' => 'required|date',
            'validity_date_end' => 'nullable|date',
            'position' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:20',
            'extension' => 'nullable|max:10',
            'dependency_category' => 'required',
            'dependency_subcategory' => 'nullable',
            'profile_photo' => 'nullable|image|max:5120', // 5MB max
        ]);

        $worker = new UrbanDevWorker([
            'employee_number' => $request->employee_number,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'issue_date' => $request->issue_date,
            'validity_date_start' => $request->validity_date_start,
            'validity_date_end' => $request->validity_date_end,
            'position' => $request->position,
            'email' => $request->email,
            'phone' => $request->phone,
            'extension' => $request->extension,
            'dependency_category' => $request->dependency_category,
            'dependency_subcategory' => $request->dependency_subcategory,
        ]);

        // Guardar foto de perfil en S3
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $filename = 'worker_' . Str::slug($request->name . '_' . $request->last_name) . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $filepath = 'urban_dev_profiles/' . $filename;

            // Usar streaming para subir a S3
            $stream = fopen($photo->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $worker->s3_asset_url = Storage::disk('s3')->url($filepath);
            $worker->filesize = $photo->getSize();
        }

        $worker->save();

        // Si es un Inspector de Desarrollo Urbano, crear también el usuario
        if ($request->dependency_category == 'Desarrollo Urbano' && $request->dependency_subcategory == 'Inspector') {
            $this->validate($request, [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4',
            ]);

            $user = new User([
                'name' => $request->name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->save();
            $user->assignRole('inspector');
        }

        Session::flash('success', 'El trabajador se creó exitosamente.');

        // Redirigir según la categoría
        return $this->redirectToCategory($request->dependency_category, $request->dependency_subcategory);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $worker = UrbanDevWorker::findOrFail($id);

        return view('urban_dev.workers.show')
            ->with('worker', $worker);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $worker = UrbanDevWorker::findOrFail($id);

        return view('urban_dev.workers.edit')
            ->with('worker', $worker);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $worker = UrbanDevWorker::findOrFail($id);

        $this->validate($request, [
            'employee_number' => 'required|unique:urban_dev_workers,employee_number,' . $id,
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'issue_date' => 'required|date',
            'validity_date_start' => 'required|date',
            'validity_date_end' => 'nullable|date',
            'position' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:20',
            'extension' => 'nullable|max:10',
            'dependency_category' => 'required',
            'dependency_subcategory' => 'nullable',
            'profile_photo' => 'nullable|image|max:5120',
        ]);

        $worker->employee_number = $request->employee_number;
        $worker->name = $request->name;
        $worker->last_name = $request->last_name;
        $worker->issue_date = $request->issue_date;
        $worker->validity_date_start = $request->validity_date_start;
        $worker->validity_date_end = $request->validity_date_end;
        $worker->position = $request->position;
        $worker->email = $request->email;
        $worker->phone = $request->phone;
        $worker->extension = $request->extension;
        $worker->dependency_category = $request->dependency_category;
        $worker->dependency_subcategory = $request->dependency_subcategory;

        // Actualizar foto de perfil si se proporciona una nueva
        if ($request->hasFile('profile_photo')) {
            // Eliminar foto anterior de S3 si existe
            if ($worker->s3_asset_url) {
                $oldPath = parse_url($worker->s3_asset_url, PHP_URL_PATH);
                $oldPath = ltrim($oldPath, '/');
                if (Storage::disk('s3')->exists($oldPath)) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }

            $photo = $request->file('profile_photo');
            $filename = 'worker_' . Str::slug($request->name . '_' . $request->last_name) . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $filepath = 'urban_dev_profiles/' . $filename;

            // Usar streaming para subir a S3
            $stream = fopen($photo->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $worker->s3_asset_url = Storage::disk('s3')->url($filepath);
            $worker->filesize = $photo->getSize();
        }

        $worker->save();

        Session::flash('success', 'El trabajador se actualizó exitosamente.');

        // Redirigir según la categoría
        return $this->redirectToCategory($request->dependency_category, $request->dependency_subcategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $worker = UrbanDevWorker::findOrFail($id);

        // Eliminar foto de perfil de S3 si existe
        if ($worker->s3_asset_url) {
            $path = parse_url($worker->s3_asset_url, PHP_URL_PATH);
            $path = ltrim($path, '/');
            if (Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->delete($path);
            }
        }

        $worker->delete();

        Session::flash('success', 'El trabajador se eliminó exitosamente.');

        return redirect()->back();
    }

    /**
     * Redirigir a la vista correcta según la categoría del trabajador
     */
    private function redirectToCategory($category, $subcategory)
    {
        if ($category == 'Desarrollo Urbano') {
            if ($subcategory == 'Inspector') {
                return redirect()->route('urban_dev.workers.inspectors');
            } elseif ($subcategory == 'Perito') {
                return redirect()->route('urban_dev.workers.experts');
            }
        } elseif ($category == 'Fiscalización') {
            return redirect()->route('urban_dev.workers.auditors');
        }

        // Por defecto, redirigir a inspectores
        return redirect()->route('urban_dev.workers.inspectors');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'import_file' => 'required|file|mimes:xlsx,xls,csv',
            'dependency_category' => 'required|in:Peritos,Inspectores,Fiscalización',
        ]);

        $archivo = $request->file('import_file');
        $dependency_category = $request->input('dependency_category');
        
        $filename_excel = 'excel_importado_' . Carbon::now()->format('d_m_y_H_m_s') . '.'. $archivo->getClientOriginalExtension();
        $location = public_path('excel/');
        $archivo->move($location, $filename_excel);

        try {
            Excel::import(new UrbanDevWorkerImport($dependency_category), public_path('excel/' . $filename_excel));

            // Mensaje de session
            Session::flash('success', 'La información se importó a tu base de datos sin errores. Los registros repetidos fueron ignorados automáticamente.');

            // Redirigir según la categoría seleccionada
            if ($dependency_category == 'Fiscalización') {
                return redirect()->route('urban_dev.workers.auditors');
            } elseif ($dependency_category == 'Peritos') {
                return redirect()->route('urban_dev.workers.experts');
            } else {
                return redirect()->route('urban_dev.workers.inspectors');
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = 'Fila ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            Session::flash('error', 'Hubo errores en la importación: ' . implode(' | ', $errors));

            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', 'Error al importar el archivo: ' . $e->getMessage());
            
            return redirect()->back();
        }
    }
}
