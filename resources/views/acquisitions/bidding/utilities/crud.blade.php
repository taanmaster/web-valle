<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($bidding != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver Licitación</h2>
                            @break

                            @case(2)
                                <h2>Editar licitación</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva Licitación</h2>
                    @endif
                </div>
            </div>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}


            </form>

        </div>
    </div>
</div>
