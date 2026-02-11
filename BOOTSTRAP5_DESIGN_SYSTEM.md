# Sistema de Diseño Bootstrap 5 — Web Valle de Santiago

Guía de referencia para que todo el equipo estructure vistas Blade usando **exclusivamente Bootstrap 5**.
---

## 📋 Índice

1. [Principios Generales](#principios-generales)
2. [Layouts y Extends](#layouts-y-extends)
3. [Contenedores](#contenedores)
4. [Tarjetas (Cards)](#tarjetas-cards)
5. [Header de Módulo (Listados)](#header-de-módulo-listados)
6. [Formularios (Create / Edit)](#formularios-create--edit)
7. [Tablas](#tablas)
8. [Alertas y Mensajes Flash](#alertas-y-mensajes-flash)
9. [Estados Vacíos (Empty States)](#estados-vacíos-empty-states)
10. [Botones](#botones)
11. [Badges](#badges)
12. [Paginación](#paginación)
13. [Filtros y Búsquedas](#filtros-y-búsquedas)
14. [Grid y Responsive](#grid-y-responsive)
15. [Iconografía (FontAwesome + Bootstrap)](#iconografía)
16. [Validación de Formularios](#validación-de-formularios)
17. [Paneles Laterales (Sidebars en Edit)](#paneles-laterales)
18. [Vistas Front (Públicas)](#vistas-front-públicas)
19. [Reglas de Estilo Prohibidas](#reglas-de-estilo-prohibidas)
20. [Checklist para PR / Code Review](#checklist-para-pr--code-review)

---

## 1. Principios Generales

| Regla | Detalle |
|-------|---------|
| **Framework único** | Usar exclusivamente clases de Bootstrap 5. No Tailwind, no CSS inline salvo excepciones justificadas. |
| **Sin CSS custom para layout** | El grid, espaciado, tipografía y colores se resuelven con utilidades de Bootstrap. |
| **Responsive first** | Todo debe verse correctamente en `col-lg`, `col-md` y `col-sm` como mínimo. |
| **Consistencia** | Mismos patrones en todas las vistas: misma card, mismos botones, mismos alerts. |
| **Accesibilidad** | Usar `aria-label`, `role="alert"`, `title` en botones de iconos, y contrastes AAA (ver `THEME_SYSTEM.md`). |

---

## 2. Layouts y Extends

### Backoffice (admin/intranet)

```blade
@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Backoffice @endslot
        @slot('title') Nombre del Módulo @endslot
    @endcomponent

    <div class="container-fluid py-4">
        {{-- Contenido aquí --}}
    </div>
@endsection
```

### Front (público)

```blade
@extends('front.layouts.app')
@section('content')
    <div class="container py-5">
        {{-- Contenido aquí --}}
    </div>
@endsection
```

> **Nota:** Backoffice usa `container-fluid` (ancho completo). Front usa `container` (ancho acotado).

---

## 3. Contenedores

| Contexto | Clase | Ejemplo |
|----------|-------|---------|
| Backoffice | `container-fluid py-4` | Listados, formularios, paneles admin |
| Front público | `container py-5` | Página de citas, blog, trámites |
| Formulario centrado | `col-lg-8 mx-auto` | Create de backoffice |

---

## 4. Tarjetas (Cards)

La tarjeta es la **unidad base** para agrupar contenido. Siempre se usa con estas clases:

```html
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        {{-- Contenido --}}
    </div>
</div>
```

### Variantes

| Variante | Clases adicionales | Uso |
|----------|-------------------|-----|
| Card estándar | `border-0 shadow-sm` | Todo contenido de backoffice |
| Card con header de color | `card-header bg-primary text-white` | Formularios create/edit |
| Card elevada (front) | `shadow-lg border-0 rounded-4` | Secciones destacadas en front público |
| Card informativa (front) | `border-0 bg-light` | Bloques de ayuda o información |
| Card con margin | `mb-4` | Separar cards apiladas verticalmente |

### Card con Header de Color

```html
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Título</h5>
    </div>
    <div class="card-body p-4">
        {{-- Contenido --}}
    </div>
</div>
```

> El color del header indica la acción: `bg-primary` para crear/editar, `bg-secondary` para paneles auxiliares.

---

## 5. Header de Módulo (Listados)

Todas las vistas de listado (index) llevan un header consistente dentro de una card:

```html
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center">
            {{-- Lado izquierdo: icono + título + descripción --}}
            <div class="col-lg-8">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-building fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">
                            <i class="fas fa-sitemap text-primary me-2"></i> Nombre del Módulo
                        </h3>
                        <p class="text-muted mb-0">
                            <i class="fas fa-clipboard-list me-1"></i>
                            Descripción breve del módulo
                        </p>
                    </div>
                </div>
            </div>

            {{-- Lado derecho: botón de acción principal --}}
            <div class="col-lg-4 text-end">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Nuevo Registro
                </a>
            </div>
        </div>
    </div>
</div>
```

### Anatomía del Header

| Elemento | Clases | Propósito |
|----------|--------|-----------|
| Icono circular | `bg-primary bg-opacity-10 rounded-circle p-3 me-3` | Identificación visual del módulo |
| Título | `h3 mb-1 fw-bold` | Nombre del módulo |
| Descripción | `text-muted mb-0` | Contexto breve |
| Botón CTA | `btn btn-primary` en `col-lg-4 text-end` | Acción principal (crear) |

---

## 6. Formularios (Create / Edit)

### Estructura de formulario Create

```html
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Título del Formulario</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('...') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Campo A <span class="text-danger">*</span></label>
                                <input type="text" name="campo_a" class="form-control @error('campo_a') is-invalid @enderror" value="{{ old('campo_a') }}" required>
                                <small class="text-muted">Texto de ayuda.</small>
                                @error('campo_a')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Campo B <span class="text-danger">*</span></label>
                                <input type="text" name="campo_b" class="form-control @error('campo_b') is-invalid @enderror" value="{{ old('campo_b') }}" required>
                                @error('campo_b')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Más campos con la misma estructura --}}

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('...index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Reglas de campos

| Elemento | Clase | Nota |
|----------|-------|------|
| Label | `form-label` | Siempre antes del input |
| Campo requerido | `<span class="text-danger">*</span>` | Junto al texto del label |
| Input | `form-control` | Nunca input sin esta clase |
| Select | `form-select` | Para dropdowns nativos |
| Error de validación | `is-invalid` + `invalid-feedback` | Se añade con `@error` de Blade |
| Texto de ayuda | `<small class="text-muted">` | Debajo del input |
| Espaciado entre filas | `row mb-4` | Separa grupos de campos |
| Distribución de columnas | `col-md-4` / `col-md-8` / `col-md-12` | Acorde al contenido |

### Barra de botones del formulario

Siempre al final, alineada a la derecha:

```html
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="..." class="btn btn-secondary">
        <i class="fas fa-times me-2"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-2"></i> Guardar
    </button>
</div>
```

> `btn-secondary` siempre para Cancelar, `btn-primary` siempre para la acción principal.

---

## 7. Tablas

```html
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold">Columna</th>
                <th class="fw-semibold text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Dato principal</strong></td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-outline-primary" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-outline-danger" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

### Reglas de tablas

| Regla | Detalle |
|-------|---------|
| Siempre `table-responsive` | Envolver la tabla para scroll horizontal en móvil |
| `table-hover align-middle` | Hover en filas y alineación vertical centrada |
| Header | `thead class="table-light"` con `th class="fw-semibold"` |
| Columnas de acciones | `text-center` tanto en `th` como en `td` |
| Grupo de botones | `btn-group btn-group-sm` con botones `btn-outline-*` |
| Eliminar con confirmación | `onsubmit="return confirm('...')"` en el form |

---

## 8. Alertas y Mensajes Flash

```html
{{-- Éxito --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-lg me-3"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Error --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-lg me-3"></i>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
```

### Estructura obligatoria de alertas

| Clase/Atributo | Propósito |
|----------------|-----------|
| `alert-dismissible fade show` | Permite cerrar con animación |
| `border-0 shadow-sm` | Consistencia visual con las cards |
| `role="alert"` | Accesibilidad |
| `d-flex align-items-center` | Icono alineado al texto |
| `fa-lg me-3` | Icono a la izquierda con margen |
| `btn-close` + `data-bs-dismiss="alert"` | Botón nativo de Bootstrap para cerrar |

### Mapa de colores de alertas

| Tipo | Clase | Icono |
|------|-------|-------|
| Éxito | `alert-success` | `fa-check-circle` |
| Error | `alert-danger` | `fa-exclamation-circle` |
| Advertencia | `alert-warning` | `fa-exclamation-triangle` |
| Información | `alert-info` | `fa-info-circle` |

---

## 9. Estados Vacíos (Empty States)

Cuando un listado no tiene registros:

```html
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-folder-open fa-4x text-muted"></i>
    </div>
    <h5 class="text-muted">No hay registros</h5>
    <p class="text-muted mb-4">Descripción con instrucción para el usuario.</p>
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Crear Primer Registro
    </a>
</div>
```

### Reglas

- Icono grande: `fa-4x text-muted`
- Texto: `text-muted` para título y descripción
- CTA: botón `btn-primary` para invitar a crear el primer registro
- Centrado: `text-center py-5`

---

## 10. Botones

### Jerarquía de botones

| Nivel | Clase | Uso |
|-------|-------|-----|
| Primario | `btn btn-primary` | Acción principal: Guardar, Crear, Filtrar |
| Secundario | `btn btn-secondary` | Cancelar, acciones auxiliares |
| Outline primario | `btn btn-outline-primary` | Editar en tablas |
| Outline danger | `btn btn-outline-danger` | Eliminar en tablas |
| Outline secondary | `btn btn-outline-secondary` | Limpiar filtros |

### Convenciones de iconos en botones

```html
{{-- Crear --}}
<i class="fas fa-plus me-2"></i> Nuevo Registro

{{-- Guardar --}}
<i class="fas fa-save me-2"></i> Guardar

{{-- Cancelar --}}
<i class="fas fa-times me-2"></i> Cancelar

{{-- Filtrar --}}
<i class="fas fa-filter me-2"></i> Filtrar

{{-- Limpiar filtro --}}
<i class="fas fa-times me-1"></i> Limpiar

{{-- Editar (solo icono en tabla) --}}
<i class="fas fa-edit"></i>

{{-- Eliminar (solo icono en tabla) --}}
<i class="fas fa-trash"></i>
```

> **Regla:** Botones con texto llevan icono con `me-2`. Botones de solo icono (en tablas) no llevan margin extra.

---

## 11. Badges

```html
{{-- Código o identificador --}}
<span class="badge bg-primary">ABC-001</span>

{{-- Conteo --}}
<span class="badge bg-secondary">5</span>

{{-- Estado informativo --}}
<span class="badge bg-info">12</span>
```

| Color | Uso |
|-------|-----|
| `bg-primary` | Códigos, identificadores, tags principales |
| `bg-secondary` | Conteos genéricos |
| `bg-info` | Conteos informativos |
| `bg-success` | Estados activos / aprobados |
| `bg-warning` | Pendientes |
| `bg-danger` | Rechazados / errores |

---

## 12. Paginación

Siempre centrada debajo de la tabla:

```html
<div class="d-flex justify-content-center mt-4">
    {{ $items->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
```

> Siempre usar `pagination::bootstrap-5` y `appends(request()->query())` para conservar filtros.

---

## 13. Filtros y Búsquedas

```html
<form method="GET" action="{{ route('modulo.index') }}" class="mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-lg-8">
            <label class="form-label fw-semibold">
                <i class="fas fa-search me-1"></i> Buscar:
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="Buscar por..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-lg-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter me-2"></i> Filtrar
            </button>
        </div>
        <div class="col-lg-2">
            @if(request()->has('search'))
                <a href="{{ route('modulo.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times me-1"></i> Limpiar
                </a>
            @endif
        </div>
    </div>
</form>
```

### Reglas

- Método **GET** (no POST) para que la URL sea compartible
- Input con `input-group` (icono de lupa a la izquierda)
- Botón Filtrar: `btn btn-primary w-100`
- Botón Limpiar: `btn btn-outline-secondary w-100`, solo visible si hay filtro activo
- Grid: `row g-3 align-items-end` para alinear la base de los inputs con los botones

---

## 14. Grid y Responsive

### Breakpoints estándar usados

| Clase | Ancho mínimo | Uso típico |
|-------|-------------|------------|
| `col-lg-*` | ≥992px | Layout principal (escritorio) |
| `col-md-*` | ≥768px | Distribución de campos de formulario |
| `col-sm-*` | ≥576px | Ajustes en móvil cuando es necesario |

### Patrones comunes

```html
{{-- Listado con tabla --}}
<div class="row">
    <div class="col-lg-12">...</div>
</div>

{{-- Formulario centrado (Create) --}}
<div class="row">
    <div class="col-lg-8 mx-auto">...</div>
</div>

{{-- Formulario con panel lateral (Edit) --}}
<div class="row">
    <div class="col-lg-8">{{-- Formulario --}}</div>
    <div class="col-lg-4">{{-- Panel auxiliar --}}</div>
</div>

{{-- Distribución de campos --}}
<div class="row mb-4">
    <div class="col-md-4">{{-- Campo corto --}}</div>
    <div class="col-md-8">{{-- Campo largo --}}</div>
</div>

{{-- Vista front centrada --}}
<div class="row justify-content-center">
    <div class="col-lg-8">...</div>
</div>
```

---

## 15. Iconografía

Se usa **FontAwesome 5+** para todos los iconos. Nunca mezclar con otra librería de iconos.

### Convenciones de tamaño

| Clase | Uso |
|-------|-----|
| (sin tamaño) | Iconos en botones, labels, textos |
| `fa-lg` | Iconos en alertas |
| `fa-2x` | Icono circular del header de módulo |
| `fa-4x` | Empty states, hero sections |

### Separación del texto

- Icono antes de texto: `me-1` o `me-2`
- Icono después de texto: `ms-1` o `ms-2`

---

## 16. Validación de Formularios

Todos los inputs con validación server-side de Laravel:

```html
<input type="text"
       name="campo"
       class="form-control @error('campo') is-invalid @enderror"
       value="{{ old('campo') }}"
       required>
@error('campo')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

Para edición, el `old()` lleva fallback al modelo:

```html
value="{{ old('campo', $modelo->campo) }}"
```

> **Nunca** usar validación JavaScript custom cuando Laravel ya provee `@error`.

---

## 17. Paneles Laterales

En vistas de edición con datos relacionados (usuarios, archivos, etc.):

```html
<div class="row">
    {{-- Formulario principal --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Registro</h5>
            </div>
            <div class="card-body p-4">...</div>
        </div>
    </div>

    {{-- Panel lateral --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="fas fa-users me-2"></i> Datos Relacionados</h6>
            </div>
            <div class="card-body p-4">
                {{-- Listas con list-group --}}
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <strong>Nombre</strong>
                            <br><small class="text-muted">detalle</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-times"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
```

### Reglas del panel lateral

| Elemento | Clase |
|----------|-------|
| Header | `bg-secondary text-white` (diferente del principal) |
| Título | `h6 mb-0` (más pequeño que el principal) |
| Lista | `list-group list-group-flush` |
| Items | `d-flex justify-content-between align-items-center px-0` |
| Estado vacío | `text-center text-muted py-4` con icono `fa-2x` |

---

## 18. Vistas Front (Públicas)

Las vistas públicas siguen un patrón distinto pero con los mismos componentes Bootstrap:

```html
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Encabezado con icono grande --}}
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="fas fa-home fa-4x text-primary"></i>
                </div>
                <h1 class="display-5 fw-bold mb-3">Título Principal</h1>
                <p class="lead text-muted">Descripción del servicio.</p>
            </div>

            {{-- Card destacada --}}
            <div class="card shadow-lg border-0 rounded-4 mb-5">
                <div class="card-body p-5">
                    {{-- Contenido principal --}}
                </div>
            </div>

            {{-- Card informativa --}}
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        ¿Necesitas ayuda?
                    </h5>
                    <p class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Label:</strong> Contenido
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Diferencias Front vs Backoffice

| Aspecto | Backoffice | Front |
|---------|-----------|-------|
| Contenedor | `container-fluid py-4` | `container py-5` |
| Ancho de contenido | `col-lg-12` | `col-lg-8` centrado |
| Cards | `shadow-sm` | `shadow-lg rounded-4` |
| Padding del body | `p-4` | `p-5` |
| Títulos | `h3 fw-bold` | `display-5 fw-bold` |
| Texto descriptivo | `text-muted` | `lead text-muted` |

---

## 19. Reglas de Estilo Prohibidas

| ❌ Prohibido | ✅ Alternativa Bootstrap |
|-------------|------------------------|
| `style="margin-top: 20px"` | `mt-4` |
| `style="padding: 15px"` | `p-3` |
| `style="display: flex"` | `d-flex` |
| `style="text-align: center"` | `text-center` |
| `style="font-weight: bold"` | `fw-bold` |
| `style="color: red"` | `text-danger` |
| `style="background: #f8f9fa"` | `bg-light` |
| `style="border-radius: 50%"` | `rounded-circle` |
| `style="width: 100%"` | `w-100` |
| CSS custom para grid | `row` + `col-*` |
| `<center>` | `text-center` o `mx-auto` |
| `float: left/right` | `d-flex` o sistema de grid |

> **Excepción:** `style="text-transform: uppercase"` está permitido cuando Bootstrap no ofrece la utilidad equivalente, o estilos de terceros (ej: Select2).

---

## 20. Checklist para PR / Code Review

Antes de enviar un Pull Request, verifica que tu vista cumple:

- [ ] **Layout correcto**: `@extends('layouts.master')` para backoffice, `@extends('front.layouts.app')` para front
- [ ] **Contenedor**: `container-fluid py-4` (back) o `container py-5` (front)
- [ ] **Cards**: Todas usan `border-0 shadow-sm` y `card-body p-4`
- [ ] **Formularios**: Labels con `form-label`, inputs con `form-control`, validación con `@error`
- [ ] **Botones**: Jerarquía correcta (primary/secondary) con iconos FontAwesome
- [ ] **Tablas**: `table-responsive` > `table table-hover align-middle` > `thead table-light`
- [ ] **Alertas**: Patrón estándar con `d-flex`, icono, `btn-close` y `role="alert"`
- [ ] **Empty states**: Icono `fa-4x`, textos `text-muted`, CTA con `btn-primary`
- [ ] **Paginación**: `pagination::bootstrap-5` centrada con `appends()`
- [ ] **Sin CSS inline**: No hay `style=""` salvo excepciones documentadas
- [ ] **Responsive**: Funciona correctamente en `lg`, `md` y menores
- [ ] **Accesibilidad**: `aria-label` en botones de icono, `role="alert"` en alertas
- [ ] **Breadcrumb**: Presente y con la jerarquía correcta del módulo

---

## Referencia rápida de spacing (Bootstrap 5)

| Clase | Valor |
|-------|-------|
| `*-0` | 0 |
| `*-1` | 0.25rem (4px) |
| `*-2` | 0.5rem (8px) |
| `*-3` | 1rem (16px) |
| `*-4` | 1.5rem (24px) |
| `*-5` | 3rem (48px) |

Donde `*` puede ser: `m` (margin), `p` (padding), `mt`, `mb`, `ms`, `me`, `mx`, `my`, `pt`, `pb`, etc.

---

## Documentos complementarios

- [THEME_SYSTEM.md](THEME_SYSTEM.md) — Sistema de modo claro/oscuro y variables CSS
- [CONTRALORIA_DESIGN_SYSTEM.md](CONTRALORIA_DESIGN_SYSTEM.md) — Sistema de diseño específico de Contraloría

---

*Última actualización: Febrero 2026*
