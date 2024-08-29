@extends('layouts.app')

@section('title', 'Új projekt létrehozása')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/project-form.css') }}">
    <script src="{{ asset('js/project-form.js') }}"></script>


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
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
            </div>
        @endif

    <h1>Új projekt létrehozása</h1>

    <form id="project-form" action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Név:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Leírás:</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="status">Státusz:</label>
            <select name="status" id="status" class="form-control" required>
                <option value="fejlesztésre vár">Fejlesztésre vár</option>
                <option value="folyamatban">Folyamatban</option>
                <option value="kész">Kész</option>
            </select>
        </div>

        <h3>Kapcsolattartók</h3>
        <div id="contacts">
            <div class="contact-form-group">
                <div class="form-group">
                    <label for="contacts[0][name]">Kapcsolattartó neve:</label>
                    <input type="text" name="contacts[0][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contacts[0][email]">Kapcsolattartó e-mail:</label>
                    <input type="email" name="contacts[0][email]" class="form-control" required>
                </div>
                <button type="button" class="btn-remove" onclick="removeContact(this)">❌</button>
            </div>
        </div>

        <button type="button" onclick="addContact()">További kapcsolattartó hozzáadása</button>

        <button type="submit" class="btn btn-primary">Projekt létrehozása</button>
        <button type="reset" class="btn btn-secondary" onclick="window.location.href='{{ route('projects.index') }}'">Mégse</button>
    </form>
    

    </div>
@endsection


