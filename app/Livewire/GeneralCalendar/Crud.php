<?php

namespace App\Livewire\GeneralCalendar;

use Livewire\Component;
use Carbon\Carbon;

use App\Models\GeneralCalendarProcedure;
use App\Models\GeneralCalendarClosure;
use App\Models\TransparencyDependency;

class Crud extends Component
{
    public const BLOCKS_PER_DAY = 8;

    public $procedure;

    // 0: create  1: show  2: edit
    public $mode;

    public string $tab = 'detalles';

    // ─── Detalles del trámite ─────────────────────────────────────
    public bool $status      = true;
    public $created_date     = '';
    public $name             = '';
    public $dependencia      = '';
    public $note             = '';
    public array $attention_days = [];
    public $attention_start  = '';
    public $attention_end    = '';
    public bool $requires_id = false;

    // ─── Disponibilidad ───────────────────────────────────────────
    // $blocks[day_of_week] = array de 8 horas 'H:i' (vacío = sin usar)
    public array $blocks = [];

    // Filas {id, date, start_time, end_time}
    public array $closures = [];

    public bool $showClosureModal = false;
    public $closure_date  = '';
    public $closure_start = '';
    public $closure_end   = '';

    // Visor de citas agendadas (modo ver)
    public $view_date = '';

    public $dependencias = [];

    public function mount(): void
    {
        $this->dependencias = TransparencyDependency::orderBy('name')->get();
        $this->created_date = Carbon::now()->format('Y-m-d');
        $this->view_date    = Carbon::now()->format('Y-m-d');

        foreach (array_keys(GeneralCalendarProcedure::DAYS) as $day) {
            $this->blocks[$day] = array_fill(0, self::BLOCKS_PER_DAY, '');
        }

        if ($this->procedure !== null) {
            $this->fetchData();
        }
    }

