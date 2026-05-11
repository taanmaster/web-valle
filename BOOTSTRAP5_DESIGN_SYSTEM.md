# Sistema de Diseño Bootstrap 5 — Web Valle de Santiago

Guía de referencia para estructurar vistas Blade y componentes Livewire usando **exclusivamente Bootstrap 5**.
Las **vistas de listado** son el patrón central de esta guía y deben tomarse como referencia principal.

---

## Índice

1. [Principios Generales](#1-principios-generales)
2. [Layout y Extends](#2-layout-y-extends)
3. [Breadcrumb](#3-breadcrumb)
4. [Vista de Listado — Patrón Canónico](#4-vista-de-listado--patrón-canónico-)
5. [Header de Módulo](#5-header-de-módulo)
6. [Tarjetas KPI / Resumen](#6-tarjetas-kpi--resumen)
7. [Panel de Filtros](#7-panel-de-filtros)
8. [Tabla de Datos](#8-tabla-de-datos)
9. [Estado Vacío](#9-estado-vacío)
10. [Paginación](#10-paginación)
11. [Vista de Formulario — Patrón Canónico](#11-vista-de-formulario--patrón-canónico)
12. [Alertas y Flash Messages](#12-alertas-y-flash-messages)
13. [Tarjetas (Cards)](#13-tarjetas-cards)
14. [Botones](#14-botones)
15. [Badges](#15-badges)
16. [Iconografía](#16-iconografía)
17. [Patrones Livewire](#17-patrones-livewire)
18. [Grid y Responsive](#18-grid-y-responsive)
19. [Validación de Formularios](#19-validación-de-formularios)
20. [Reglas de Estilo Prohibidas](#20-reglas-de-estilo-prohibidas)
21. [Checklist de Code Review](#21-checklist-de-code-review)

---

## 1. Principios Generales

| Regla | Detalle |
|-------|---------|
| **Bootstrap 5 primero** | Todo layout, espaciado, tipografía y color se resuelve con utilidades de Bootstrap. No Tailwind, no CSS custom para layout. |
| **Sin estilos inline** | No usar `style=""` para espaciado, colores ni display. Usar clases utilitarias de Bootstrap. |
| **Responsive siempre** | Toda vista debe funcionar en `col-lg`, `col-md` y `col-sm`. |
| **Consistencia** | Mismo header de módulo, mismas cards, mismos botones y mismas tablas en todas las vistas. |
| **Accesibilidad** | `aria-label` en botones de solo icono, `role="alert"` en alertas, `title` en botones de acción. |
| **Livewire primero** | La interactividad se maneja con Livewire. No jQuery para filtros, búsquedas ni validaciones. |

---

## 2. Layout y Extends

### Backoffice (admin / intranet)

```blade
@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Sección @endslot
        @slot('title') Nombre de la Vista @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:modulo.componente />
    </div>
@endsection
```

> El layout `master` ya incluye sidebar, topbar, footer, Livewire scripts y Bootstrap. No agregar scripts redundantes.

### Front (público)

```blade
@extends('front.layouts.app')
@section('content')
    <div class="container py-5">
        {{-- Contenido --}}
    </div>
@endsection
```

| Contexto | Contenedor |
|----------|-----------|
| Backoffice | `container-fluid py-4` |
| Front público | `container py-5` |

---

## 3. Breadcrumb

Siempre inmediatamente después de `@section('content')`, antes del `container-fluid`:

```blade
@component('components.breadcrumb')
    @slot('li_1') Intranet @endslot
    @slot('li_2') Sección @endslot
    @slot('title') Título de la Vista @endslot
@endcomponent
```

- `li_2` → nombre del módulo (ej: "Citas", "Adquisiciones")
- `title` → nombre de la vista específica (ej: "Listado de Trámites")

---

## 4. Vista de Listado — Patrón Canónico ⭐

Esta es la estructura estándar y **preferida** para todas las vistas de listado de la plataforma.
Se compone de cuatro bloques en este orden: **Header → Alertas → Filtros → Tabla**.

### Archivo blade de la ruta (`resources/views/modulo/index.blade.php`)

```blade
@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Módulo @endslot
        @slot('title') Listado @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:modulo.table />
    </div>
@endsection
```

### Componente Livewire (`resources/views/livewire/modulo/table.blade.php`)

```blade
<div>
    {{-- 1. HEADER DE MÓDULO --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-[icono] fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-[icono] text-primary me-2"></i> Nombre del Módulo
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Descripción breve del módulo y su propósito.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('modulo.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nuevo Registro
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. ALERTAS FLASH --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. PANEL DE FILTROS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i> Buscar:
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                            wire:model.live.debounce.300ms="search"
                            class="form-control border-start-0"
                            placeholder="Buscar por nombre...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Estado:</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Todos</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    @if ($search || $filterStatus !== '')
                        <button wire:click="clearFilters" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-1"></i> Limpiar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- 4. TABLA --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Columna A</th>
                                <th class="fw-semibold">Columna B</th>
                                <th class="fw-semibold text-center">Estado</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->nombre }}</strong>
                                        @if ($item->descripcion)
                                            <br><small class="text-muted">{{ Str::limit($item->descripcion, 60) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->categoria }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('modulo.show', $item) }}"
                                                class="btn btn-outline-primary" title="Ver detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('modulo.edit', $item) }}"
                                                class="btn btn-outline-secondary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button wire:click="delete({{ $item->id }})"
                                                wire:confirm="¿Estás seguro de eliminar este registro?"
                                                class="btn btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>
            @else
                {{-- ESTADO VACÍO --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-folder-open fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">No hay registros</h5>
                    <p class="text-muted mb-4">No se encontraron resultados con los filtros aplicados.</p>
                    <a href="{{ route('modulo.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Crear Primer Registro
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
```

---

## 5. Header de Módulo

Primera sección de cualquier componente Livewire de listado. Define la identidad visual del módulo.

```html
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-[icono] fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">Nombre del Módulo</h3>
                        <p class="text-muted mb-0">
                            <i class="fas fa-clipboard-list me-1"></i>
                            Descripción breve del módulo.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('...') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Nuevo Registro
                </a>
            </div>
        </div>
    </div>
</div>
```

| Elemento | Clases | Regla |
|----------|--------|-------|
| Contenedor icono | `bg-primary bg-opacity-10 rounded-circle p-3 me-3` | Fijo, no modificar |
| Icono | `fas fa-[icono] fa-2x text-primary` | Representativo del módulo |
| Título | `h3 mb-1 fw-bold` | Nombre corto del módulo |
| Descripción | `p text-muted mb-0` | Una sola línea de contexto |
| Botón CTA | `btn btn-primary` en `col-lg-4 text-end` | Solo si la vista permite crear |

> Si la vista no tiene botón CTA (solo lectura), usar `col-lg-12` en el lado izquierdo y omitir el derecho.

---

## 6. Tarjetas KPI / Resumen

Usadas en vistas de detalle con métricas. Van **después del header** y **antes de la tabla**.

```html
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-3">
                <h2 class="fw-bold text-primary mb-1">{{ $total }}</h2>
                <small class="text-muted">Total</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-3">
                <h2 class="fw-bold text-success mb-1">{{ $completados }}</h2>
                <small class="text-muted">Completados</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-3">
                <h2 class="fw-bold text-danger mb-1">{{ $rechazados }}</h2>
                <small class="text-muted">Rechazados</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-3">
                <h2 class="fw-bold text-info mb-1">{{ $pendientes }}</h2>
                <small class="text-muted">Pendientes</small>
            </div>
        </div>
    </div>
</div>
```

| Color | Clase | Uso típico |
|-------|-------|-----------|
| Azul | `text-primary` | Total general |
| Verde | `text-success` | Completados / Activos / Asistieron |
| Rojo | `text-danger` | Rechazados / Cancelados / No asistieron |
| Cian | `text-info` | Pendientes / En proceso |
| Amarillo | `text-warning` | Advertencias / En revisión |

---

## 7. Panel de Filtros

Siempre una `card border-0 shadow-sm` con `card-body p-4`. Los filtros usan `wire:model.live` para reactividad sin botón "buscar".

```html
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row g-3 align-items-end">

            {{-- Campo de búsqueda de texto --}}
            <div class="col-lg-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-search me-1"></i> Buscar:
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        class="form-control border-start-0"
                        placeholder="Buscar por nombre...">
                </div>
            </div>

            {{-- Filtro select --}}
            <div class="col-lg-3">
                <label class="form-label fw-semibold">Dependencia:</label>
                <select wire:model.live="filterDependency" class="form-select">
                    <option value="">Todas</option>
                    @foreach ($dependencies as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro de fecha --}}
            <div class="col-lg-2">
                <label class="form-label fw-semibold">Desde:</label>
                <input type="date" wire:model.live="filterDateFrom" class="form-control">
            </div>

            {{-- Botón limpiar (condicional) --}}
            <div class="col-lg-1">
                @if ($search || $filterDependency || $filterDateFrom)
                    <button wire:click="clearFilters"
                        class="btn btn-outline-secondary w-100"
                        title="Limpiar filtros">
                        <i class="fas fa-times"></i>
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>
```

| Regla | Detalle |
|-------|---------|
| **Livewire reactivo** | `wire:model.live` para selects y fechas. `debounce.300ms` solo para campos de texto libre. |
| **Botón limpiar condicional** | Solo visible cuando hay al menos un filtro activo. |
| **Icono en buscador** | El `input-group` con lupa es obligatorio en campos de texto libre. |
| **Label `fw-semibold`** | Todos los labels de filtros llevan `fw-semibold`. |
| **Grid `g-3 align-items-end`** | Garantiza espaciado y alineación con botones. |

---

## 8. Tabla de Datos

```html
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold">Nombre</th>
                <th class="fw-semibold">Categoría</th>
                <th class="fw-semibold text-center">Estado</th>
                <th class="fw-semibold text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        <br><small class="text-muted">{{ $item->email }}</small>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $item->category }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-{{ $item->status ? 'success' : 'danger' }}">
                            {{ $item->status ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('modulo.show', $item) }}"
                                class="btn btn-outline-primary" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('modulo.edit', $item) }}"
                                class="btn btn-outline-secondary" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button wire:click="delete({{ $item->id }})"
                                wire:confirm="¿Estás seguro de eliminar este registro?"
                                class="btn btn-outline-danger" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

| Regla | Clase / Detalle |
|-------|----------------|
| Wrapper obligatorio | `<div class="table-responsive">` |
| Clases base | `table table-hover align-middle` |
| Encabezado | `<thead class="table-light">` + `<th class="fw-semibold">` |
| Columnas de acción | `text-center` en `th` y en `td` |
| Botones de acción | `btn-group btn-group-sm` con `btn btn-outline-*` |
| Dato secundario en celda | `<br><small class="text-muted">dato</small>` |
| Folio / código | `<span class="badge bg-primary">{{ $folio }}</span>` |
| Confirmación de borrado | `wire:confirm="..."` (Livewire nativo, no `window.confirm()`) |

---

## 9. Estado Vacío

Dentro del mismo `card-body` de la tabla cuando no hay registros:

```html
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-folder-open fa-4x text-muted"></i>
    </div>
    <h5 class="text-muted">No hay registros</h5>
    <p class="text-muted mb-4">
        No se encontraron resultados. Intenta con otros filtros o crea el primer registro.
    </p>
    <a href="{{ route('modulo.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Crear Primer Registro
    </a>
</div>
```

| Elemento | Clase |
|----------|-------|
| Icono | `fas fa-folder-open fa-4x text-muted` |
| Título | `h5 text-muted` |
| Descripción | `p text-muted mb-4` |
| CTA (si aplica) | `btn btn-primary` |
| Centrado + espaciado | `text-center py-5` |

---

## 10. Paginación

Siempre centrada, dentro del `card-body`, después de la tabla:

```html
{{-- Con Livewire (paginación reactiva) --}}
<div class="d-flex justify-content-center mt-4">
    {{ $items->links('pagination::bootstrap-5') }}
</div>

{{-- Con controlador tradicional (conservar filtros GET) --}}
<div class="d-flex justify-content-center mt-4">
    {{ $items->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
```

> Con Livewire, `appends()` no es necesario. Con controladores tradicionales, siempre agregar `appends(request()->query())`.

---

## 11. Vista de Formulario — Patrón Canónico

Para Create, Edit y Show. El formulario va siempre centrado en `col-lg-8 mx-auto`.

```blade
<div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="text-white mb-0">
                        @if ($mode === 0)
                            <i class="fas fa-plus-circle me-2"></i> Nuevo Registro
                        @elseif ($mode === 1)
                            <i class="fas fa-eye me-2"></i> Ver Detalle
                        @else
                            <i class="fas fa-edit me-2"></i> Editar Registro
                        @endif
                    </h5>
                </div>
                <div class="card-body p-4">

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit="save">

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text"
                                    wire:model="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Nombre del registro..."
                                    {{ $mode === 1 ? 'disabled' : '' }}>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model="status"
                                        id="statusSwitch"
                                        {{ $mode === 1 ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="statusSwitch">
                                        {{ $status ? 'Activo' : 'Inactivo' }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea wire:model="description"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Descripción opcional..."
                                    {{ $mode === 1 ? 'disabled' : '' }}></textarea>
                            </div>
                        </div>

                        {{-- Separador de sección --}}
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-cog text-primary me-2"></i> Configuración
                        </h6>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            @if ($mode !== 1)
                                <a href="{{ route('modulo.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    {{ $mode === 0 ? 'Guardar' : 'Actualizar' }}
                                </button>
                            @else
                                <a href="{{ route('modulo.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Volver
                                </a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Modos del formulario

| `$mode` | Valor | Comportamiento |
|---------|-------|---------------|
| `0` | Crear | Campos editables, botón "Guardar" |
| `1` | Ver / Solo lectura | Campos `disabled`, solo botón "Volver" |
| `2` | Editar | Campos editables, botón "Actualizar" |

### Reglas de campos

| Elemento | Clase / Patrón |
|----------|---------------|
| Label | `form-label` (siempre antes del input) |
| Campo requerido | `<span class="text-danger">*</span>` en el label |
| Input | `form-control @error('campo') is-invalid @enderror` |
| Select | `form-select @error('campo') is-invalid @enderror` |
| Textarea | `form-control` con `rows="3"` como mínimo |
| Switch de estado | `form-check form-switch` con `form-check-input` |
| Error | `<div class="invalid-feedback">{{ $message }}</div>` |
| Agrupación | `row mb-4` con `col-md-*` internos |
| Separador de sección | `<hr class="my-4">` + `<h6 class="fw-bold mb-3">` |
| Barra de botones | `d-flex justify-content-end gap-2 mt-4` |

---

## 12. Alertas y Flash Messages

### Dentro de componentes Livewire

```html
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-lg me-3"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
```

| Elemento | Clase / Atributo | Propósito |
|----------|-----------------|-----------|
| Wrapper | `alert-dismissible fade show border-0 shadow-sm` | Animación + consistencia con cards |
| Accesibilidad | `role="alert"` | Screen readers |
| Contenido | `d-flex align-items-center` | Icono alineado al texto |
| Icono | `fa-lg me-3` | A la izquierda con separación |
| Cierre | `btn-close` + `data-bs-dismiss="alert"` | Nativo Bootstrap |

| Tipo | Clase | Icono |
|------|-------|-------|
| Éxito | `alert-success` | `fa-check-circle` |
| Error | `alert-danger` | `fa-exclamation-circle` |
| Advertencia | `alert-warning` | `fa-exclamation-triangle` |
| Información | `alert-info` | `fa-info-circle` |

---

## 13. Tarjetas (Cards)

La card es la **unidad base** de contenido. Siempre `border-0 shadow-sm`.

```html
{{-- Estándar --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">...</div>
</div>

{{-- Con header de color (formularios) --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0 text-white"><i class="fas fa-plus-circle me-2"></i> Título</h5>
    </div>
    <div class="card-body p-4">...</div>
</div>
```

| Variante | Clases adicionales | Uso |
|----------|--------------------|-----|
| Estándar | `border-0 shadow-sm` | Toda sección de backoffice |
| Header primario | `card-header bg-primary text-white` | Formularios create/edit |
| Header secundario | `card-header bg-secondary text-white` | Paneles auxiliares / sidebar |
| KPI / Métrica | `border-0 shadow-sm text-center` | Tarjetas de cifras clave |
| Front destacada | `shadow-lg border-0 rounded-4` | Hero sections en front público |

---

## 14. Botones

| Nivel | Clase | Uso |
|-------|-------|-----|
| Primario | `btn btn-primary` | Acción principal: Guardar, Crear, Exportar |
| Secundario | `btn btn-secondary` | Cancelar, Volver |
| Outline primario | `btn btn-outline-primary` | Ver en tablas |
| Outline secundario | `btn btn-outline-secondary` | Editar en tablas, Limpiar filtros |
| Outline success | `btn btn-outline-success` | Confirmar, Aprobar |
| Outline danger | `btn btn-outline-danger` | Eliminar, Rechazar |
| Success sólido | `btn btn-success` | Exportar Excel |

```html
{{-- Con texto: icono + me-2 --}}
<button class="btn btn-primary">
    <i class="fas fa-save me-2"></i> Guardar
</button>

{{-- Solo icono (tablas): con title y aria-label obligatorios --}}
<button class="btn btn-outline-primary" title="Ver detalle" aria-label="Ver detalle">
    <i class="fas fa-eye"></i>
</button>
```

### Acciones en tablas

```html
<div class="btn-group btn-group-sm">
    <a href="{{ route('modulo.show', $item) }}"
        class="btn btn-outline-primary" title="Ver">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('modulo.edit', $item) }}"
        class="btn btn-outline-secondary" title="Editar">
        <i class="fas fa-edit"></i>
    </a>
    <button wire:click="delete({{ $item->id }})"
        wire:confirm="¿Estás seguro de eliminar este registro?"
        class="btn btn-outline-danger" title="Eliminar">
        <i class="fas fa-trash"></i>
    </button>
</div>
```

---

## 15. Badges

```html
<span class="badge bg-primary">FOL-0001</span>   {{-- Folio / ID --}}
<span class="badge bg-info">12 min</span>         {{-- Duración / dato numérico --}}
<span class="badge bg-success">Activo</span>      {{-- Estado positivo --}}
<span class="badge bg-danger">Inactivo</span>     {{-- Estado negativo --}}
<span class="badge bg-warning">Pendiente</span>   {{-- Estado intermedio --}}
<span class="badge bg-secondary">N/A</span>       {{-- Sin dato --}}
```

| Color | Uso |
|-------|-----|
| `bg-primary` | Folios, identificadores, categorías principales |
| `bg-secondary` | Datos neutros, referencias |
| `bg-info` | Duraciones, cantidades, dependencias |
| `bg-success` | Activo, Aprobado, Confirmado, Asistió |
| `bg-warning` | Pendiente, En revisión |
| `bg-danger` | Inactivo, Rechazado, Cancelado, No asistió |
| `bg-dark` | Casos especiales, "Otros" |

---

## 16. Iconografía

| Contexto | Librería | Prefijo |
|----------|----------|---------|
| Backoffice (vistas Blade) | FontAwesome 5 | `fas fa-*` |
| Sidebar (menú lateral) | Tabler Icons | `ti ti-*` |

**No mezclar las dos librerías en la misma vista.**

| Clase | Uso |
|-------|-----|
| (sin clase) | Iconos en botones, labels, textos |
| `fa-lg` | Iconos en alertas |
| `fa-2x` | Icono circular del header de módulo |
| `fa-4x` | Empty states, hero sections |

- Icono antes de texto: `me-1` o `me-2`
- Icono después de texto: `ms-1` o `ms-2`

---

## 17. Patrones Livewire

### Propiedades de filtros (PHP)

```php
public string $search = '';
public string $filterStatus = '';
public string $filterDateFrom = '';

public function clearFilters(): void
{
    $this->reset(['search', 'filterStatus', 'filterDateFrom']);
}
```

### Bindings en vista (Blade)

```html
wire:model.live.debounce.300ms="search"    {{-- Texto libre: debounce 300ms --}}
wire:model.live="filterStatus"              {{-- Select: reactivo inmediato --}}
wire:model.live="filterDateFrom"            {{-- Fecha: reactivo inmediato --}}
```

### Submit de formulario

```html
<form wire:submit="save">
    {{-- campos --}}
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-2"></i> Guardar
    </button>
</form>
```

> No usar `wire:submit.prevent`. En Livewire v3, `prevent` está incluido automáticamente.

### Confirmación de borrado (nativo)

```html
<button
    wire:click="delete({{ $item->id }})"
    wire:confirm="¿Estás seguro de eliminar este registro? Esta acción no se puede deshacer."
    class="btn btn-outline-danger btn-sm"
    title="Eliminar">
    <i class="fas fa-trash"></i>
</button>
```

### Loading state en botones

```html
<button wire:click="save" class="btn btn-primary">
    <span wire:loading wire:target="save"
        class="spinner-border spinner-border-sm me-2"></span>
    <i wire:loading.remove wire:target="save"
        class="fas fa-save me-2"></i>
    Guardar
</button>
```

---

## 18. Grid y Responsive

```html
{{-- Listado completo --}}
<div class="row">
    <div class="col-lg-12">...</div>
</div>

{{-- Formulario centrado (Create / Edit) --}}
<div class="row">
    <div class="col-lg-8 mx-auto">...</div>
</div>

{{-- Formulario + panel lateral --}}
<div class="row">
    <div class="col-lg-8">{{-- Formulario --}}</div>
    <div class="col-lg-4">{{-- Panel auxiliar --}}</div>
</div>

{{-- KPI cards (4 columnas) --}}
<div class="row mb-4">
    <div class="col-md-3">...</div>
    <div class="col-md-3">...</div>
    <div class="col-md-3">...</div>
    <div class="col-md-3">...</div>
</div>

{{-- Campos de formulario --}}
<div class="row mb-4">
    <div class="col-md-4">{{-- Campo corto --}}</div>
    <div class="col-md-8">{{-- Campo largo --}}</div>
</div>
```

| Clase | Mínimo | Uso |
|-------|--------|-----|
| `col-lg-*` | 992px | Layout principal del módulo |
| `col-md-*` | 768px | Campos de formulario y KPI cards |
| `col-sm-*` | 576px | Ajustes móvil cuando sea necesario |

---

## 19. Validación de Formularios

### Con Livewire

```php
// Componente PHP
protected $rules = [
    'name' => 'required|string|max:255',
    'status' => 'boolean',
];

protected $messages = [
    'name.required' => 'El nombre es obligatorio.',
];
```

```html
<input type="text"
    wire:model="name"
    class="form-control @error('name') is-invalid @enderror"
    placeholder="...">
@error('name')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

### Con controlador tradicional

```html
<input type="text"
    name="name"
    class="form-control @error('name') is-invalid @enderror"
    value="{{ old('name', $model->name ?? '') }}"
    required>
@error('name')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

> Para edición siempre usar `old('campo', $model->campo)` para preservar el valor en caso de error de validación.

---

## 20. Reglas de Estilo Prohibidas

| ❌ Prohibido | ✅ Alternativa Bootstrap 5 |
|-------------|--------------------------|
| `style="margin-top: 20px"` | `mt-4` |
| `style="padding: 16px"` | `p-3` o `p-4` |
| `style="display: flex"` | `d-flex` |
| `style="text-align: center"` | `text-center` |
| `style="font-weight: bold"` | `fw-bold` |
| `style="font-weight: 600"` | `fw-semibold` |
| `style="color: red"` | `text-danger` |
| `style="background: #f8f9fa"` | `bg-light` |
| `style="border-radius: 50%"` | `rounded-circle` |
| `style="width: 100%"` | `w-100` |
| `style="gap: 12px"` | `gap-3` |
| `style="min-width: 200px"` | Usar columnas del grid |
| `float: left` / `float: right` | `d-flex` o grid |
| `<center>` | `text-center` o `mx-auto` |
| `window.confirm()` para borrado | `wire:confirm="..."` |

> **Excepción permitida:** Estilos de configuración de librerías de terceros (FullCalendar, Select2) sin alternativa Bootstrap equivalente.

---

## 21. Checklist de Code Review

### Layout y estructura

- [ ] Extiende `layouts.master` (backoffice) o `front.layouts.app` (front)
- [ ] Breadcrumb presente con jerarquía correcta
- [ ] Wrapper: `container-fluid py-4` (back) o `container py-5` (front)
- [ ] El contenido interactivo está en un componente Livewire separado

### Vistas de listado

- [ ] Header de módulo con icono circular `bg-primary bg-opacity-10 rounded-circle`
- [ ] Panel de filtros con `wire:model.live` y botón "Limpiar" condicional
- [ ] Tabla: `table-hover align-middle` + `thead table-light` + `th fw-semibold`
- [ ] Tabla envuelta en `table-responsive`
- [ ] Estado vacío con icono `fa-4x text-muted` dentro del `card-body`
- [ ] Paginación centrada con `pagination::bootstrap-5`

### Formularios

- [ ] Centrado en `col-lg-8 mx-auto`
- [ ] Card header `bg-primary text-white` con icono de acción
- [ ] Labels con `form-label`, requeridos con `<span class="text-danger">*</span>`
- [ ] Validación con `@error` + `is-invalid` + `invalid-feedback`
- [ ] Botones al final: `d-flex justify-content-end gap-2 mt-4`
- [ ] Cancelar con `btn-secondary`, acción principal con `btn-primary`

### Alertas

- [ ] Patrón estándar: `d-flex align-items-center` + icono + `btn-close`
- [ ] `role="alert"` presente
- [ ] `border-0 shadow-sm` para consistencia con las cards

### Estilo

- [ ] Sin atributos `style=""` de layout, espaciado o color
- [ ] Iconos: `fas fa-*` en vistas de contenido, `ti ti-*` solo en sidebar
- [ ] Botones de solo icono tienen `title` y `aria-label`
- [ ] Borrado usa `wire:confirm` (no `window.confirm()`)

---

## Referencia rápida de espaciado

| Clase | Rem | Px aprox. |
|-------|-----|-----------|
| `*-0` | 0 | 0 |
| `*-1` | 0.25rem | 4px |
| `*-2` | 0.5rem | 8px |
| `*-3` | 1rem | 16px |
| `*-4` | 1.5rem | 24px |
| `*-5` | 3rem | 48px |

Prefijos: `m` (margin), `p` (padding) + dirección `t / b / s / e / x / y`.

---

## Documentos complementarios

- [THEME_SYSTEM.md](THEME_SYSTEM.md) — Variables CSS, modo claro/oscuro
- [CONTRALORIA_DESIGN_SYSTEM.md](CONTRALORIA_DESIGN_SYSTEM.md) — Design system de Contraloría
- [EFIRMA_INTEGRATION.md](EFIRMA_INTEGRATION.md) — Integración con eFirma

---

*Última actualización: Mayo 2026*
