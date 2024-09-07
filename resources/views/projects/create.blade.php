@extends('layouts.app')

@section('title', 'Új projekt létrehozása')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/project-form.css') }}">
    <script src="{{ asset('js/project-form.js') }}"></script>


    <div class="container">
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

            <button type="button"   class="button" onclick="addContact()">További kapcsolattartó hozzáadása</button>

            <button type="submit" class="button">Projekt létrehozása</button>
            <button type="reset" class="button" onclick="window.location.href='{{ route('projects.index') }}'">Mégse</button>
        </form>
    </div>

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


    @if (session('warning'))
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warningModalLabel">Figyelmeztetés</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('warning') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Hiba</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Figyelmeztetés</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            @endif

            @if (session('warning'))
                var warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
                warningModal.show();
            @endif

            @if ($errors->any())
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            @endif

            @if ($errors->has('contacts'))
                var infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
                infoModal.show();
            @endif
        });
    </script>

@endsection
