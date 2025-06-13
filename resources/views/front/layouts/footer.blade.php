@php
    $legals = App\Models\LegalText::all();
@endphp

<footer class="page-footer">
    <div class="container text-center">
        <div class="col-md-10 offset-md-1">
            <p class="mb-4">H. Ayuntamiento 2024-2027 de Valle de Santiago, Guanajuato. Presidencia Municipal: Dirección: Palacio Municipal S/N, Zona Centro,Valle de Santiago, Guanajuato. Tel. 01 (456) 643 00 02 . Administración: Dirección de Comunicación Social.</p>
            <p><strong>© Municipio de Valle de Santiago, Guanajuato {{ Carbon\Carbon::now()->format('Y') }}. Todos los derechos reservados.</strong></p>
            
            <ul class="list-inline">
                @foreach($legals as $legal) 
                    <li class="list-inline-item"><a href="{{ route('legal.text', $legal->slug) }}">{{ $legal->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>
