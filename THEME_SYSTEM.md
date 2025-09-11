# Sistema de Modo Claro/Oscuro - Valle de Santiago

## Descripción
Este sistema proporciona un cambio dinámico entre modo claro y oscuro con **alto contraste visual** que cumple con las reglas de contraste AAA de accesibilidad web y está totalmente integrado con Bootstrap 5.

## Características

### ✅ Cumplimiento de Accesibilidad
- **Contraste AAA**: Todos los colores cumplen con las reglas de contraste mínimo de 7:1 para texto normal y 4.5:1 para texto grande
- **Alto contraste visual**: Modo claro usa fondos muy claros (#f8f9fa) y modo oscuro usa fondos muy oscuros (#000000)
- **Reducción de movimiento**: Respeta la preferencia del usuario `prefers-reduced-motion`
- **Alto contraste**: Soporte para `prefers-contrast: high`
- **Esquema de color**: Utiliza `color-scheme` para indicar al navegador el tema activo

### 🎨 Integración con Bootstrap 5
- Variables CSS personalizadas que sobrescriben las variables de Bootstrap
- Soporte completo para todos los componentes de Bootstrap 5
- Transiciones suaves entre temas (0.3s ease)
- Preserva la funcionalidad completa de Bootstrap
- **Sin flash de tema incorrecto** al cargar la página

### 💾 Persistencia
- Almacena la preferencia del usuario en `localStorage`
- Detecta automáticamente la preferencia del sistema
- Sincroniza con cambios en la configuración del sistema
- Aplicación instantánea del tema al cargar la página

## Colores del Sistema

### Modo Claro
- **Fondo principal**: `#f8f9fa` (gris muy claro)
- **Fondo de tarjetas**: `#ffffff` (blanco puro)
- **Texto principal**: `#212529` (negro oscuro)
- **Bordes**: `#dee2e6` (gris claro)

### Modo Oscuro
- **Fondo principal**: `#000000` (negro puro)
- **Fondo de tarjetas**: `#171717` (gris muy oscuro)
- **Texto principal**: `#ffffff` (blanco puro)
- **Bordes**: `#404040` (gris medio)

## Uso

### Inclusión de Archivos
**IMPORTANTE**: El orden de inclusión es crítico para evitar el flash de tema:

```html
<head>
    <!-- 1. Instant Theme Loader - DEBE ser PRIMERO -->
    <script src="{{ asset('front/js/instant-theme.js') }}"></script>
    
    <!-- 2. Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 3. Custom CSS (después de Bootstrap) -->
    <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}">
</head>

<body class="preload">
    <!-- Contenido -->
    
    <!-- Scripts al final del body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front/js/theme-switcher.js') }}"></script>
</body>
```

### Switch de Tema
El switch ya está incluido en la navegación principal:

```html
<div class="switch">
    <input type="checkbox" id="mode" checked>
    <label for="mode">
        <span></span>
        <span>Oscuro</span>
    </label>
</div>
```

### API JavaScript

```javascript
// Acceder al objeto themeSwitcher globalmente
const theme = window.themeSwitcher;

// Métodos disponibles
theme.toggleTheme();           // Alternar tema
theme.setLightMode();          // Forzar modo claro
theme.setDarkMode();           // Forzar modo oscuro
theme.getCurrentTheme();       // Obtener tema actual
theme.isDarkMode();            // Verificar si está en modo oscuro

// Escuchar cambios de tema
document.addEventListener('themeChanged', (e) => {
    console.log('Nuevo tema:', e.detail.theme);
});
```

### Atajos de Teclado
- **Ctrl/Cmd + Shift + L**: Alternar entre modo claro y oscuro

## Variables CSS Personalizadas

### Variables de Layout
```css
--page-header-width: 250px;
--border-radius: 4px;
--box-shadow: (dinámico según el tema);
```

### Variables de Color por Tema

#### Modo Claro
```css
--bs-body-bg: #ffffff;
--bs-body-color: #212529;
--bs-primary: #551312;
--card-bg: #ffffff;
--text-muted: #6c757d;
```

#### Modo Oscuro
```css
--bs-body-bg: #0f0f0f;
--bs-body-color: #e5e5e5;
--bs-primary: #8b2635;
--card-bg: #1f1f1f;
--text-muted: #9ca3af;
```

## Componentes Soportados

### Bootstrap 5
- ✅ Cards
- ✅ Forms (inputs, selects, checkboxes)
- ✅ Tables
- ✅ Modals
- ✅ Dropdowns
- ✅ Navbar
- ✅ Buttons
- ✅ Alerts
- ✅ Pagination
- ✅ Breadcrumbs
- ✅ List Groups
- ✅ Accordions
- ✅ Progress bars
- ✅ Toasts
- ✅ Tooltips & Popovers
- ✅ Offcanvas

### Componentes Personalizados
- ✅ Cards personalizadas (gazette-card, link-card, blog-card)
- ✅ Folders
- ✅ Iconos
- ✅ Avatar de ciudadano
- ✅ Carruseles Owl Carousel

## Personalización

### Agregar Nuevos Colores
Para agregar nuevos colores que respeten el sistema de temas:

```css
:root {
    /* Modo claro (por defecto) */
    --mi-color-personalizado: #valor-claro;
}

.dark-mode {
    /* Modo oscuro */
    --mi-color-personalizado: #valor-oscuro;
}

/* Uso */
.mi-componente {
    background-color: var(--mi-color-personalizado);
}
```

### Verificar Contraste
Utiliza herramientas como:
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Colour Contrast Analyser](https://www.tpgi.com/color-contrast-checker/)

## Problemas Conocidos y Soluciones

### Imágenes en Modo Oscuro
Las imágenes se atenúan ligeramente en modo oscuro (opacity: 0.9) para mejor integración.

### Transiciones
Las transiciones están deshabilitadas durante la carga de la página para evitar efectos no deseados.

### Compatibilidad
- ✅ Chrome 88+
- ✅ Firefox 85+
- ✅ Safari 14+
- ✅ Edge 88+

## Debugging

### Verificar Estado Actual
```javascript
console.log('Tema actual:', window.themeSwitcher.getCurrentTheme());
console.log('¿Modo oscuro?', window.themeSwitcher.isDarkMode());
console.log('Tema almacenado:', localStorage.getItem('theme'));
```

### Forzar Tema para Testing
```javascript
// Forzar modo oscuro temporalmente
document.body.className = 'dark-mode';
document.documentElement.setAttribute('data-bs-theme', 'dark');
```

## Contribución

Al agregar nuevos componentes, asegúrate de:
1. Usar variables CSS existentes
2. Verificar contraste AAA
3. Probar en ambos modos
4. Incluir transiciones suaves
5. Considerar accesibilidad
