@if(Session::has('success'))
<div class="alert alert-wrapper alert-success fade show alert-dismissable alert-fixed">
    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
    <strong>¡Éxito!</strong> {{ Session::get('success') }}
</div>
@endif

@if(Session::has('info'))
<div class="alert alert-wrapper alert-info fade show alert-dismissable alert-fixed">
    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
    {{ Session::get('info') }}
</div>
@endif

@if(Session::has('warning'))
<div class="col-12">
    <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
        <strong>Kick Start you new project with ease!</strong> Learn more about Starter Kit by refering to the <a target="_blank" href="https://designreset.com/Motivaré/documentation/getting-started.html">Documentation</a>
    </div>
</div> 
@endif

@if(Session::has('error'))
<div class="alert alert-wrapper alert-danger fade show alert-dismissable alert-fixed">
    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
    <strong>¡Error!</strong> {{ Session::get('error') }}
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-wrapper alert-danger fade show alert-dismissable alert-fixed">
    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
    <strong>¡Error!</strong>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif