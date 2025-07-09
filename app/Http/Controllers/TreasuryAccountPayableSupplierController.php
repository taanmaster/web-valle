<?php

namespace App\Http\Controllers;

// Ayudantes

use App\Models\TapSupplierLog;
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TreasuryAccountPayableSupplier;

use Illuminate\Http\Request;

class TreasuryAccountPayableSupplierController extends Controller
{
    public function index()
    {
        $suppliers = TreasuryAccountPayableSupplier::paginate(10);

        return view('treasury_account_payable_suppliers.index')->with('suppliers', $suppliers);
    }

    public function create()
    {
        return view('treasury_account_payable_suppliers.create');
    }

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'rfc' => 'nullable|max:13',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:15',
            'account_name' => 'nullable|max:255',
            'account_number' => 'nullable|max:20',
            'bank_name' => 'nullable|max:255',
            'dependency_id' => 'nullable|integer',
            'status' => 'required|in:active,inactive,payed',
        ]);

        // Guardar datos en la base de datos
        TreasuryAccountPayableSupplier::create($request->all());

        // Mensaje de sesión
        Session::flash('success', 'Proveedor creado correctamente.');

        // Redirigir
        return redirect()->route('treasury_account_payable_suppliers.index');
    }

    public function show($id)
    {
        $supplier = TreasuryAccountPayableSupplier::find($id);

        $mode = 1;

        return view('treasury_account_payable_suppliers.show')->with('supplier', $supplier)->with('mode', $mode);
    }

    public function edit($id)
    {
        $supplier = TreasuryAccountPayableSupplier::find($id);

        $mode = 2;

        return view('treasury_account_payable_suppliers.edit')->with('supplier', $supplier)->with('mode', $mode);
    }

    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'rfc' => 'nullable|max:13',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:15',
            'account_name' => 'nullable|max:255',
            'account_number' => 'nullable|max:20',
            'bank_name' => 'nullable|max:255',
            'dependency_id' => 'nullable|integer',
            'status' => 'required|in:active,inactive,payed',
        ]);

        $supplier = TreasuryAccountPayableSupplier::find($id);

        if ($supplier->status !== $request->status) {

            $statusTranslations = [
                'active' => 'activo',
                'inactive' => 'inactivo',
                'payed' => 'pagado'
            ];

            $oldStatus = $statusTranslations[$supplier->status] ?? $supplier->status;
            $newStatus = $statusTranslations[$request->status] ?? $request->status;

            $log = new TapSupplierLog();
            $log->supplier_id = $supplier->id;
            $log->status = $request->status;
            $log->description = 'El estado del proveedor ha cambiado de ' . $oldStatus . ' a ' . $newStatus;
            $log->save();
        }

        // Actualizar datos
        $supplier->update($request->all());


        // Mensaje de sesión
        Session::flash('success', 'Proveedor actualizado correctamente.');

        // Redirigir
        return redirect()->route('treasury_account_payable_suppliers.show', $supplier->id);
    }

    public function destroy($id)
    {
        $supplier = TreasuryAccountPayableSupplier::find($id);

        // Eliminar proveedor
        $supplier->delete();

        // Mensaje de sesión
        Session::flash('success', 'Proveedor eliminado correctamente.');

        return redirect()->route('treasury_account_payable_suppliers.index');
    }
}
