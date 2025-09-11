/**
 * Cargador Instantáneo de Temas
 * Este script se ejecuta inmediatamente para prevenir el "parpadeo" del tema al cargar la página
 * Coloque este script en el <head> de su documento, antes de cualquier hoja de estilos
 */

(function() {
    // Obtener tema almacenado o preferencia del sistema
    function getStoredTheme() {
        return localStorage.getItem('theme');
    }
    
    function getPreferredTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    
    // Aplicar tema inmediatamente
    const theme = getStoredTheme() || getPreferredTheme();
    
    // Establecer atributos en el elemento html
    document.documentElement.setAttribute('data-bs-theme', theme);
    
    // Agregar clase al body (estará disponible cuando el body se cargue)
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add(`${theme}-mode`);
        
        // Actualizar el interruptor de alternancia si existe
        const toggle = document.getElementById('mode');
        if (toggle) {
            toggle.checked = theme === 'dark';
            
            // Actualizar texto del label
            const label = toggle.nextElementSibling;
            if (label) {
                const span = label.querySelector('span:last-child');
                if (span) {
                    span.textContent = theme === 'dark' ? 'Claro' : 'Oscuro';
                }
            }
        }
    });
    
    // Establecer propiedades CSS personalizadas iniciales para efecto inmediato
    const style = document.createElement('style');
    style.innerHTML = `
        :root {
            --initial-bg: ${theme === 'dark' ? '#000000' : '#f8f9fa'};
            --initial-color: ${theme === 'dark' ? '#ffffff' : '#212529'};
        }
        
        html {
            background-color: var(--initial-bg) !important;
            color: var(--initial-color) !important;
        }
        
        body {
            background-color: var(--initial-bg) !important;
            color: var(--initial-color) !important;
        }
    `;
    document.head.appendChild(style);
})();
