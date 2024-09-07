@extends('layouts.app')

@section('content')

    <script src="{{ asset('js/index.js') }}"></script>

    <div class="container">
        <h1>Projektek</h1>

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
            <div id="successAlert" class="alert alert-success">
                {{ $message }}
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var successAlert = document.getElementById('successAlert');
                    if (successAlert) {
                        setTimeout(function() {
                            successAlert.style.opacity = '0';
                            setTimeout(function() {
                                successAlert.style.display = 'none';
                            }, 500); 
                        }, 3000); 
                    }
                });
            </script>
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
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $project->id }}" data-name="{{ $project->name }}">
                                    Törlés
                                </button>
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
            <div class="alert alert-info mt-3">
                <b>Jelenleg nincs egyetlen projekt sem.</b> <a href="{{ route('projects.create') }}">Hozz létre egyet!</a>
            </div>
        @endif
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Biztosan törölni szeretnéd?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ezt a műveletet nem lehet visszavonni! Biztosan törölni szeretnéd a projektet: <strong id="projectName"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                    <form id="delete-form" action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Igen, töröld!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
