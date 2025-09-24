<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <title>Valle de Santiago</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="{{ asset('front/libs/wowjs/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}">

    @stack('styles')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QDGMGZTQ0K"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-QDGMGZTQ0K');
    </script>
</head>
<body class="preload light-mode">
    @include('front.layouts.main_nav')

    <section class="page-content">
        @include('front.layouts.header')

        <section class="content-body">
            @yield('content')
        </section>

        @include('front.layouts.footer')
    </section>
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Theme System -->
    <script src="{{ asset('front/js/theme-system.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remover clase preload después de que todo esté cargado
            setTimeout(() => {
                document.body.classList.remove('preload');
            }, 100);

            // Variables de menu
            const body = document.body;
            const menuLinks = document.querySelectorAll(".admin-menu a");
            const collapseBtn = document.querySelector(".admin-menu .collapse-btn");
            const toggleMobileMenu = document.querySelector(".toggle-mob-menu");
            const collapsedClass = "collapsed";

            // Toggle Header State
            if (collapseBtn) {
                collapseBtn.addEventListener("click", function () {
                    body.classList.toggle(collapsedClass);
                    
                    const isCollapsed = body.classList.contains(collapsedClass);
                    
                    // Update aria-expanded
                    this.setAttribute("aria-expanded", isCollapsed ? "false" : "true");
                    
                    // Update aria-label
                    this.setAttribute("aria-label", isCollapsed ? "mostrar menu" : "ocultar menu");
                    
                    // Update button text
                    const buttonText = this.querySelector("span");
                    if (buttonText) {
                        buttonText.textContent = isCollapsed ? "Mostrar Menú" : "Ocultar Menú";
                    }
                });
            }

            // Toggle Mobile Menu
            if (toggleMobileMenu) {
                toggleMobileMenu.addEventListener("click", function () {
                    body.classList.toggle("mob-menu-opened");
                    this.getAttribute("aria-expanded") == "true"
                        ? this.setAttribute("aria-expanded", "false")
                        : this.setAttribute("aria-expanded", "true");
                    this.getAttribute("aria-label") == "abrir menu"
                        ? this.setAttribute("aria-label", "cerrar menu")
                        : this.setAttribute("aria-label", "abrir menu");
                });
            }

            // Show Tooltip on Menu Link Hover
            for (const link of menuLinks) {
                link.addEventListener("mouseenter", function () {
                    if (
                        body.classList.contains(collapsedClass) &&
                        window.matchMedia("(min-width: 768px)").matches
                    ) {
                        const tooltip = this.querySelector("span").textContent;
                        this.setAttribute("title", tooltip);
                    } else {
                        this.removeAttribute("title");
                    }
                });
            }

            // Agregar título al botón collapse cuando está colapsado
            if (collapseBtn) {
                const updateCollapseTitle = () => {
                    if (
                        body.classList.contains(collapsedClass) &&
                        window.matchMedia("(min-width: 768px)").matches
                    ) {
                        collapseBtn.setAttribute("title", "Mostrar Menú");
                    } else {
                        collapseBtn.removeAttribute("title");
                    }
                };

                // Actualizar título cuando se hace hover
                collapseBtn.addEventListener("mouseenter", updateCollapseTitle);
                
                // Actualizar título cuando cambia el estado
                collapseBtn.addEventListener("click", function() {
                    setTimeout(updateCollapseTitle, 100);
                });
            }

            // Theme change listener para debug
            document.addEventListener('themeChanged', function(e) {
                console.log('✅ Tema cambiado a:', e.detail.theme);
                
                // Debug: mostrar variables CSS actuales
                const rootStyles = getComputedStyle(document.documentElement);
                console.log('🎨 Variables CSS actuales:');
                console.log('  --page-content-bgColor:', rootStyles.getPropertyValue('--page-content-bgColor'));
                console.log('  --page-header-bgColor:', rootStyles.getPropertyValue('--page-header-bgColor'));
                console.log('  --bs-body-bg:', rootStyles.getPropertyValue('--bs-body-bg'));
            });
        });
    </script>

    <script src="{{ asset('front/libs/wowjs/wow.js') }}"></script>
    <script>
        new WOW().init();
    </script>

    @stack('scripts')
</body>
</html>
