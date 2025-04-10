@push('stylesheets')
    <style>
        .accordion-button::after {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endpush

<div class="d-flex w-100 mb-3 px-2">
    <div class="col-md">
        Nombre
    </div>
    <div class="col-md">
        Descripción
    </div>
    <div class="col-md-2">
        Acciones
    </div>
    <div class="col-md-1">
        Agregar artículo
    </div>
    <div class="col-md-1"></div>
</div>


<div class="accordion" id="accordionExample">
    @foreach ($sections as $section)
        <div class="accordion-item">
            <div class="accordion-header row align-items-center w-100 mx-0">
                <div class="col-md">
                    <strong>{{ $section->name }}</strong>
                </div>
                <div class="col-md">
                    {{ $section->description ?? 'N/A' }}
                </div>
                <div class="col-md-2">
                    <div style="gap: 12px">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#sectionModal"
                            class="btn btn-sm btn-outline-secondary"
                            onclick="Livewire.dispatch('selectSection', {{ $section }})">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('revenue_collection_sections.destroy', $section->id) }}"
                            style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bx bx-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="btn-group" role="group">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#articleModal"
                            class="btn btn-sm btn-outline-primary"
                            onclick="Livewire.dispatch('newArticleModal', {{ $section }})">
                            +
                        </a>
                    </div>
                </div>
                <div class="col-md-1 pe-0 d-flex justify-content-center">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="{{ '#collapse' . $section->id }}" aria-expanded="false"
                        aria-controls="{{ 'collapse' . $section->id }}" style="width: 100%">
                    </button>
                </div>
            </div>
            <div id="{{ 'collapse' . $section->id }}" class="accordion-collapse collapse"
                data-bs-parent="#accordionExample">
                <div class="accordion-body px-3 py-2">

                    <h4 class="mb-3 mt-0">Artículos</h4>

                    @if ($section->articles->count() == 0)
                        <div class="row w-100">
                            <div class="col-lg-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center" style="padding:40px 0px 60px 0px;">
                                            <h4>¡No hay articulos guardados en la base de datos!</h4>
                                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#articleModal"
                                                class="btn btn-sm btn-primary btn-uppercase"
                                                onclick="Livewire.dispatch('newArticleModal', {{ $section }})"><i
                                                    class="fas fa-plus"></i>
                                                Nuevo Artículo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($section->articles as $article)
                            <div class="row w-100">
                                <div class="col-md">
                                    {{ $article->name }}
                                </div>
                                <div class="col-md">
                                    {{ $article->description ?? 'N/A' }}
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group" role="group" style="gap: 12px">
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#articleModal" class="btn btn-sm btn-outline-secondary"
                                            onclick="Livewire.dispatch('selectArticle', {{ $article }})">
                                            <i class="bx bx-edit"></i> Editar
                                        </a>

                                        <form method="POST"
                                            action="{{ route('revenue_collection_articles.destroy', $article->id) }}"
                                            style="display: inline-block;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('trs_admin_revenue_collection.show', $article->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show-alt"></i> Ver
                                    </a>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
