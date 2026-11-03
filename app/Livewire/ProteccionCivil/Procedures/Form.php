<?php

namespace App\Livewire\ProteccionCivil\Procedures;

use App\Models\CivilProtectionProcedure;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Session;

class Form extends Component
{
    public ?CivilProtectionProcedure $procedure = null;

    public $name = '';

    public $type = 'technical_opinion';

    public $description = '';

    public $folio_prefix = '';

    public $validity_days = 365;

    public $is_published = false;

    /**
     * Requisitos documentales: [name, instructions, is_required, formats[], requires_original, is_fixed]
     */
    public array $requirements = [];

    public bool $dirty = false;

    public function mount(?CivilProtectionProcedure $procedure = null)
    {
        if ($procedure?->exists) {
            $this->procedure = $procedure;
            $this->fill($procedure->only(['name', 'type', 'description', 'folio_prefix', 'validity_days', 'is_published']));
            $this->requirements = $procedure->requirements
                ->map(fn ($r) => $r->only(['name', 'instructions', 'is_required', 'formats', 'requires_original', 'is_fixed']))
                ->all();
        }

        if (empty($this->requirements) || ! $this->requirements[0]['is_fixed']) {
            array_unshift($this->requirements, CivilProtectionProcedure::FIXED_REQUIREMENT);
        }

        if (! $procedure?->exists) {
            $this->addRequirement();
            $this->dirty = false;
        }
    }

    public function updated($property)
    {
        if ($property === 'folio_prefix') {
            $this->folio_prefix = strtoupper($this->folio_prefix);
        }

        $this->dirty = true;
    }

    public function addRequirement()
    {
        $this->requirements[] = [
            'name' => '',
            'instructions' => '',
            'is_required' => true,
            'formats' => ['pdf'],
            'requires_original' => false,
            'is_fixed' => false,
        ];
        $this->dirty = true;
    }

    public function removeRequirement($index)
    {
        if ($this->requirements[$index]['is_fixed'] ?? false) {
            return;
        }

        unset($this->requirements[$index]);
        $this->requirements = array_values($this->requirements);
        $this->dirty = true;
    }

    /**
     * Mueve un requisito arriba (-1) o abajo (+1). El requisito fijo siempre queda en la posición 1.
     */
    public function move($index, $direction)
    {
        $target = $index + $direction;

        if ($target < 1 || $target >= count($this->requirements) || $this->requirements[$index]['is_fixed']) {
            return;
        }

        [$this->requirements[$index], $this->requirements[$target]] = [$this->requirements[$target], $this->requirements[$index]];
        $this->dirty = true;
    }

    public function toggleFormat($index, $format)
    {
        if ($this->requirements[$index]['is_fixed']) {
            return;
        }

        $formats = $this->requirements[$index]['formats'];
        $formats = in_array($format, $formats)
            ? array_values(array_diff($formats, [$format]))
            : array_values(array_merge($formats, [$format]));

        $this->requirements[$index]['formats'] = $formats;
        $this->dirty = true;
    }

    public function getPrefixLockedProperty(): bool
    {
        return (bool) $this->procedure?->hasFiles();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:'.implode(',', array_keys(CivilProtectionProcedure::TYPES)),
            'description' => 'required|string|max:1000',
            'folio_prefix' => [
                'required', 'alpha', 'min:2', 'max:5',
                Rule::unique('civil_protection_procedures', 'folio_prefix')->ignore($this->procedure?->id),
            ],
            'validity_days' => 'required|integer|min:1|max:3650',
            'is_published' => 'boolean',
            'requirements.*.name' => 'required|string|max:255',
            'requirements.*.instructions' => 'nullable|string|max:255',
            'requirements.*.formats' => 'required|array|min:1',
        ], [
            'requirements.*.formats.required' => 'Cada requisito debe aceptar al menos un formato.',
            'requirements.*.formats.min' => 'Cada requisito debe aceptar al menos un formato.',
        ], [
            'name' => 'nombre del trámite',
            'description' => 'descripción breve',
            'folio_prefix' => 'prefijo de folio',
            'validity_days' => 'vigencia',
            'requirements.*.name' => 'documento',
        ]);

        DB::transaction(function () {
            $data = [
                'name' => $this->name,
                'type' => $this->type,
                'description' => $this->description,
                'validity_days' => $this->validity_days,
                'is_published' => $this->is_published,
            ];

            if (! $this->prefixLocked) {
                $data['folio_prefix'] = strtoupper($this->folio_prefix);
            }

            $procedure = $this->procedure ?? new CivilProtectionProcedure;
            $procedure->fill($data)->save();

            $procedure->requirements()->delete();
            foreach (array_values($this->requirements) as $order => $requirement) {
                $procedure->requirements()->create(array_merge(
                    $requirement['is_fixed'] ? CivilProtectionProcedure::FIXED_REQUIREMENT : $requirement,
                    ['sort_order' => $order + 1]
                ));
            }

            $this->procedure = $procedure;
        });

        Session::flash('success', 'Trámite guardado correctamente.');

        return redirect()->route('proteccion_civil.procedures.edit', $this->procedure);
    }

    public function render()
    {
        return view('livewire.proteccion-civil.procedures.form', [
            'expiresOn' => now()->addDays((int) $this->validity_days ?: 0)->format('d/m/Y'),
        ]);
    }
}
