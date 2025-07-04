@extends('layouts.master')

@section('title')Perfiles Médicos @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('title') Perfiles Médicos @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-user-md"></i> Perfiles Médicos
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.medical_profiles.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Agregar Perfil Médico
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('dif.medical_profiles.utilities._search_options')
                    @include('dif.medical_profiles.utilities._table')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                {{ $medicalProfiles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
