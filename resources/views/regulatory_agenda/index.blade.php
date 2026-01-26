@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Agendas
        @endslot
        @slot('title')
            Dependencias
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="javascript:void(0)" class="btn btn-primary new-dependency">Nueva Dependencia</a>
                </div>
            </div>

            @if ($dependecies->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay dependencias guardadas en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-uppercase new-income"><i
                                            class="fas fa-plus"></i> Nueva dependencia</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @include('regulatory_agenda.utilities._table')
                </div>

                <div class="align-items-center mt-4">
                    {{ $dependecies->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>


    <div class="modal fade" id="dependencyModal" tabindex="-1" role="dialog" aria-labelledby="dependencyModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <livewire:regulatory-agenda.dependencies-modal />
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            var dependencyModal = new bootstrap.Modal(document.getElementById('dependencyModal'), {
                keyboard: false
            });


            document.querySelectorAll('.edit-dependency').forEach(button => {
                button.addEventListener('click', function(e) {
                    const dependencyId = this.getAttribute('data-id');
                    dependencyModal.show();
                    Livewire.dispatch('selectDependency', {
                        id: dependencyId
                    });
                });
            });

            document.querySelectorAll('.new-dependency').forEach(button => {
                button.addEventListener('click', function(e) {
                    dependencyModal.show();
                    Livewire.dispatch('newDependency');
                });
            });
        </script>
    @endpush
@endsection
