@extends('layouts.app')

@section('title', 'Projekt szerkesztése')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/project-form.css') }}">

    <div class="container">
        <!-- Figyelmeztető üzenet megjelenítése -->
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
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Mégse</a>
        </form>

        <script>
            let contactIndex = {{ $project->contacts->count() }};

            function addContact() {
                const container = document.getElementById('contacts');
                const newContactFormGroup = document.createElement('div');
                newContactFormGroup.classList.add('contact-form-group');
                newContactFormGroup.innerHTML = `
                    <div class="form-group">
                        <label for="contacts[${contactIndex}][name]">Kapcsolattartó neve:</label>
                        <input type="text" name="contacts[${contactIndex}][name]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contacts[${contactIndex}][email]">Kapcsolattartó e-mail:</label>
                        <input type="email" name="contacts[${contactIndex}][email]" class="form-control" required>
                    </div>
                    <button type="button" class="btn-remove" onclick="removeContact(this)">❌</button>
                `;
                container.appendChild(newContactFormGroup);
                contactIndex++;
            }

            function removeContact(button) {
                const container = document.getElementById('contacts');
                if (container.children.length > 1) {
                    button.parentElement.remove();
                } else {
                    alert("Legalább egy kapcsolattartónak lennie kell.");
                }
            }

            document.getElementById('project-form').addEventListener('submit', function(event) {
                const contacts = document.querySelectorAll('#contacts .contact-form-group');
                if (contacts.length === 0) {
                    event.preventDefault();
                    alert("Legalább egy kapcsolattartó megadása kötelező.");
                }
            });
        </script>
    </div>
@endsection
