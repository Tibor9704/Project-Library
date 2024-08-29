@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="list-group">
            <h1>Projektek</h1>
        </ul>
        <form id="status-filter-form" action="{{ route('projects.index') }}" method="GET" class="mb-3">
            <div class="form-group">
                <select name="status" id="status" class="form-control" onchange="submitForm()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Összes</option>
                    <option value="fejlesztésre vár" {{ request('status') == 'fejlesztésre vár' ? 'selected' : '' }}>Fejlesztésre vár</option>
                    <option value="folyamatban" {{ request('status') == 'folyamatban' ? 'selected' : '' }}>Folyamatban</option>
                    <option value="kész" {{ request('status') == 'kész' ? 'selected' : '' }}>Kész</option>
                </select>
            </div>
        </form>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        @if ($projects->count())
            <ul class="list-group">
                @foreach ($projects as $project)
                    <li class="list-group-item project-item">
                        <div class="project-details">
                            <strong>{{ $project->name }}</strong>
                            <p>{{ $project->description }}</p>
                        </div>
                        <div class="project-actions">
                            <span class="contact-info">
                                <i class="fas fa-phone">☎️</i> {{ $project->contacts_count }}
                            </span>
                            <span class="badge status-badge status-{{ 
                                $project->status === 'fejlesztésre vár' ? 'waiting' :
                                ($project->status === 'folyamatban' ? 'in-progress' :
                                ($project->status === 'kész' ? 'completed' : 'default')) 
                            }}">
                                @if ($project->status === 'fejlesztésre vár')
                                    ⏳  
                                @elseif ($project->status === 'folyamatban')
                                    🔄  
                                @elseif ($project->status === 'kész')
                                    ✅ 
                                @else
                                    ❓ 
                                @endif
                            </span>
                            <div class="project-buttons">
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törölni szeretnéd ezt a projektet?')">Törlés</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="pagination-container mt-3">
                <ul class="pagination">
                    <li class="page-item {{ $projects->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $projects->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
            
                    @for ($i = 1; $i <= $projects->lastPage(); $i++)
                        <li class="page-item {{ $i == $projects->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $projects->url($i) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor
            
                    <li class="page-item {{ $projects->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $projects->nextPageUrl() }}" aria-label="Next">
                            &raquo;
                        </a>
                    </li>
                </ul>
            </div>
            
        @else
            <div class="alert alert-info">
                <b>Jelenleg nincs egyetlen projekt sem. </b><a href="{{ route('projects.create') }}">Hozz létre egyet!</a>
            </div>
        @endif
    </div>

    <script>
        function submitForm() {
            document.getElementById('status-filter-form').submit();
        }
    </script>
@endsection
