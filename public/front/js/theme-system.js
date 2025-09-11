/**
 * Sistema de Temas Claro / Oscuro - Valle de Santiago
 */

(function() {
    'use strict';

    class ThemeSystem {
        constructor() {
            this.currentTheme = this.getStoredTheme() || this.getPreferredTheme();
            this.init();
        }

        init() {
            // Aplicar tema inicial
            this.applyTheme(this.currentTheme);
            
            // Esperar a que el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.bindEvents());
            } else {
                this.bindEvents();
            }
        }

        getStoredTheme() {
            return localStorage.getItem('theme');
        }

        setStoredTheme(theme) {
            localStorage.setItem('theme', theme);
        }

        getPreferredTheme() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        applyTheme(theme) {
            const html = document.documentElement;
            const body = document.body;
            
            // Aplicar al elemento html (Bootstrap)
            html.setAttribute('data-bs-theme', theme);
            
            // Limpiar clases previas
            body.classList.remove('light-mode', 'dark-mode');
            
            // Aplicar nueva clase
            body.classList.add(`${theme}-mode`);
            
            // Guardar tema actual
            this.currentTheme = theme;
            this.setStoredTheme(theme);
            
            console.log(`Tema aplicado: ${theme}`);
            
            // Disparar evento personalizado
            document.dispatchEvent(new CustomEvent('themeChanged', { 
                detail: { theme: theme } 
            }));
        }

        toggleTheme() {
            const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
            this.applyTheme(newTheme);
            this.updateToggleState();
        }

        updateToggleState() {
            const toggle = document.getElementById('mode');
            if (toggle) {
                toggle.checked = this.currentTheme === 'dark';
                
                // Actualizar texto del label
                const label = toggle.nextElementSibling;
                if (label) {
                    const span = label.querySelector('span:last-child');
                    if (span) {
                        span.textContent = this.currentTheme === 'dark' ? 'Claro' : 'Oscuro';
                    }
                }
            }
        }

        bindEvents() {
            const toggle = document.getElementById('mode');
            if (toggle) {
                // Establecer estado inicial del toggle
                this.updateToggleState();
                
                // Vincular el evento
                toggle.addEventListener('change', () => {
                    this.toggleTheme();
                });
            }

            // Escuchar cambios en preferencias del sistema
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (!this.getStoredTheme()) {
                    this.applyTheme(this.getPreferredTheme());
                    this.updateToggleState();
                }
            });

            // Atajo de teclado
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'L') {
                    e.preventDefault();
                    this.toggleTheme();
                }
            });
        }

        // API pública
        getCurrentTheme() {
            return this.currentTheme;
        }

        isDarkMode() {
            return this.currentTheme === 'dark';
        }

        setLightMode() {
            this.applyTheme('light');
            this.updateToggleState();
        }

        setDarkMode() {
            this.applyTheme('dark');
            this.updateToggleState();
        }
    }

    // Inicializar el sistema de temas
    window.themeSystem = new ThemeSystem();
    
    // Compatibilidad con el nombre anterior
    window.themeSwitcher = window.themeSystem;

})();
