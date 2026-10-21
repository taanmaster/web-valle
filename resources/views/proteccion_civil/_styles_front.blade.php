{{-- Estilos del entero imprimible para el portal ciudadano --}}
    <style>
        .pc-eyebrow { font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; color: #8a6d3b; font-weight: 600; }
        .pc-border { border-color: #5c1a28 !important; }
        .pc-seal { display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border: 2px solid #5c1a28; border-radius: .5rem; color: #5c1a28; font-weight: 700; }
        /* Al imprimir el entero sólo sale el documento */
        @media print {
            body * { visibility: hidden; }
            .pc-print-area, .pc-print-area * { visibility: visible; }
            .pc-print-area { position: absolute; inset: 0; }
            .pc-no-print { display: none !important; }
        }
    </style>
