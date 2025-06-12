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
            Tesorería
        @endslot
        @slot('title')
            Disposiciones Administrativas de Recaudación
        @endslot
    @endcomponent

    <div class="row layout-spacing">


        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="javascript:void(0)" class="btn btn-primary new-section">Nueva sección</a>
                </div>
            </div>

            @if ($sections->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay checklists guardados en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-uppercase new-section"><i
                                            class="fas fa-plus"></i> Nuevo
                                        Sección</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @include('tsr_admin_revenue_collection.utilities._table')
                </div>

                <div class="align-items-center mt-4">
                    {{ $sections->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>


    <div class="modal fade" id="sectionModal" tabindex="-1" role="dialog" aria-labelledby="sectionModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @livewire('tsr-admin-revenue-collection.sections-modal')
            </div>
        </div>
    </div>


    <div class="modal fade" id="articleModal" tabindex="-1" role="dialog" aria-labelledby="articleModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @livewire('tsr-admin-revenue-collection.article-modal')
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            var sectionModal = new bootstrap.Modal(document.getElementById('sectionModal'), {
                keyboard: false
            });

            document.querySelectorAll('.edit-section-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const sectionId = this.getAttribute('data-id');
                    sectionModal.show();
                    Livewire.dispatch('selectSection', {
                        id: sectionId
                    });
                });
            });

            document.querySelectorAll('.new-section').forEach(button => {
                button.addEventListener('click', function(e) {
                    sectionModal.show();
                    Livewire.dispatch('newSection');
                });
            });


            var articleModal = new bootstrap.Modal(document.getElementById('articleModal'), {
                keyboard: false
            });

            document.querySelectorAll('.edit-article').forEach(button => {
                button.addEventListener('click', function(e) {
                    const articleId = this.getAttribute('data-id');
                    articleModal.show();
                    Livewire.dispatch('selectArticle', {
                        id: articleId
                    });
                });
            });

            document.querySelectorAll('.new-article').forEach(button => {
                button.addEventListener('click', function(e) {
                    const sectionId = this.getAttribute('data-id');
                    articleModal.show();
                    Livewire.dispatch('newArticle', {
                        id: sectionId
                    });
                });
            });
        </script>
    @endpush
@endsection
