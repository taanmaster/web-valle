# Sistema de Diseño - Contraloría Interna Municipal

Documentación de estilos, estructura y componentes para las vistas de Contraloría.

---

## 📋 Índice

1. [Estructura General](#estructura-general)
2. [Componentes de Títulos](#componentes-de-títulos)
3. [Tarjetas de Contenido](#tarjetas-de-contenido)
4. [Componentes Especiales](#componentes-especiales)
5. [Animaciones](#animaciones)
6. [Sistema de Colores](#sistema-de-colores)
7. [Responsive Design](#responsive-design)
8. [JavaScript Interactivo](#javascript-interactivo)

---

## 🏗️ Estructura General

### Layout Base

```blade
@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.contraloria.utilities._nav')
        
        <!-- Banner Principal -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Subtítulo</p>
                        <h1 class="display-1 mb-3">Título Principal</h1>
                        <p class="p mb-0 ms-auto me-auto" style="width: 70%;">Descripción</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <!-- ... bloques de contenido ... -->

        @include('front.contraloria.utilities._footer')
    </div>
@endsection
```

---

## 📌 Componentes de Títulos

### Título de Sección con Icono

**Estructura HTML:**
```blade
<div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
    <div class="icon bg-primary">
        <ion-icon name="nombre-icono-outline"></ion-icon>
    </div>
    <h3 class="mb-0">Título de la Sección</h3>
</div>
```

**Variantes de Color:**
- `bg-primary` - Azul (para información general)
- `bg-success` - Verde (para información positiva/procesos)
- `bg-warning` - Amarillo/Naranja (para valores/principios)
- `bg-danger` - Rojo (para advertencias/alertas)
- `bg-info` - Azul claro (para información adicional)

**Iconos Recomendados (Ionicons):**
- `help-circle-outline` - ¿Qué hace? / ¿Qué es?
- `people-outline` - ¿Quiénes somos?
- `star-outline` - Valores y principios
- `git-network-outline` - Marco normativo / Estructura
- `document-text-outline` - Documentos
- `calendar-outline` - Plazos / Fechas
- `alert-circle-outline` - Advertencias

---

## 🎴 Tarjetas de Contenido

### 1. Tarjeta Simple (card-normal)

```blade
<div class="card card-normal wow fadeInUp h-100">
    <div class="card-content text-center">
        <p class="mb-0">Contenido de texto</p>
    </div>
</div>
```

**Características:**
- Padding interno estándar
- Sombra sutil
- Fondo blanco
- Bordes redondeados

---

### 2. Tarjeta con Imagen Lateral

```blade
<div class="card wow fadeInUp h-100" style="overflow: hidden;">
    <div class="row g-0 h-100">
        <div class="col-4">
            <img src="{{ asset('front/img/placeholder-8.jpg') }}" 
                 class="img-fluid h-100 w-100" 
                 style="object-fit: cover;" 
                 alt="">
        </div>
        <div class="col-8">
            <div class="card-content d-flex align-items-center h-100">
                <p class="mb-0">Contenido de texto</p>
            </div>
        </div>
    </div>
</div>
```

**Características:**
- Imagen: 33% (col-4)
- Contenido: 67% (col-8)
- `overflow: hidden` para mantener bordes redondeados
- `object-fit: cover` para la imagen
- Solo el contenido tiene `card-content` (padding)
- La imagen está fuera del card-body

**Distribución de Columnas:**
- Desktop: `col-md-6` (2 columnas)
- Mobile: Automáticamente a 1 columna

---

### 3. Tarjeta con Icono y Título

```blade
<div class="card card-normal wow fadeInUp h-100">
    <div class="d-flex align-items-center mb-3" style="gap: 12px">
        <div class="icon bg-success" style="width: 50px; height: 50px;">
            <ion-icon name="flag-outline"></ion-icon>
        </div>
        <h4 class="mb-0">Título</h4>
    </div>
    <p class="mb-0">Contenido descriptivo</p>
</div>
```

**Uso:** Misión, Visión, Objetivos

---

## 🎨 Componentes Especiales

### 1. Nube de Palabras (Valores y Principios)

**HTML:**
```blade
<div id="word-cloud" class="text-center py-4">
    <span class="word-item" data-color="#3498db">Palabra1</span>
    <span class="word-item" data-color="#e74c3c">Palabra2</span>
    <span class="word-item" data-color="#2ecc71">Palabra3</span>
    <!-- ... más palabras ... -->
</div>
```

**CSS:**
```css
#word-cloud {
    line-height: 3;
    min-height: 150px;
}

.word-item {
    display: inline-block;
    margin: 5px 15px;
    font-size: 1.2rem;
    font-weight: 600;
    color: #6c757d;
    transition: all 0.4s ease;
    cursor: pointer;
    opacity: 0.7;
}

.word-item:nth-child(odd) {
    font-size: 1.4rem;
}

.word-item:nth-child(3n) {
    font-size: 1.6rem;
}

.word-item.active {
    font-size: 2rem !important;
    opacity: 1;
    transform: scale(1.2);
}
```

**JavaScript:**
```javascript
const wordItems = document.querySelectorAll('.word-item');
let currentIndex = 0;

function highlightNextWord() {
    wordItems.forEach(item => item.classList.remove('active'));
    const currentWord = wordItems[currentIndex];
    currentWord.classList.add('active');
    currentWord.style.color = currentWord.getAttribute('data-color');
    currentIndex = (currentIndex + 1) % wordItems.length;
}

highlightNextWord();
setInterval(highlightNextWord, 1500);
```

**Colores Recomendados:**
- `#3498db` - Azul
- `#e74c3c` - Rojo
- `#2ecc71` - Verde
- `#9b59b6` - Morado
- `#f39c12` - Naranja
- `#1abc9c` - Turquesa
- `#e67e22` - Naranja oscuro

---

### 2. Marco Normativo (Flexbox Grid)

**HTML:**
```blade
<div class="card card-normal wow fadeInUp" style="background: linear-gradient(135deg, #e8d5f0 0%, #f0e8f5 100%);">
    <div class="normative-framework">
        <!-- Fila superior -->
        <div class="normative-row top-row">
            <div class="normative-item box">
                <h6>DOCUMENTO NORMATIVO</h6>
            </div>
            <div class="normative-item circle">
                <h6>Proceso</h6>
            </div>
            <!-- más items -->
        </div>

        <!-- Fila media -->
        <div class="normative-row middle-row">
            <div class="normative-item circle">
                <h6>Proceso</h6>
            </div>
            <div class="normative-item box center-box">
                <h6>ELEMENTO CENTRAL</h6>
            </div>
            <div class="normative-item circle">
                <h6>Proceso</h6>
            </div>
        </div>

        <!-- Fila inferior -->
        <div class="normative-row bottom-row">
            <div class="normative-item box">
                <h6>DOCUMENTO NORMATIVO</h6>
            </div>
            <div class="normative-item circle">
                <h6>Proceso</h6>
            </div>
            <!-- más items -->
        </div>
    </div>
</div>
```

**CSS:**
```css
.normative-framework {
    padding: 40px 20px;
    min-height: 600px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 40px;
}

.normative-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.normative-item {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.normative-item.box {
    background-color: #b8b8b8;
    padding: 20px;
    border-radius: 10px;
    min-width: 160px;
    max-width: 200px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.normative-item.box.center-box {
    background-color: #b8b8b8;
    padding: 25px;
    min-width: 280px;
    max-width: 320px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.normative-item.circle {
    background-color: white;
    border: 3px solid #4caf50;
    border-radius: 50%;
    width: 140px;
    height: 140px;
    padding: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.normative-item:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    z-index: 10;
}
```

---

### 3. Línea de Tiempo Interactiva

**HTML:**
```blade
<div class="declaration-timeline">
    <div class="timeline-item wow fadeInUp" data-step="1">
        <div class="timeline-number">1</div>
        <div class="timeline-content">
            <h5 class="mb-2">Título del Paso</h5>
            <p class="mb-0">Descripción del paso</p>
        </div>
    </div>
    <!-- Más items -->
</div>
```

**CSS:**
```css
.declaration-timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    position: relative;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 70px;
    width: 2px;
    height: calc(100% + 10px);
    background: linear-gradient(180deg, #4caf50 0%, #81c784 100%);
    z-index: 0;
}

.timeline-number {
    min-width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    z-index: 1;
    position: relative;
    transition: all 0.3s ease;
}

.timeline-content {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border-left: 4px solid #4caf50;
}

.timeline-item:hover .timeline-number {
    transform: scale(1.15);
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.5);
}

.timeline-item:hover .timeline-content {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}
```

---

### 4. Cuadro de Alerta/Advertencia

**HTML:**
```blade
<div class="alert-box danger-alert wow fadeInUp">
    <div class="alert-icon">
        <ion-icon name="warning-outline"></ion-icon>
    </div>
    <div class="alert-content">
        <p class="mb-0">Mensaje de advertencia importante</p>
    </div>
</div>
```

**CSS:**
```css
.alert-box {
    display: flex;
    gap: 20px;
    padding: 25px;
    border-radius: 12px;
    border: 2px solid #dc3545;
    background: linear-gradient(135deg, #ffe5e8 0%, #fff5f5 100%);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.alert-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #dc3545 0%, #c82333 100%);
}

.alert-box:hover {
    box-shadow: 0 8px 24px rgba(220, 53, 69, 0.25);
    transform: translateY(-3px);
}

.alert-icon {
    min-width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.alert-content p {
    color: #721c24;
    line-height: 1.6;
    font-size: 0.95rem;
    margin: 0;
}
```

**Variantes de Color:**

- **Danger (Rojo):**
  - Border: `#dc3545`
  - Background: `linear-gradient(135deg, #ffe5e8 0%, #fff5f5 100%)`
  - Text: `#721c24`

- **Warning (Amarillo):**
  - Border: `#ffc107`
  - Background: `linear-gradient(135deg, #fff3cd 0%, #fffdf5 100%)`
  - Text: `#856404`

- **Info (Azul):**
  - Border: `#17a2b8`
  - Background: `linear-gradient(135deg, #d1ecf1 0%, #f5feff 100%)`
  - Text: `#0c5460`

- **Success (Verde):**
  - Border: `#28a745`
  - Background: `linear-gradient(135deg, #d4edda 0%, #f5fff7 100%)`
  - Text: `#155724`

---

## 🎭 Animaciones

### Animaciones de Entrada (WOW.js)

Agregar clase `wow fadeInUp` a elementos que deben animarse al hacer scroll:

```blade
<div class="card card-normal wow fadeInUp">
    <!-- contenido -->
</div>
```

### Animaciones CSS Personalizadas

```css
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}
```

### Delays Escalonados

```css
.item:nth-child(1) { animation-delay: 0.1s; }
.item:nth-child(2) { animation-delay: 0.2s; }
.item:nth-child(3) { animation-delay: 0.3s; }
```

---

## 🎨 Sistema de Colores

### Colores Principales

```css
/* Primarios */
--primary: #007bff;
--success: #4caf50;
--warning: #ffc107;
--danger: #dc3545;
--info: #17a2b8;

/* Secundarios */
--dark: #2c3e50;
--light: #f8f9fa;
--gray: #6c757d;

/* Gradientes Comunes */
background: linear-gradient(135deg, #e8d5f0 0%, #f0e8f5 100%); /* Morado suave */
background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%); /* Verde */
background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); /* Azul */
```

### Sombras

```css
/* Sombra suave */
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);

/* Sombra media */
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

/* Sombra fuerte (hover) */
box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);

/* Sombra de color */
box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
```

---

## 📱 Responsive Design

### Breakpoints de Bootstrap 5

```css
/* Extra small devices (portrait phones, less than 576px) */
@media (max-width: 576px) { }

/* Small devices (landscape phones, 576px and up) */
@media (min-width: 576px) and (max-width: 767.98px) { }

/* Medium devices (tablets, 768px and up) */
@media (min-width: 768px) and (max-width: 991.98px) { }

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) and (max-width: 1199.98px) { }

/* Extra large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) { }
```

### Reglas Responsive Comunes

```css
@media (max-width: 768px) {
    /* Reducir padding */
    .normative-framework {
        padding: 30px 15px;
    }
    
    /* Ajustar tamaños de fuente */
    .word-item {
        font-size: 1rem !important;
    }
    
    /* Cambiar a columna */
    .alert-box {
        flex-direction: column;
    }
    
    /* Ajustar dimensiones */
    .timeline-number {
        min-width: 50px;
        height: 50px;
    }
}

@media (max-width: 576px) {
    /* Layout vertical completo */
    .normative-row {
        flex-direction: column;
        gap: 15px;
    }
    
    /* Elementos a ancho completo */
    .normative-item.box {
        min-width: 90%;
        max-width: 90%;
    }
}
```

---

## ⚡ JavaScript Interactivo

### Intersection Observer (Animaciones al Scroll)

```javascript
const observerOptions = {
    threshold: 0.3,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

// Observar elementos
const elements = document.querySelectorAll('.timeline-item');
elements.forEach(el => observer.observe(el));
```

### Efectos de Hover Dinámicos

```javascript
const items = document.querySelectorAll('.timeline-item');

items.forEach((item) => {
    item.addEventListener('mouseenter', function() {
        const number = this.querySelector('.timeline-number');
        number.style.background = 'linear-gradient(135deg, #ff9800 0%, #f57c00 100%)';
    });

    item.addEventListener('mouseleave', function() {
        const number = this.querySelector('.timeline-number');
        number.style.background = 'linear-gradient(135deg, #4caf50 0%, #66bb6a 100%)';
    });
});
```

### Animación de Contador

```javascript
const number = element.querySelector('.timeline-number');
const targetNumber = parseInt(number.textContent);
let currentNumber = 0;

const updateCounter = () => {
    if (currentNumber < targetNumber) {
        currentNumber++;
        number.textContent = currentNumber;
        setTimeout(updateCounter, 100);
    }
};

updateCounter();
```

---

## 📐 Reglas de Estructura

### 1. Orden de Secciones

1. **Banner Principal** (Hero)
2. **Sección "¿Qué es?" / "¿Qué hace?"** (Información general)
3. **Sección "¿Quiénes Somos?"** (Descripción institucional)
4. **Secciones Específicas** (Valores, Marco Normativo, Plazos, etc.)
5. **Footer** (Navegación y enlaces)

### 2. Espaciado

```css
/* Entre secciones principales */
.row { margin-bottom: 2rem; } /* mb-4 en Bootstrap */

/* Entre elementos dentro de sección */
.col-md-6 { margin-bottom: 1.5rem; } /* mb-3 */

/* Padding de cards */
.card-content { padding: 1.5rem; }

/* Gap entre elementos flex */
gap: 12px; /* Títulos con iconos */
gap: 20px; /* Timeline items */
```

### 3. Tipografía

```css
/* Títulos de página */
h1.display-1 { font-size: 3.5rem; }

/* Títulos de sección */
h3 { font-size: 1.75rem; font-weight: 600; }

/* Subtítulos en cards */
h4, h5 { font-size: 1.25rem; font-weight: 600; }

/* Texto de párrafo */
p { font-size: 0.95rem; line-height: 1.6; color: #555; }

/* Texto pequeño */
.small-uppercase { 
    font-size: 0.875rem; 
    text-transform: uppercase; 
    letter-spacing: 0.05em;
}
```

### 4. Bordes Redondeados

```css
/* Cards y elementos grandes */
border-radius: 12px;

/* Elementos medianos */
border-radius: 10px;

/* Elementos pequeños */
border-radius: 8px;

/* Círculos */
border-radius: 50%;
```

---

## 🎯 Mejores Prácticas

### 1. Uso de Clases

- Usar `card-normal` para tarjetas con contenido estándar
- Usar solo `card` cuando la imagen debe estar sin padding
- Siempre agregar `wow fadeInUp` para animaciones
- Usar `h-100` en columnas para altura uniforme

### 2. Imágenes

- Formato: JPG para fotografías, PNG para ilustraciones
- Siempre usar `object-fit: cover` en imágenes de tarjetas
- Agregar `alt` descriptivo
- Usar Asset Helper: `{{ asset('front/img/nombre.jpg') }}`

### 3. Accesibilidad

- Usar etiquetas semánticas HTML5
- Incluir atributos `alt` en imágenes
- Mantener contraste de color adecuado (mínimo 4.5:1)
- Texto legible (mínimo 0.95rem)

### 4. Performance

- Lazy load para imágenes fuera del viewport
- Usar Intersection Observer en lugar de scroll events
- Minimizar animaciones en mobile
- Usar CSS transforms en lugar de properties que causan reflow

### 5. Consistencia

- Mantener el mismo orden de secciones
- Usar los mismos iconos para conceptos similares
- Aplicar los mismos colores para estados similares
- Mantener espaciado consistente

---

## 📚 Ejemplo Completo de Vista

```blade
@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.contraloria.utilities._nav')

        {{-- Banner --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Contraloría Interna Municipal</p>
                        <h1 class="display-1 mb-0">Título de la Vista</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección Principal --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="information-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Sección Principal</h3>
                </div>
            </div>
            
            <div class="col-md-12 mb-3">
                <div class="card card-normal wow fadeInUp">
                    <div class="card-content text-center">
                        <p class="mb-0">Contenido de la sección</p>
                    </div>
                </div>
            </div>
        </div>

        @include('front.contraloria.utilities._footer')
    </div>
@endsection

@push('styles')
<style>
    /* Estilos personalizados aquí */
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // JavaScript interactivo aquí
    });
</script>
@endpush
```

---

## 🔗 Referencias

- **Bootstrap 5:** https://getbootstrap.com/docs/5.0/
- **Ionicons:** https://ionic.io/ionicons
- **WOW.js:** https://wowjs.uk/
- **Animate.css:** https://animate.style/

---

## 📝 Notas de Versión

- Sistema de diseño inicial para vistas de Contraloría
- Componentes base: tarjetas, títulos, alertas
- Componentes especiales: línea de tiempo, nube de palabras, marco normativo
- Sistema responsive completo
- Animaciones e interactividad

---

**Última actualización:** 15 de octubre de 2025
**Mantenido por:** Equipo de Desarrollo - H. Ayuntamiento de Valle de Santiago
