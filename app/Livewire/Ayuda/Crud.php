<?php

namespace App\Livewire\Ayuda;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Guia;
use App\Models\GuiaPaso;
use App\Models\GuiaCambio;
use App\Models\BackofficeDependency;

class Crud extends Component
{
    use WithFileUploads;

    public $guia;
    public $mode; // 0: create, 1: show, 2: edit

    // Guide fields
    public $titulo         = '';
    public $descripcion    = '';
    public $imagen_portada = null;
    public $guia_categoria_id = null;
    public $dependencia    = '';
    public $mostrar_front  = false;
    public $mostrar_admin  = false;
    public $destacada      = false;
    public $fecha_entrada  = '';

    // Steps array + file uploads keyed by step tempKey
    public array $steps      = [];
    public array $stepImages = [];
    public array $stepFiles  = [];

    public $dependencias = [];

    // ─── Lifecycle ───────────────────────────────────────────────

    public function mount(): void
    {
        $this->dependencias  = BackofficeDependency::orderBy('name')->get();
        $this->fecha_entrada = Carbon::now()->toDateString();

        if ($this->guia !== null) {
            $this->fetchData();
        }
    }

    public function fetchData(): void
    {
        $g = $this->guia;

        $this->titulo            = $g->titulo;
        $this->descripcion       = $g->descripcion;
        $this->guia_categoria_id = $g->guia_categoria_id;
        $this->dependencia       = $g->dependencia;
        $this->mostrar_front     = $g->mostrar_front;
        $this->mostrar_admin     = $g->mostrar_admin;
        $this->destacada         = $g->destacada;
        $this->fecha_entrada     = $g->fecha_entrada?->toDateString();

        $this->steps = $g->pasos->map(fn($p) => [
            'id'                   => $p->id,
            'tempKey'              => Str::random(8),
            'titulo'               => $p->titulo,
            'descripcion'          => $p->descripcion ?? '',
            'imagen_apoyo_path'    => $p->imagen_apoyo,
            'enlace_texto'         => $p->enlace_texto ?? '',
            'enlace_url'           => $p->enlace_url ?? '',
            'pregunta_frecuente'   => $p->pregunta_frecuente ?? '',
            'mensaje_advertencia'  => $p->mensaje_advertencia ?? '',
            'archivo_adjunto_path' => $p->archivo_adjunto,
            'orden'                => $p->orden,
        ])->toArray();
    }

    // ─── Auto-save (edit mode only) ──────────────────────────────

    public function updated(string $name, $value): void
    {
        if ($this->mode !== 2 || $this->guia === null) {
            return;
        }

        match (true) {
            // Cover image
            $name === 'imagen_portada' && $value && !is_string($value)
                => $this->autoSaveCoverImage(),

            // Step image or file upload
            str_starts_with($name, 'stepImages.')
                => $this->autoSaveStepImage(substr($name, strlen('stepImages.'))),

            str_starts_with($name, 'stepFiles.')
                => $this->autoSaveStepFile(substr($name, strlen('stepFiles.'))),

            // Step text field
            str_starts_with($name, 'steps.') && $name !== 'steps'
                => $this->autoSaveStepField($name),

            // Guide fields
            in_array($name, $this->guideFieldKeys())
                => $this->autoSaveGuideField($name, $value),

            default => null,
        };
    }

    private function guideFieldKeys(): array
    {
        return [
            'titulo', 'descripcion', 'dependencia',
            'mostrar_front', 'mostrar_admin', 'destacada', 'fecha_entrada',
        ];
    }

