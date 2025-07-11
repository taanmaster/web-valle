<?php

namespace App\Livewire\TapSupplier;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\TapSupplierDependency;
use App\Models\TreasuryAccountPayableSupplier;
use App\Models\TransparencyDependency;

class Crud extends Component
{

    //Modes: 0: create, 1 show, 2 edit
    public $mode;


    public $supplier;

    #[Validate('required')]
    public $name = '';

    public $rfc = '';
    public $email = '';
    public $phone = '';
    public $account_name = '';
    public $account_number = '';
    public $bank_name = '';
    public $status = '';

    public $searchDependencies = '';

    public $dependencies;
    public $selectDependency = []; // IDs
    public $selectedDependencies = []; // Objetos


    public function mount()
    {
        if ($this->supplier != null) {
            $this->fetchSupplierData();
        }
    }

    public function fetchSupplierData()
    {
        $this->name = $this->supplier->name;
        $this->rfc = $this->supplier->rfc;
        $this->email = $this->supplier->email;
        $this->phone = $this->supplier->phone;
        $this->account_name = $this->supplier->account_name;
        $this->account_number = $this->supplier->account_number;
        $this->bank_name = $this->supplier->bank_name;
        $this->status = $this->supplier->status;

        $this->loadDependencies();
    }

    public function loadDependencies()
    {
        $this->selectDependency = $this->supplier->dependencies()->pluck('dependency_id')->toArray();
        $this->selectedDependencies = $this->supplier->dependencies->all();
    }

    public function updatedsearchDependencies()
    {
        $this->dependencies = TransparencyDependency::where('belongs_to_treasury', true)->where('name', 'like', '%' . $this->searchDependencies . '%')->get();
    }

    public function deleteDependency($id)
    {
        if ($this->mode == 2 && $this->supplier) {
            TapSupplierDependency::where('supplier_id', $this->supplier->id)
                ->where('dependency_id', $id)
                ->delete();

            $this->loadDependencies();
        }

        // Quitar también de los arrays locales
        $this->selectDependency = array_filter($this->selectDependency, fn($depId) => $depId != $id);
        $this->selectedDependencies = array_filter($this->selectedDependencies, fn($dep) => $dep->id != $id);
    }

    public function updatedSelectDependency()
    {
        // Refrescar modelos para mostrar etiquetas
        $this->selectedDependencies = TransparencyDependency::whereIn('id', $this->selectDependency)->get()->all();

        if ($this->mode == 2 && $this->supplier) {
            // Crear relaciones faltantes
            foreach ($this->selectDependency as $dependencyId) {
                TapSupplierDependency::firstOrCreate([
                    'supplier_id' => $this->supplier->id,
                    'dependency_id' => $dependencyId,
                ]);
            }

            // Eliminar las que ya no están seleccionadas
            TapSupplierDependency::where('supplier_id', $this->supplier->id)
                ->whereNotIn('dependency_id', $this->selectDependency)
                ->delete();
        }
    }

    public function save()
    {
        if ($this->supplier != null) {

            $supplier = TreasuryAccountPayableSupplier::findOrFail($this->supplier->id);

            if ($supplier->status !== $this->status) {

                $statusTranslations = [
                    'active' => 'activo',
                    'inactive' => 'inactivo',
                    'payed' => 'pagado'
                ];

                $oldStatus = $statusTranslations[$supplier->status] ?? $supplier->status;
                $newStatus = $statusTranslations[$this->status] ?? $this->status;

                $log = new TapSupplierLog();
                $log->supplier_id = $supplier->id;
                $log->status = $this->status;
                $log->description = 'El estado del proveedor ha cambiado de ' . $oldStatus . ' a ' . $newStatus;
                $log->save();
            }

            $supplier->name = $this->name;
            $supplier->rfc = $this->rfc;
            $supplier->email = $this->email;
            $supplier->phone = $this->phone;
            $supplier->account_name = $this->account_name;
            $supplier->account_number = $this->account_number;
            $supplier->bank_name = $this->bank_name;
            $supplier->status = $this->status;

            $supplier->save();

            // Mensaje de sesión
            Session::flash('success', 'Proveedor actualizado correctamente.');

            // Redirigir
            return redirect()->route('treasury_account_payable_suppliers.index');
        } else {

            $new = TreasuryAccountPayableSupplier::create([
                'name' => $this->name,
                'rfc' => $this->rfc,
                'email' => $this->email,
                'phone' => $this->phone,
                'account_name' => $this->account_name,
                'account_number' => $this->account_number,
                'bank_name' => $this->bank_name,
                'status' => $this->status,
            ]);

            foreach ($this->selectDependency as $dependency) {
                TapSupplierDependency::create([
                    'supplier_id' => $new->id,
                    'dependency_id' => $dependency,
                ]);
            };


            // Mensaje de sesión
            Session::flash('success', 'Proveedor creado correctamente.');

            // Redirigir
            return redirect()->route('treasury_account_payable_suppliers.index');
        }
    }



    public function render()
    {
        return view('treasury_account_payable_suppliers.utilities.crud');
    }
}