    public function fetchData(): void
    {
        $p = $this->procedure;

        $this->status          = $p->status;
        $this->created_date    = $p->created_date?->format('Y-m-d') ?? '';
        $this->name            = $p->name;
        $this->dependencia     = $p->dependencia ?? '';
        $this->note            = $p->note ?? '';
        $this->attention_days  = $p->attention_days ?? [];
        $this->attention_start = $p->attention_start ? substr($p->attention_start, 0, 5) : '';
        $this->attention_end   = $p->attention_end ? substr($p->attention_end, 0, 5) : '';
        $this->requires_id     = $p->requires_id;

        foreach ($p->blocks as $block) {
            $day  = $block->day_of_week;
            $time = substr($block->start_time, 0, 5);
            $idx  = array_search('', $this->blocks[$day], true);
            if ($idx !== false) {
                $this->blocks[$day][$idx] = $time;
            }
        }

        $this->closures = $p->closures->map(fn ($c) => [
            'id'         => $c->id,
            'date'       => $c->date->format('Y-m-d'),
            'start_time' => substr($c->start_time, 0, 5),
            'end_time'   => substr($c->end_time, 0, 5),
        ])->toArray();
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function toggleDay(int $day): void
    {
        if ($this->mode === 1) {
            return;
        }

        if (in_array($day, $this->attention_days)) {
            $this->attention_days = array_values(array_diff($this->attention_days, [$day]));
        } else {
            $this->attention_days[] = $day;
        }
    }

    // ─── Guardar detalles ─────────────────────────────────────────

    public function saveDetails()
    {
        $this->validate([
            'name'            => 'required|string|max:255',
            'dependencia'     => 'nullable|string|max:255',
            'note'            => 'nullable|string',
            'created_date'    => 'nullable|date',
            'attention_start' => 'nullable|date_format:H:i',
            'attention_end'   => 'nullable|date_format:H:i|after:attention_start',
        ], [
            'name.required'        => 'El nombre del trámite es obligatorio.',
            'attention_end.after'  => 'La hora final debe ser mayor a la inicial.',
        ]);

        $data = [
            'name'            => $this->name,
            'dependencia'     => $this->dependencia ?: null,
            'note'            => $this->note ?: null,
            'attention_days'  => $this->attention_days,
            'attention_start' => $this->attention_start ?: null,
            'attention_end'   => $this->attention_end ?: null,
            'requires_id'     => $this->requires_id,
            'status'          => $this->status,
            'created_date'    => $this->created_date ?: null,
        ];

        if ($this->procedure !== null) {
            $this->procedure->update($data);
            session()->flash('success', 'Detalles del trámite actualizados.');

            return redirect()->route('general_calendar.admin.edit', $this->procedure->id);
        }

        $data['slug'] = GeneralCalendarProcedure::generateSlug($this->name);
        $procedure    = GeneralCalendarProcedure::create($data);

        session()->flash('success', 'Trámite creado. Ahora configura su disponibilidad.');

        return redirect()->route('general_calendar.admin.edit', $procedure->id);
    }

    // ─── Disponibilidad ───────────────────────────────────────────

    public function saveAvailability()
    {
        // Bloques: cada hora debe caer en intervalos de 30 min
        foreach ($this->blocks as $day => $times) {
            foreach ($times as $time) {
                if ($time === '' || $time === null) {
                    continue;
                }
                if (!preg_match('/^([01]\d|2[0-3]):(00|30)$/', $time)) {
                    $this->addError('blocks', "Los bloques deben iniciar en horas en punto o y media (revisa {$time}).");

                    return;
                }
            }
        }

        foreach ($this->closures as $i => $closure) {
            if (empty($closure['date']) || empty($closure['start_time']) || empty($closure['end_time'])) {
                $this->addError('closures', 'Todas las filas de días inhábiles deben tener fecha y horario completos.');

                return;
            }
            if ($closure['start_time'] >= $closure['end_time']) {
                $this->addError('closures', 'En los días inhábiles la hora final debe ser mayor a la inicial.');

                return;
            }
        }

        // Sincronizar bloques: se reemplazan por los capturados.
        // Solo se aceptan bloques en los días de atención del trámite.
        $this->procedure->blocks()->delete();

        foreach ($this->blocks as $day => $times) {
            if (!in_array($day, $this->attention_days)) {
                continue;
            }

            $unique = array_unique(array_filter($times, fn ($t) => $t !== '' && $t !== null));
            foreach ($unique as $time) {
                $this->procedure->blocks()->create([
                    'day_of_week' => $day,
                    'start_time'  => $time,
                ]);
            }
        }

        // Sincronizar cierres
        $keptIds = collect($this->closures)->pluck('id')->filter()->all();
        $this->procedure->closures()->whereNotIn('id', $keptIds)->delete();

        foreach ($this->closures as $closure) {
            if (!empty($closure['id'])) {
                GeneralCalendarClosure::find($closure['id'])?->update([
                    'date'       => $closure['date'],
                    'start_time' => $closure['start_time'],
                    'end_time'   => $closure['end_time'],
                ]);
            } else {
                $this->procedure->closures()->create([
                    'date'       => $closure['date'],
                    'start_time' => $closure['start_time'],
                    'end_time'   => $closure['end_time'],
                ]);
            }
        }

        $this->procedure->refresh()->load(['blocks', 'closures']);
        $this->fetchDataBlocksOnly();

        session()->flash('success', 'Disponibilidad guardada correctamente.');

        return redirect()->route('general_calendar.admin.edit', $this->procedure->id);
    }

    private function fetchDataBlocksOnly(): void
    {
        foreach (array_keys(GeneralCalendarProcedure::DAYS) as $day) {
            $this->blocks[$day] = array_fill(0, self::BLOCKS_PER_DAY, '');
        }

        foreach ($this->procedure->blocks as $block) {
            $day  = $block->day_of_week;
            $time = substr($block->start_time, 0, 5);
            $idx  = array_search('', $this->blocks[$day], true);
            if ($idx !== false) {
                $this->blocks[$day][$idx] = $time;
            }
        }
    }

    // ─── Modal de día inhábil ─────────────────────────────────────

    public function openClosureModal(): void
    {
        $this->reset(['closure_date', 'closure_start', 'closure_end']);
        $this->resetValidation();
        $this->showClosureModal = true;
    }

    public function closeClosureModal(): void
    {
        $this->showClosureModal = false;
        $this->reset(['closure_date', 'closure_start', 'closure_end']);
    }

    public function addClosure(): void
    {
        $this->validate([
            'closure_date'  => 'required|date',
            'closure_start' => 'required|date_format:H:i',
            'closure_end'   => 'required|date_format:H:i|after:closure_start',
        ], [
            'closure_date.required'  => 'Indica la fecha.',
            'closure_start.required' => 'Indica la hora de inicio.',
            'closure_end.required'   => 'Indica la hora final.',
            'closure_end.after'      => 'La hora final debe ser mayor a la inicial.',
        ]);

        $this->closures[] = [
            'id'         => null,
            'date'       => $this->closure_date,
            'start_time' => $this->closure_start,
            'end_time'   => $this->closure_end,
        ];

        $this->closeClosureModal();
    }

    public function removeClosure(int $index): void
    {
        array_splice($this->closures, $index, 1);
    }

    // ─── Render ───────────────────────────────────────────────────

    public function render()
    {
        // Visor de bloques agendados (modo ver)
        $viewSlots = [];
        if ($this->mode === 1 && $this->procedure !== null && $this->view_date) {
            $viewSlots = $this->procedure->slotsForDate($this->view_date);
        }

        return view('general-calendar.utilities.crud', [
            'days'      => GeneralCalendarProcedure::DAYS,
            'dayNames'  => GeneralCalendarProcedure::DAY_NAMES,
            'viewSlots' => $viewSlots,
        ]);
    }
}