    private function autoSaveGuideField(string $field, $value): void
    {
        $labels = [
            'titulo'        => 'título',
            'descripcion'   => 'descripción',
            'dependencia'   => 'dependencia',
            'mostrar_front' => 'visibilidad front',
            'mostrar_admin' => 'visibilidad admin',
            'destacada'     => 'guía destacada',
            'fecha_entrada' => 'fecha de entrada',
        ];

        $booleans = ['mostrar_front', 'mostrar_admin', 'destacada'];
        $oldRaw   = $this->guia->getRawOriginal($field);
        $oldValue = in_array($field, $booleans)
            ? ($oldRaw ? 'Sí' : 'No')
            : ($oldRaw ?? '(vacío)');
        $newValue = in_array($field, $booleans)
            ? ($value ? 'Sí' : 'No')
            : ($value ?: '(vacío)');

        $this->guia->update([$field => $value ?: null]);

        $label = $labels[$field] ?? $field;

        GuiaCambio::create([
            'guia_id'     => $this->guia->id,
            'user_id'     => auth()->id(),
            'descripcion' => "Actualización de {$label}",
            'detalle'     => ['de' => (string) $oldValue, 'a' => (string) $newValue],
        ]);

        $this->dispatch('toast', message: ucfirst($label) . ' actualizado');
    }

    private function autoSaveCoverImage(): void
    {
        if (!$this->imagen_portada || is_string($this->imagen_portada)) {
            return;
        }

        $oldPath  = $this->guia->imagen_portada;
        $path     = $this->imagen_portada->storePublicly('ayuda/portadas', 's3');
        $this->guia->update(['imagen_portada' => $path]);

        GuiaCambio::create([
            'guia_id'     => $this->guia->id,
            'user_id'     => auth()->id(),
            'descripcion' => 'Actualización de imagen de portada',
            'detalle'     => [
                'de' => $oldPath ? basename($oldPath) : '(sin imagen)',
                'a'  => basename($path),
            ],
        ]);

        $this->dispatch('toast', message: 'Imagen de portada actualizada');
    }

    private function autoSaveStepField(string $name): void
    {
        if (!preg_match('/^steps\.(\d+)\.(.+)$/', $name, $m)) {
            return;
        }

        $index = (int) $m[1];
        $field = $m[2];

        $allowed = ['titulo', 'descripcion', 'enlace_texto', 'enlace_url', 'pregunta_frecuente', 'mensaje_advertencia'];

        if (!in_array($field, $allowed)) {
            return;
        }

        $step = $this->steps[$index] ?? null;

        if (!$step || empty($step['id'])) {
            return;
        }

        $paso     = GuiaPaso::find($step['id']);
        $oldValue = $paso?->getRawOriginal($field) ?? '(vacío)';
        $newValue = $step[$field] ?: '(vacío)';

        $paso?->update([$field => $step[$field]]);

        $labels = [
            'titulo'              => 'título del paso',
            'descripcion'         => 'descripción del paso',
            'enlace_texto'        => 'enlace del paso',
            'enlace_url'          => 'URL del enlace',
            'pregunta_frecuente'  => 'pregunta frecuente',
            'mensaje_advertencia' => 'mensaje de advertencia',
        ];

        $label = $labels[$field] ?? $field;

        GuiaCambio::create([
            'guia_id'     => $this->guia->id,
            'user_id'     => auth()->id(),
            'descripcion' => "Actualización de {$label} (paso " . ($index + 1) . ')',
            'detalle'     => ['de' => (string) $oldValue, 'a' => (string) $newValue],
        ]);

        $this->dispatch('toast', message: ucfirst($label) . ' actualizado');
    }

    private function autoSaveStepImage(string $tempKey): void
    {
        $file = $this->stepImages[$tempKey] ?? null;
        if (!$file || is_string($file)) {
            return;
        }

        $step = collect($this->steps)->firstWhere('tempKey', $tempKey);
        if (!$step || empty($step['id'])) {
            return;
        }

        $oldPath = $step['imagen_apoyo_path'];
        $path    = $file->storePublicly('ayuda/pasos/imagenes', 's3');
        $idx     = array_search($step, $this->steps);
        $this->steps[$idx]['imagen_apoyo_path'] = $path;

        GuiaPaso::find($step['id'])?->update(['imagen_apoyo' => $path]);

        GuiaCambio::create([
            'guia_id'     => $this->guia->id,
            'user_id'     => auth()->id(),
            'descripcion' => 'Actualización de imagen de apoyo (paso ' . ($idx + 1) . ')',
            'detalle'     => [
                'de' => $oldPath ? basename($oldPath) : '(sin imagen)',
                'a'  => basename($path),
            ],
        ]);

        $this->dispatch('toast', message: 'Imagen de apoyo actualizada');
    }

