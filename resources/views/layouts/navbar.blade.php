<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/') }}">Project Library</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            @if (Route::currentRouteName() !== 'projects.create')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('projects.create') }}">Új projekt létrehozása</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
