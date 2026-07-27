@extends('front.layouts.app')

@section('content')
    <div class="content">
        <div class="container py-4">

            {{-- Migas de pan --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small mb-0" style="background: transparent">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tramites_y_servicios.index') }}">Trámites y servicios</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $request->name }}</li>
                </ol>
            </nav>

            {{-- ENCABEZADO --}}
            <div class="card card-normal mb-4">
                <div class="card-content w-100 p-4">
                    @if ($request->type)
                        <span
                            class="badge bg-primary bg-opacity-10 text-primary mb-2">{{ mb_strtoupper($request->type) }}</span>
                    @endif

                    <h1 class="fw-bold">{{ $request->name }}</h1>

                    @if ($request->description)
                        <p class="text-muted mb-3">{{ Str::limit($request->description, 220) }}</p>
                    @endif

                    {{-- Datos rápidos --}}
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if ($request->applicable_amount)
                            <span class="border rounded-pill px-3 py-2 small bg-white">
                                <ion-icon name="cash-outline" class="align-middle me-1"></ion-icon>
                                <strong>Costo</strong> · {{ $request->applicable_amount }}
                            </span>
                        @endif
                        @if ($request->resolution_time)
                            <span class="border rounded-pill px-3 py-2 small bg-white">
                                <ion-icon name="time-outline" class="align-middle me-1"></ion-icon>
                                <strong>Resolución</strong> · {{ $request->resolution_time }}
                                {{ mb_strtolower($request->resolution_time_unit ?? '') }}
                            </span>
                        @endif
                        @if ($request->modality_label !== '—')
                            <span class="border rounded-pill px-3 py-2 small bg-white">
                                <ion-icon name="desktop-outline" class="align-middle me-1"></ion-icon>
                                <strong>{{ $request->modality_label }}</strong>
                            </span>
                        @endif
                    </div>

                    {{-- Acciones principales --}}
                    <div class="d-flex flex-wrap gap-2">
                        @if ($request->can_start_online && $request->online_url)
                            <a href="{{ $request->online_url }}" target="_blank" rel="noopener" class="btn btn-primary">
                                Iniciar trámite en línea
                                <ion-icon name="arrow-forward-outline" class="align-middle ms-1"></ion-icon>
                            </a>
                        @endif
                        @if ($request->format_filename)
                            <a href="{{ $request->format_filename }}" target="_blank" class="btn btn-outline-primary">
                                <ion-icon name="download-outline" class="align-middle me-1"></ion-icon>
                                Descargar formato
                            </a>
                        @endif
                        @if ($request->steps_filename)
                            <a href="{{ $request->steps_filename }}" target="_blank" class="btn btn-outline-secondary">
                                <ion-icon name="list-outline" class="align-middle me-1"></ion-icon>
                                Pasos para el trámite en línea
                            </a>
                        @endif
                        @if ($request->procedure_filename)
                            <a href="{{ $request->procedure_filename }}" target="_blank" class="btn btn-outline-secondary">
                                <ion-icon name="document-text-outline" class="align-middle me-1"></ion-icon>
                                Ficha del trámite
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- COLUMNA PRINCIPAL --}}
                <div class="col-lg-8">

                    @if ($request->description)
                        <div class="mb-4">
                            <h3 class="fw-bold">¿Qué es y para qué sirve?</h3>
                            <p>{{ $request->description }}</p>
                        </div>
                    @endif

                    @if ($request->responsible_subject)
                        <div class="mb-4">
                            <h3 class="fw-bold">¿Quién puede solicitarlo?</h3>
                            <p>{{ $request->responsible_subject }}</p>
                        </div>
                    @endif

                    {{-- Requisitos --}}
                    @if ($request->requirementItems->count() > 0)
                        <div class="mb-4">
                            <h3 class="fw-bold">¿Qué necesito?</h3>
                            <div class="list-group">
                                @foreach ($request->requirementItems as $item)
                                    <div class="list-group-item py-3">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                            <div>
                                                <ion-icon name="checkmark-outline"
                                                    class="align-middle text-success me-1"></ion-icon>
                                                <strong>{{ $item->name }}</strong>
                                                @if ($item->observations)
                                                    <div class="small text-muted ms-4">{{ $item->observations }}</div>
                                                @endif
                                            </div>
                                            <div class="d-flex gap-2">
                                                @if ($item->third_party_issued)
                                                    <span
                                                        class="badge bg-warning-subtle text-warning-emphasis border rounded-pill">Lo
                                                        emite un tercero</span>
                                                @endif
                                                @foreach ($item->presentation ?? [] as $presentation)
                                                    <span
                                                        class="badge bg-light text-dark border rounded-pill">{{ $presentation }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif ($request->requirements)
                        {{-- Compatibilidad con el campo de texto anterior --}}
                        <div class="mb-4">
                            <h3 class="fw-bold">¿Qué necesito?</h3>
                            <p>{{ $request->requirements }}</p>
                        </div>
                    @endif

                    {{-- Costos --}}
                    @if (
                        $request->applicable_amount ||
                            $request->variable_fee_method ||
                            count($request->payment_options ?? []) > 0 ||
                            $request->costs->count() > 0)
                        <div class="mb-4">
                            <h3 class="fw-bold">¿Cuánto cuesta?</h3>
                            <div class="card card-normal">
                                <div class="card-content w-100 p-4">
                                    @if ($request->applicable_amount)
                                        <p class="mb-2">
                                            El costo es <strong>{{ $request->applicable_amount }}</strong>
                                            @if ($request->variable_fee_method)
                                                y se calcula {{ mb_strtolower($request->variable_fee_method) }}
                                            @endif.
                                        </p>
                                    @elseif ($request->variable_fee_method)
                                        <p class="mb-2">{{ $request->variable_fee_method }}</p>
                                    @endif

                                    @if ($request->fee_legal_basis)
                                        <p class="small text-muted mb-3">Conforme a {{ $request->fee_legal_basis }}.</p>
                                    @endif

                                    @if ($request->costs->count() > 0)
                                        <div class="table-responsive mb-3">
                                            <table class="table table-striped table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Valor</th>
                                                        <th>Descripción del valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($request->costs as $cost)
                                                        <tr>
                                                            <td>$ {{ number_format((float) $cost->ammount, 2) }}</td>
                                                            <td>{{ $cost->description }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    @if (count($request->payment_options ?? []) > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($request->payment_options as $option)
                                                <span
                                                    class="badge bg-light text-dark border rounded-pill px-3 py-2">{{ $option }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Plazos --}}
                    @if ($request->resolution_time)
                        <div class="mb-4">
                            <h3 class="fw-bold">¿Cuánto tarda?</h3>
                            <div class="card card-normal">
                                <div class="card-content w-100 p-4">
                                    <div class="d-flex align-items-baseline flex-wrap gap-2">
                                        <span class="display-6 fw-bold text-primary">{{ $request->resolution_time }}</span>
                                        <span>{{ mb_strtolower($request->resolution_time_unit ?? '') }} como plazo máximo
                                            de resolución.</span>
                                    </div>
                                    @if ($request->afirmativa_ficta)
                                        <p class="small text-muted mb-0 mt-2">
                                            Aplica <strong>afirmativa ficta</strong>: si no hay respuesta en el plazo, se
                                            entiende aprobada.
                                        </p>
                                    @elseif ($request->negativa_ficta)
                                        <p class="small text-muted mb-0 mt-2">
                                            Aplica <strong>negativa ficta</strong>: si no hay respuesta en el plazo, se
                                            entiende negada.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Oficinas y horarios --}}
                    @if ($request->reception_address || $request->schedule_days || $request->contact_area)
                        <div class="mb-4">
                            <h3 class="fw-bold">¿Dónde lo hago?</h3>
                            <div class="card card-normal">
                                <div class="card-content w-100 p-4">
                                    @if ($request->contact_area || $request->reception_address)
                                        <h5 class="fw-bold mb-1">{{ $request->contact_area }}</h5>
                                        @if ($request->reception_address)
                                            <p class="text-muted mb-3">{{ $request->reception_address }}</p>
                                        @endif
                                    @endif

                                    <div class="row g-3">
                                        @if ($request->schedule_days)
                                            <div class="col-md-4">
                                                <div class="small text-muted">
                                                    <ion-icon name="time-outline" class="align-middle me-1"></ion-icon>
                                                    Días y horarios de atención
                                                </div>
                                                <strong>{{ $request->schedule_days }}</strong>
                                            </div>
                                        @endif
                                        @if ($request->schedule_reception)
                                            <div class="col-md-4">
                                                <div class="small text-muted">
                                                    <ion-icon name="file-tray-full-outline"
                                                        class="align-middle me-1"></ion-icon>
                                                    Recepción de documentos
                                                </div>
                                                <strong>{{ $request->schedule_reception }}</strong>
                                            </div>
                                        @endif
                                        @if ($request->schedule_resolution)
                                            <div class="col-md-4">
                                                <div class="small text-muted">
                                                    <ion-icon name="checkmark-done-outline"
                                                        class="align-middle me-1"></ion-icon>
                                                    Entrega de resolución
                                                </div>
                                                <strong>{{ $request->schedule_resolution }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($request->has_alternate_office === false)
                                        <p class="small text-danger mt-3 mb-0">
                                            <ion-icon name="close-circle-outline" class="align-middle me-1"></ion-icon>
                                            Sin ventanilla alterna ni módulo móvil.
                                        </p>
                                    @elseif ($request->has_alternate_office && $request->alternate_office_url)
                                        <p class="small mt-3 mb-0">
                                            <a href="{{ $request->alternate_office_url }}" target="_blank"
                                                rel="noopener">
                                                Ver ubicación de la ventanilla alterna o módulo móvil
                                            </a>
                                        </p>
                                    @endif

                                    @if ($request->non_working_days)
                                        <p class="small text-muted border-top pt-3 mt-3 mb-0">
                                            <strong>Días inhábiles:</strong> {{ $request->non_working_days }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- BARRA LATERAL --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5 class="text-white mb-0">Datos clave</h5>
                        </div>
                        <div class="card-body">
                            @if ($request->applicable_amount)
                                <div class="d-flex justify-content-between border-bottom py-2 small">
                                    <span class="text-muted">Costo</span>
                                    <strong>{{ $request->applicable_amount }}</strong>
                                </div>
                            @endif
                            @if ($request->resolution_time)
                                <div class="d-flex justify-content-between border-bottom py-2 small">
                                    <span class="text-muted">Tiempo</span>
                                    <strong>{{ $request->resolution_time }}
                                        {{ mb_strtolower($request->resolution_time_unit ?? '') }}</strong>
                                </div>
                            @endif
                            @if ($request->modality_label !== '—')
                                <div class="d-flex justify-content-between border-bottom py-2 small">
                                    <span class="text-muted">Modalidad</span>
                                    <strong>{{ $request->modality_label }}</strong>
                                </div>
                            @endif
                            @if ($request->validity)
                                <div class="d-flex justify-content-between border-bottom py-2 small">
                                    <span class="text-muted">Vigencia</span>
                                    <strong>{{ $request->validity }}</strong>
                                </div>
                            @endif
                            @if ($request->can_finish_online !== null)
                                <div class="d-flex justify-content-between py-2 small">
                                    <span class="text-muted">¿Concluye en línea?</span>
                                    <strong>{{ $request->can_finish_online ? 'Sí' : 'No' }}</strong>
                                </div>
                            @endif

                            @if ($request->can_start_online && $request->online_url)
                                <a href="{{ $request->online_url }}" target="_blank" rel="noopener"
                                    class="btn btn-primary w-100 mt-3">
                                    Iniciar trámite
                                    <ion-icon name="arrow-forward-outline" class="align-middle ms-1"></ion-icon>
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($request->contact_email || $request->contact_phone)
                        <div class="card card-normal">
                            <div class="card-content w-100 p-3 small">
                                ¿Dudas?
                                @if ($request->contact_email)
                                    Escríbenos a <a
                                        href="mailto:{{ $request->contact_email }}">{{ $request->contact_email }}</a>
                                @endif
                                @if ($request->contact_email && $request->contact_phone)
                                    o
                                @endif
                                @if ($request->contact_phone)
                                    llama al {{ $request->contact_phone }}
                                @endif
                                @if ($request->contact_advisor)
                                    <div class="text-muted mt-1">Te atiende: {{ $request->contact_advisor }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TRÁMITES RELACIONADOS --}}
            @if ($request->relatedProcedures->count() > 0)
                <div class="mt-4">
                    <h3 class="fw-bold">Trámites relacionados</h3>
                    <p class="text-muted small">Otros trámites que quizá necesites antes o después de este.</p>

                    <div class="row g-3">
                        @foreach ($request->relatedProcedures as $related)
                            <div class="col-md-6 col-lg-4">
                                <div class="card card-normal h-100">
                                    <div class="card-content w-100 p-3">
                                        <div class="small fw-bold text-primary text-uppercase mb-1">
                                            @switch($related->relation_type)
                                                @case('Requisito previo')
                                                    Lo necesitas antes
                                                @break

                                                @case('Trámite posterior')
                                                    Después de este
                                                @break

                                                @default
                                                    Relacionado
                                            @endswitch
                                        </div>
                                        <strong>{{ $related->name }}</strong>
                                        <div class="small text-muted">
                                            {{ $related->subject_level }}{{ $related->homoclave ? ' · ' . $related->homoclave : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- INFORMACIÓN LEGAL Y NORMATIVA --}}
            @php
                $hasLegal =
                    $request->legal_basis ||
                    $request->regulation_name ||
                    $request->resolution_criteria ||
                    $request->sanction_conduct ||
                    $request->collects_personal_data !== null;
            @endphp
            @if ($hasLegal)
                <div class="mt-4 mb-5">
                    <p class="small text-muted text-uppercase fw-bold mb-2">Información legal y normativa</p>

                    <div class="accordion" id="legalAccordion">
                        @if ($request->legal_basis)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#legalBasis">
                                        Fundamento jurídico
                                    </button>
                                </h2>
                                <div id="legalBasis" class="accordion-collapse collapse"
                                    data-bs-parent="#legalAccordion">
                                    <div class="accordion-body">{{ $request->legal_basis }}</div>
                                </div>
                            </div>
                        @endif

                        @if ($request->regulation_name)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#regulation">
                                        Regulación aplicable
                                    </button>
                                </h2>
                                <div id="regulation" class="accordion-collapse collapse"
                                    data-bs-parent="#legalAccordion">
                                    <div class="accordion-body">
                                        {{ $request->regulation_name }}@if ($request->regulation_articles)
                                            , {{ $request->regulation_articles }}
                                        @endif.
                                        @if ($request->regulation_media || $request->regulation_publication_date)
                                            <div class="small text-muted mt-2">
                                                @if ($request->regulation_media)
                                                    Publicada en {{ $request->regulation_media }}
                                                @endif
                                                @if ($request->regulation_publication_date)
                                                    el
                                                    {{ \Carbon\Carbon::parse($request->regulation_publication_date)->format('d/m/Y') }}
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($request->resolution_criteria || $request->validity)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#criteria">
                                        Criterios de resolución
                                    </button>
                                </h2>
                                <div id="criteria" class="accordion-collapse collapse" data-bs-parent="#legalAccordion">
                                    <div class="accordion-body">
                                        <div class="row g-3 mb-2">
                                            @if ($request->validity)
                                                <div class="col-auto">
                                                    <div class="small text-muted">Vigencia de la resolución</div>
                                                    <strong>{{ $request->validity }}</strong>
                                                </div>
                                            @endif
                                            @if ($request->allows_renewal !== null)
                                                <div class="col-auto">
                                                    <div class="small text-muted">¿Procede renovación?</div>
                                                    <strong>{{ $request->allows_renewal ? 'Sí' : 'No' }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($request->resolution_criteria)
                                            <div class="small text-muted">Criterios de resolución</div>
                                            {{ $request->resolution_criteria }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($request->sanction_conduct)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#sanctions">
                                        Sanciones
                                    </button>
                                </h2>
                                <div id="sanctions" class="accordion-collapse collapse" data-bs-parent="#legalAccordion">
                                    <div class="accordion-body">
                                        <p class="small text-muted mb-2">
                                            Estas son las consecuencias previstas en la norma si no se cumple:
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <div>
                                                <strong>{{ $request->sanction_conduct }}</strong>
                                                @if ($request->sanction_legal_basis)
                                                    <div class="small text-muted">{{ $request->sanction_legal_basis }}
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($request->sanction_applicable)
                                                <span
                                                    class="badge bg-danger-subtle text-danger-emphasis border rounded-pill px-3 py-2">
                                                    {{ $request->sanction_applicable }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($request->collects_personal_data)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#privacy">
                                        Aviso de privacidad
                                    </button>
                                </h2>
                                <div id="privacy" class="accordion-collapse collapse" data-bs-parent="#legalAccordion">
                                    <div class="accordion-body">
                                        Este trámite recaba datos
                                        personales{{ $request->personal_data_types ? ' (' . mb_strtolower($request->personal_data_types) . ')' : '' }}
                                        tratados conforme
                                        {{ $request->privacy_notice_name ? 'al ' . $request->privacy_notice_name : 'al aviso de privacidad del Municipio' }}.
                                        @if ($request->privacy_notice_url)
                                            <a href="{{ $request->privacy_notice_url }}" target="_blank"
                                                rel="noopener">Consultar aviso completo</a>.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