    private function autoSaveStepFile(string $tempKey): void
    {
        $file = $this->stepFiles[$tempKey] ?? null;
        if (!$file || is_string($file)) {
            return;
        }

        $step = collect($this->steps)->firstWhere('tempKey', $tempKey);
        if (!$step || empty($step['id'])) {
            return;
        }

        $oldPath = $step['archivo_adjunto_path'];
        $path    = $file->storePublicly('ayuda/pasos/archivos', 's3');
        $idx     = array_search($step, $this->steps);
        $this->steps[$idx]['archivo_adjunto_path'] = $path;

        GuiaPaso::find($step['id'])?->update(['archivo_adjunto' => $path]);

        GuiaCambio::create([
            'guia_id'     => $this->guia->id,
            'user_id'     => auth()->id(),
            'descripcion' => 'Actualización de archivo adjunto (paso ' . ($idx + 1) . ')',
            'detalle'     => [
                'de' => $oldPath ? basename($oldPath) : '(sin archivo)',
                'a'  => basename($path),
            ],
        ]);

        $this->dispatch('toast', message: 'Archivo adjunto actualizado');
    }

    // ─── Category selector ───────────────────────────────────────

    #[On('categorySelected')]
    public function onCategorySelected($id): void
    {
        $this->guia_categoria_id = $id;

        if ($this->mode === 2 && $this->guia !== null) {
            $oldCat = $this->guia->categoria?->nombre ?? '(sin categoría)';
            $this->guia->update(['guia_categoria_id' => $id ?: null]);
            $this->guia->refresh();
            $newCat = $this->guia->categoria?->nombre ?? '(sin categoría)';

            GuiaCambio::create([
                'guia_id'     => $this->guia->id,
                'user_id'     => auth()->id(),
                'descripcion' => 'Actualización de categoría',
                'detalle'     => ['de' => $oldCat, 'a' => $newCat],
            ]);

            $this->dispatch('toast', message: 'Categoría actualizada');
        }
    }

    // ─── Steps management ────────────────────────────────────────

    #[On('reorderSteps')]
    public function reorderSteps(array $order): void
    {
        $reordered = [];
        foreach ($order as $tempKey) {
            $step = collect($this->steps)->firstWhere('tempKey', $tempKey);
            if ($step) {
                $reordered[] = $step;
            }
        }
        $this->steps = $reordered;

        foreach ($this->steps as $i => &$s) {
            $s['orden'] = $i + 1;
        }
        unset($s);

        if ($this->mode === 2 && $this->guia !== null) {
            foreach ($this->steps as $s) {
                if (!empty($s['id'])) {
                    GuiaPaso::find($s['id'])?->update(['orden' => $s['orden']]);
                }
            }
            GuiaCambio::create([
                'guia_id'     => $this->guia->id,
                'user_id'     => auth()->id(),
                'descripcion' => 'Reordenamiento de pasos',
            ]);
            $this->dispatch('toast', message: 'Orden de pasos actualizado');
        }
    }

    public function addStep(): void
    {
        $tempKey = Str::random(8);
        $orden   = count($this->steps) + 1;
        $id      = null;

        if ($this->mode === 2 && $this->guia !== null) {
            $paso = GuiaPaso::create([
                'guia_id' => $this->guia->id,
                'titulo'  => 'Nuevo paso',
                'orden'   => $orden,
            ]);
            $id = $paso->id;

            GuiaCambio::create([
                'guia_id'     => $this->guia->id,
                'user_id'     => auth()->id(),
                'descripcion' => "Paso {$orden} agregado",
            ]);
            $this->dispatch('toast', message: "Paso {$orden} agregado");
        }

        $this->steps[] = [
            'id'                   => $id,
            'tempKey'              => $tempKey,
            'titulo'               => $id ? 'Nuevo paso' : '',
            'descripcion'          => '',
            'imagen_apoyo_path'    => null,
            'enlace_texto'         => '',
            'enlace_url'           => '',
            'pregunta_frecuente'   => '',
            'mensaje_advertencia'  => '',
            'archivo_adjunto_path' => null,
            'orden'                => $orden,
        ];
    }

