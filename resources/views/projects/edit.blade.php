@extends('layouts.app')

@section('title', 'Projekt szerkesztése')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/project-form.css') }}">
    <script src="{{ asset('js/project-edit.js') }}"></script>
    <script>
        window.projectContactsCount = {{ $project->contacts->count() ?? 0 }};
    </script>

    <div class="container">
        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Projekt szerkesztése</h1>

        <form id="project-form" action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Név:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $project->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Leírás:</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Státusz:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="fejlesztésre vár" {{ old('status', $project->status) == 'fejlesztésre vár' ? 'selected' : '' }}>Fejlesztésre vár</option>
                    <option value="folyamatban" {{ old('status', $project->status) == 'folyamatban' ? 'selected' : '' }}>Folyamatban</option>
                    <option value="kész" {{ old('status', $project->status) == 'kész' ? 'selected' : '' }}>Kész</option>
                </select>
            </div>

            <h3>Kapcsolattartók</h3>
            <div id="contacts">
                @foreach($project->contacts as $index => $contact)
                    <div class="contact-form-group">
                        <div class="form-group">
                            <label for="contacts[{{ $index }}][name]">Kapcsolattartó neve:</label>
                            <input type="text" name="contacts[{{ $index }}][name]" class="form-control" value="{{ $contact->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="contacts[{{ $index }}][email]">Kapcsolattartó e-mail:</label>
                            <input type="email" name="contacts[{{ $index }}][email]" class="form-control" value="{{ $contact->email }}" required>
                        </div>
                        <button type="button" class="btn-remove" onclick="removeContact(this)">❌</button>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addContact()">További kapcsolattartó hozzáadása</button>

            <button type="submit" class="btn btn-primary">Projekt frissítése</button>
            <button type="button" class="btn btn-secondary" onclick="history.back()">Vissza</button>
        </form>
    </div>
@endsection
