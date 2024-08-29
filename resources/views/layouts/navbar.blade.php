
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/') }}">Project Library</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            @if (Route::currentRouteName() !== 'projects.create')
                <a class="nav-link" href="{{ route('projects.create') }}"><h3>Új projekt létrehozása</h3></a>
            @endif
                </form>
            </li>
        </ul>
    </div>
</nav>
