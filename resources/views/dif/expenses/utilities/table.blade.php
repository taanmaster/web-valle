<div>
    {{--
    @if ($blogs->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay elementos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('blog.admin.create') }}" class="btn btn-sm btn-primary btn-uppercase"><i
                                    class="fas fa-plus"></i> Nueva
                                Entrada</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-md-10">
                <livewire:blog.entries-table />
            </div>
        </div>

        <div class="align-items-center mt-4">
            {{ $blogs->links('pagination::bootstrap-5') }}
        </div>
    @endif
     --}}
    <h1>hi</h1>
</div>
