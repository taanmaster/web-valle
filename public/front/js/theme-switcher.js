/**
 * Cambiador de Temas para el Sitio Web de Valle de Santiago
 * Gestiona la funcionalidad de modo claro/oscuro con persistencia en localStorage
 */

class ThemeSwitcher {
    constructor() {
        this.currentTheme = this.getStoredTheme() || this.getPreferredTheme();
        this.themeToggle = document.getElementById('mode');
        this.init();
    }

    /**
     * Inicializar el cambiador de temas
     */
    init() {
        this.setTheme(this.currentTheme);
        this.updateToggle();
        this.bindEvents();
        
        // Escuchar cambios en el tema del sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (!this.getStoredTheme()) {
                this.setTheme(this.getPreferredTheme());
                this.updateToggle();
            }
        });
    }

    /**
     * Obtener el tema almacenado desde localStorage
     * @returns {string|null} El tema almacenado o null
     */
    getStoredTheme() {
        return localStorage.getItem('theme');
    }

    /**
     * Establecer tema en localStorage
     * @param {string} theme - El tema a almacenar
     */
    setStoredTheme(theme) {
        localStorage.setItem('theme', theme);
    }

    /**
     * Obtener el tema preferido del usuario desde la configuración del sistema
     * @returns {string} 'dark' o 'light'
     */
    getPreferredTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    /**
     * Establecer el tema
     * @param {string} theme - 'light' o 'dark'
     */
    setTheme(theme) {
        // Remover clases de tema existentes
        document.documentElement.setAttribute('data-bs-theme', theme);
        document.body.classList.remove('light-mode', 'dark-mode');
        
        // Agregar nueva clase de tema
        document.body.classList.add(`${theme}-mode`);
        
        // Actualizar variables CSS en el elemento raíz para efecto inmediato
        if (theme === 'dark') {
            document.documentElement.style.setProperty('--bs-body-bg', '#000000');
            document.documentElement.style.setProperty('--bs-body-color', '#ffffff');
        } else {
            document.documentElement.style.setProperty('--bs-body-bg', '#f8f9fa');
            document.documentElement.style.setProperty('--bs-body-color', '#212529');
        }
        
        this.currentTheme = theme;
        this.setStoredTheme(theme);
        
        // Disparar evento personalizado para otros componentes que puedan necesitar responder
        document.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
    }

    /**
     * Alternar entre temas claro y oscuro
     */
    toggleTheme() {
        const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        this.setTheme(newTheme);
        this.updateToggle();
    }

    /**
     * Actualizar el interruptor de alternancia para reflejar el tema actual
     */
    updateToggle() {
        if (this.themeToggle) {
            this.themeToggle.checked = this.currentTheme === 'dark';
            
            // Actualizar el texto del label
            const label = this.themeToggle.nextElementSibling;
            if (label) {
                const span = label.querySelector('span:last-child');
                if (span) {
                    span.textContent = this.currentTheme === 'dark' ? 'Claro' : 'Oscuro';
                }
            }
        }
    }

    /**
     * Vincular event listeners
     */
    bindEvents() {
        if (this.themeToggle) {
            this.themeToggle.addEventListener('change', () => {
                this.toggleTheme();
            });
        }

        // Manejar atajos de teclado (Ctrl/Cmd + Shift + L)
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'L') {
                e.preventDefault();
                this.toggleTheme();
            }
        });
    }

    /**
     * Obtener el tema actual
     * @returns {string} Tema actual
     */
    getCurrentTheme() {
        return this.currentTheme;
    }

    /**
     * Verificar si el modo oscuro está activo
     * @returns {boolean} True si el modo oscuro está activo
     */
    isDarkMode() {
        return this.currentTheme === 'dark';
    }

    /**
     * Forzar cambio a modo claro
     */
    setLightMode() {
        this.setTheme('light');
        this.updateToggle();
    }

    /**
     * Forzar cambio a modo oscuro
     */
    setDarkMode() {
        this.setTheme('dark');
        this.updateToggle();
    }
}

// Auto-inicializar cuando el DOM se haya cargado
document.addEventListener('DOMContentLoaded', () => {
    // Agregar clase preload para prevenir transiciones durante la inicialización
    document.body.classList.add('preload');
    
    // Inicializar cambiador de temas
    window.themeSwitcher = new ThemeSwitcher();
    
    // Remover clase preload después de un breve retraso para permitir que el tema se establezca
    setTimeout(() => {
        document.body.classList.remove('preload');
    }, 100);
});

// Remover clase preload cuando la página esté completamente cargada (respaldo)
window.addEventListener('load', () => {
    document.body.classList.remove('preload');
});

// Exportar para uso como módulo si es necesario
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ThemeSwitcher;
}