    public function removeStep(int $index): void
    {
        $step = $this->steps[$index] ?? null;
        if (!$step) {
            return;
        }

        if ($this->mode === 2 && $this->guia !== null && !empty($step['id'])) {
            GuiaPaso::find($step['id'])?->delete();

            GuiaCambio::create([
                'guia_id'     => $this->guia->id,
                'user_id'     => auth()->id(),
                'descripcion' => 'Paso ' . ($index + 1) . ' eliminado',
            ]);
            $this->dispatch('toast', message: 'Paso eliminado');
        }

        unset($this->stepImages[$step['tempKey']]);
        unset($this->stepFiles[$step['tempKey']]);
        array_splice($this->steps, $index, 1);

        foreach ($this->steps as $i => &$s) {
            $s['orden'] = $i + 1;
        }
    }

    // ─── Manual save (create mode) ───────────────────────────────

    public function save(): void
    {
        $this->validate([
            'titulo'             => 'required|string|max:255',
            'descripcion'        => 'nullable|string',
            'guia_categoria_id'  => 'nullable|exists:guia_categorias,id',
            'dependencia'        => 'nullable|string|max:255',
            'fecha_entrada'      => 'nullable|date',
            'steps.*.titulo'     => 'required|string|max:255',
            'steps.*.enlace_url' => 'nullable|url',
        ]);

        $isNew = $this->guia === null;

        $coverPath = $this->guia?->imagen_portada;
        if ($this->imagen_portada && !is_string($this->imagen_portada)) {
            $coverPath = $this->imagen_portada->storePublicly('ayuda/portadas', 's3');
        }

        $data = [
            'titulo'            => $this->titulo,
            'slug'              => Str::slug($this->titulo),
            'descripcion'       => $this->descripcion,
            'imagen_portada'    => $coverPath,
            'guia_categoria_id' => $this->guia_categoria_id ?: null,
            'dependencia'       => $this->dependencia,
            'mostrar_front'     => $this->mostrar_front,
            'mostrar_admin'     => $this->mostrar_admin,
            'destacada'         => $this->destacada,
            'fecha_entrada'     => $this->fecha_entrada ?: null,
        ];

        if ($isNew) {
            $guia = Guia::create($data);
        } else {
            $this->guia->update($data);
            $guia = $this->guia;
        }

        // Sync steps (create mode only — edit mode handles steps live)
        if ($isNew) {
            foreach ($this->steps as $step) {
                $imagePath = null;
                if (isset($this->stepImages[$step['tempKey']]) && $this->stepImages[$step['tempKey']]) {
                    $imagePath = $this->stepImages[$step['tempKey']]->storePublicly('ayuda/pasos/imagenes', 's3');
                }
                $filePath = null;
                if (isset($this->stepFiles[$step['tempKey']]) && $this->stepFiles[$step['tempKey']]) {
                    $filePath = $this->stepFiles[$step['tempKey']]->storePublicly('ayuda/pasos/archivos', 's3');
                }

                GuiaPaso::create([
                    'guia_id'             => $guia->id,
                    'titulo'              => $step['titulo'],
                    'descripcion'         => $step['descripcion'],
                    'imagen_apoyo'        => $imagePath,
                    'enlace_texto'        => $step['enlace_texto'],
                    'enlace_url'          => $step['enlace_url'],
                    'pregunta_frecuente'  => $step['pregunta_frecuente'],
                    'mensaje_advertencia' => $step['mensaje_advertencia'],
                    'archivo_adjunto'     => $filePath,
                    'orden'               => $step['orden'],
                ]);
            }

            GuiaCambio::create([
                'guia_id'     => $guia->id,
                'user_id'     => auth()->id(),
                'descripcion' => 'Guía creada',
            ]);
        }

        redirect()->route('ayuda.admin.index');
    }

    // ─── Render ──────────────────────────────────────────────────

    public function render()
    {
        $cambios = $this->guia
            ? $this->guia->cambios()->with('user')->latest()->get()
            : collect();

        return view('ayuda.utilities.crud', ['cambios' => $cambios]);
    }
}
