@push('stylesheets')
    <style>
        .pc-eyebrow { font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; color: #8a6d3b; font-weight: 600; }
        .pc-label { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: .25rem; }
        .pc-btn { background-color: #5c1a28; color: #fff; }
        .pc-btn:hover { background-color: #461320; color: #fff; }
        .pc-thead th { background-color: #f6f2ea; font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; color: #6c757d; }
        .pc-link { color: #5c1a28; }
        .pc-step { display: inline-flex; align-items: center; justify-content: center; width: 1.75rem; height: 1.75rem; border-radius: 50%; background-color: #5c1a28; color: #fff; font-size: .85rem; }
        .pc-timeline-item { position: relative; padding-left: 1.5rem; padding-bottom: 1.25rem; border-left: 2px solid #e5ded2; margin-left: .4rem; }
        .pc-timeline-item:last-child { border-left-color: transparent; padding-bottom: 0; }
        .pc-timeline-dot { position: absolute; left: -.45rem; top: .3rem; width: .8rem; height: .8rem; border-radius: 50%; }
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
@endpush
