@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Tesorería
        @endslot
        @slot('li_2')
            <a href="{{ route('trs_admin_revenue_collection.index') }}">
                Disposiciones Administrativas de Recaudación
            </a>
        @endslot
        @slot('title')
            Detalle del artículo
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <h4>Información General</h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p>
                        <strong>Nombre:</strong> {{ $article->name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Descripción:</strong> {{ $article->description ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>Tarifas</h3>
                <a href="javascript:void(0)" class="btn btn-primary new-fraction" style="max-width: 180px">Nueva fracción</a>
            </div>

            @if ($fractions->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay Tarifas guardadas en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-primary btn-uppercase new-fraction"><i
                                            class="fas fa-plus"></i> Nueva
                                        Fracción</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @include('tsr_admin_revenue_collection.utilities._table_show')
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    {{ $fractions->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="fractionModal" tabindex="-1" role="dialog" aria-labelledby="fractionModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <livewire:tsr-admin-revenue-collection.fraction-modal :articleId="$article->id" />
            </div>
        </div>
    </div>


    <div class="modal fade" id="clauseModal" tabindex="-1" role="dialog" aria-labelledby="clauseModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <livewire:tsr-admin-revenue-collection.clause-modal :articleId="$article->id" />
            </div>
        </div>
    </div>

    <div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <livewire:tsr-admin-revenue-collection.variant-modal :articleId="$article->id" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var fractionModal = new bootstrap.Modal(document.getElementById('fractionModal'), {
                keyboard: false
            });

            document.querySelectorAll('.new-fraction').forEach(button => {
                button.addEventListener('click', function(e) {
                    fractionModal.show();
                    Livewire.dispatch('newFraction');
                });
            });

            document.querySelectorAll('.edit-fraction').forEach(button => {
                button.addEventListener('click', function(e) {
                    const fractionId = this.getAttribute('data-id');
                    fractionModal.show();
                    Livewire.dispatch('selectFraction', {
                        id: fractionId
                    });
                });
            });

            var clauseModal = new bootstrap.Modal(document.getElementById('clauseModal'), {
                keyboard: false
            });

            document.querySelectorAll('.new-clause').forEach(button => {
                button.addEventListener('click', function(e) {
                    const fractionId = this.getAttribute('data-id');
                    clauseModal.show();
                    Livewire.dispatch('newClause', {
                        id: fractionId
                    });
                });
            });

            document.querySelectorAll('.edit-clause').forEach(button => {
                button.addEventListener('click', function(e) {
                    const clauseId = this.getAttribute('data-id');
                    clauseModal.show();
                    Livewire.dispatch('selectClause', {
                        id: clauseId
                    });
                });
            });

            var variantModal = new bootstrap.Modal(document.getElementById('variantModal'), {
                keyboard: false
            });

            document.querySelectorAll('.new-variant').forEach(button => {
                button.addEventListener('click', function(e) {
                    const clauseId = this.getAttribute('data-id');
                    variantModal.show();
                    Livewire.dispatch('newVariant', {
                        id: clauseId
                    });
                });
            });

            document.querySelectorAll('.edit-variant').forEach(button => {
                button.addEventListener('click', function(e) {
                    const variantID = this.getAttribute('data-id');
                    variantModal.show();
                    Livewire.dispatch('selectVariant', {
                        id: variantID
                    });
                });
            });
        </script>
    @endpush
@endsection
