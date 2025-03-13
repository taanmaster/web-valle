<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
</head>
<body>
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

    <script>
        const html = document.documentElement;
        const body = document.body;
        const menuLinks = document.querySelectorAll(".admin-menu a");
        const collapseBtn = document.querySelector(".admin-menu .collapse-btn");
        const toggleMobileMenu = document.querySelector(".toggle-mob-menu");
        const switchInput = document.querySelector(".switch input");
        const switchLabel = document.querySelector(".switch label");
        const switchLabelText = switchLabel.querySelector("span:last-child");
        const collapsedClass = "collapsed";
        const lightModeClass = "light-mode";

        /*TOGGLE HEADER STATE*/
        collapseBtn.addEventListener("click", function () {
        body.classList.toggle(collapsedClass);
        this.getAttribute("aria-expanded") == "true"
            ? this.setAttribute("aria-expanded", "false")
            : this.setAttribute("aria-expanded", "true");
        this.getAttribute("aria-label") == "ocultar menu"
            ? this.setAttribute("aria-label", "mostrar menu")
            : this.setAttribute("aria-label", "ocultar menu");
        });

        /*TOGGLE MOBILE MENU*/
        toggleMobileMenu.addEventListener("click", function () {
        body.classList.toggle("mob-menu-opened");
        this.getAttribute("aria-expanded") == "true"
            ? this.setAttribute("aria-expanded", "false")
            : this.setAttribute("aria-expanded", "true");
        this.getAttribute("aria-label") == "abrir menu"
            ? this.setAttribute("aria-label", "cerrar menu")
            : this.setAttribute("aria-label", "abrir menu");
        });

        /*SHOW TOOLTIP ON MENU LINK HOVER*/
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

        /*TOGGLE LIGHT/DARK MODE*/
        if (localStorage.getItem("dark-mode") === "false") {
            html.classList.add(lightModeClass);
            switchInput.checked = false;
            switchLabelText.textContent = "Claro";
        }

        switchInput.addEventListener("input", function () {
        html.classList.toggle(lightModeClass);
        if (html.classList.contains(lightModeClass)) {
            switchLabelText.textContent = "Claro";
            localStorage.setItem("dark-mode", "false");
        } else {
            switchLabelText.textContent = "Oscuro";
            localStorage.setItem("dark-mode", "true");
        }
        });
    </script>

    <script src="{{ asset('front/libs/wowjs/wow.js') }}"></script>
    <script>
        new WOW().init();
    </script>

    @stack('scripts')
</body>
</html>
