<!-- Search functionality placeholder -->
<div class="search-options d-inline-block me-2">
    <form method="GET" action="{{ route('dif.doctors.index') }}" class="d-inline-block">
        <div class="input-group" style="width: 300px; display: inline-flex;">
            <input type="text" 
                   name="search" 
                   class="form-control form-control-sm" 
                   placeholder="Buscar doctor..." 
                   value="{{ request('search') }}">
            <button class="btn btn-outline-secondary btn-sm" type="submit">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('dif.doctors.index') }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </div>
    </form>
</div>
