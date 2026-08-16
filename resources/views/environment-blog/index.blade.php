@extends('layouts.master')
@section('title')
    Blog Medio Ambiente
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Medio Ambiente
        @endslot
        @slot('title')
            Blog
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="{{ route('medio_ambiente_blog.admin.create') }}" class="btn btn-primary">Nueva Entrada</a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <livewire:general-blog.entries-table :type="'medio_ambiente'" />
                </div>
            </div>
        </div>
    </div>
@endsection
