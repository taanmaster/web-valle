<?php

namespace App\Http\Controllers;

use App\Imports\PanteonImport;
use App\Models\Panteon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PanteonController extends Controller
{
    public function index()
    {
        return view('panteones.index');
    }

    public function create()
    {
        return view('panteones.create', [
            'mode' => 0,
        ]);
    }

    public function show($id)
    {
        $panteon = Panteon::findOrFail($id);

        return view('panteones.show', [
            'panteon' => $panteon,
            'mode' => 1,
        ]);
    }

    public function edit($id)
    {
        $panteon = Panteon::findOrFail($id);

        return view('panteones.edit', [
            'panteon' => $panteon,
            'mode' => 2,
        ]);
    }

    public function destroy($id)
    {
        $panteon = Panteon::findOrFail($id);
        $panteon->delete();

        return redirect()->route('panteones.admin.index')->with('success', 'Registro eliminado correctamente.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file'        => 'required|file|mimes:csv,xls,xlsx',
            'confirm_duplicates' => 'accepted',
        ]);

        $import = new PanteonImport();

        try {
            DB::transaction(function () use ($import, $request) {
                Excel::import($import, $request->file('import_file'));
            });

            if ($import->missingColumns !== []) {
                return redirect()->route('panteones.admin.index')->with(
                    'error',
                    'No se realizó la importación. Faltan las columnas: ' . implode(', ', $import->missingColumns) . '.'
                );
            }

            $redirect = redirect()->route('panteones.admin.index')->with(
                'success',
                "Importación completada: {$import->created} registros creados."
            );

            if ($import->rowErrors !== []) {
                $redirect->with('panteon_import_row_errors', $import->rowErrors);
            }

            return $redirect;
        } catch (\Throwable $exception) {
            return redirect()->route('panteones.admin.index')->with(
                'error',
                'No fue posible importar el archivo. Verifica el formato e inténtalo nuevamente.'
            );
        }
    }
}
