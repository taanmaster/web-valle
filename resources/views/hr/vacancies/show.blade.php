@extends('layouts.master')
@section('title')
    Recursos Humanos
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Recursos Humanos
        @endslot
        @slot('li_2')
            Vacantes
        @endslot
        @slot('title')
            Ver Vacante
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <ul class="nav nav-tabs mb-4" id="vacancyTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail"
                        type="button" role="tab" aria-controls="detail" aria-selected="true">Detalle</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="applicants-tab" data-bs-toggle="tab" data-bs-target="#applicants"
                        type="button" role="tab" aria-controls="applicants" aria-selected="false">
                        Aplicantes
                        <span class="badge bg-primary ms-1">{{ $vacancy->applications->count() }}</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="vacancyTabsContent">
                {{-- Tab Detalle --}}
                <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    <livewire:h-r.vacancy.crud :mode="$mode" :vacancy="$vacancy" />
                </div>

                {{-- Tab Aplicantes --}}
                <div class="tab-pane fade" id="applicants" role="tabpanel" aria-labelledby="applicants-tab">
                    @if ($vacancy->applications->count() == 0)
                        <div class="text-center py-5">
                            <h5>No hay aplicantes para esta vacante</h5>
                            <p class="text-muted">Los aplicantes apareceran aqui cuando apliquen desde el portal.</p>
                        </div>
                    @else
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>CV</th>
                                        <th>Fecha de aplicacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vacancy->applications as $index => $application)
                                        <tr style="cursor: pointer" data-bs-toggle="collapse"
                                            data-bs-target="#applicant-{{ $application->id }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $application->first_name }} {{ $application->last_name }}</td>
                                            <td>{{ $application->email }}</td>
                                            <td>{{ $application->phone ?? 'N/A' }}</td>
                                            <td>
                                                @if ($application->cv_path)
                                                    <a href="{{ $application->cv_url }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class='bx bx-download'></i> Descargar CV
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin CV</span>
                                                @endif
                                            </td>
                                            <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr class="collapse" id="applicant-{{ $application->id }}">
                                            <td colspan="6" class="p-0">
                                                <livewire:h-r.vacancy.applicant-detail :application="$application"
                                                    :key="'applicant-'.$application->id" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
