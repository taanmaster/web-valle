<?php

namespace App\Http\Controllers;

// Ayudantes
use App\Models\FiscWorker;
use Illuminate\Http\Request;
// Modelos
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class FiscWorkerController extends Controller
{
    /**
     * Mostrar listado de personal de Fiscalización
     */
    public function index()
    {
        $workers = FiscWorker::orderBy('name', 'asc')
            ->orderBy('last_name', 'asc')
            ->paginate(10);

        return view('fiscalizacion.workers.index')
            ->with('workers', $workers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fiscalizacion.workers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_number' => 'nullable|unique:fisc_workers',
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'issue_date' => 'nullable|date',
            'validity_date_start' => 'nullable|date',
            'validity_date_end' => 'nullable|date',
            'position' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:20',
            'extension' => 'nullable|max:10',
            'profile_photo' => 'nullable|image|max:5120', // 5MB max
        ]);

        $worker = new FiscWorker([
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
        ]);

        // Guardar foto de perfil en S3
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $filename = 'worker_'.Str::slug($request->name.'_'.$request->last_name).'_'.time().'.'.$photo->getClientOriginalExtension();
            $filepath = 'fiscalizacion/workers/'.$filename;

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

        Session::flash('success', 'El trabajador se creó exitosamente.');

        return redirect()->route('fiscalizacion.workers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $worker = FiscWorker::findOrFail($id);

        return view('fiscalizacion.workers.edit')
            ->with('worker', $worker);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $worker = FiscWorker::findOrFail($id);

        $this->validate($request, [
            'employee_number' => 'nullable|unique:fisc_workers,employee_number,'.$id,
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'issue_date' => 'nullable|date',
            'validity_date_start' => 'nullable|date',
            'validity_date_end' => 'nullable|date',
            'position' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:20',
            'extension' => 'nullable|max:10',
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
            $filename = 'worker_'.Str::slug($request->name.'_'.$request->last_name).'_'.time().'.'.$photo->getClientOriginalExtension();
            $filepath = 'fiscalizacion/workers/'.$filename;

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

        return redirect()->route('fiscalizacion.workers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $worker = FiscWorker::findOrFail($id);

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
}
