@push('stylesheets')
    <style>
        .mk-eyebrow { font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; color: #8a6d3b; font-weight: 600; }
        .mk-label { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: .25rem; }
        .mk-btn { background-color: #5c1a28; color: #fff; }
        .mk-btn:hover { background-color: #461320; color: #fff; }
        .mk-link { color: #5c1a28; }
        .mk-thead th { background-color: #5c1a28; color: #fff; font-size: .75rem; font-weight: 600; }
        .mk-section-header { background-color: #5c1a28; color: #fff; font-size: .75rem; letter-spacing: .1em; text-transform: uppercase; font-weight: 600; }
        .mk-soft { background-color: #f6f2ea; }
        .mk-border { border-color: #5c1a28 !important; }
        .mk-seal { display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border: 2px solid #5c1a28; border-radius: .5rem; color: #5c1a28; font-weight: 700; }
        .bg-orange-subtle { background-color: #fde5cf !important; }
        .text-orange { color: #b45309 !important; }
        .mk-month.active { background-color: #5c1a28; color: #fff; }
        /* Al imprimir sólo sale el documento */
        @media print {
            body * { visibility: hidden; }
            .mk-print-area, .mk-print-area * { visibility: visible; }
            .mk-print-area { position: absolute; inset: 0; }
            .mk-page-break { break-after: page; }
            .mk-no-print { display: none !important; }
        }
    </style>
@endpush
