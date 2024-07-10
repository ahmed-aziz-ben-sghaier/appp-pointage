@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Presence') }}</div>

                    <div class="card-body">
                        {{-- Your presence view content goes here --}}
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <p>Welcome to the Presence page to mark your presence .  </p>


                        <div class="mt-4">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#presenceModal">Mark Presence</button>
                        </div>
                        <div class="mt-4">
                            <h4>Current Date:</h4>
                            <div id="currentDate"></div>
                            <h4>Current Time:</h4>
                            <div id="clock"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modale de Présence -->
<div class="modal fade" id="presenceModal" tabindex="-1" aria-labelledby="presenceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="presenceModalLabel">Mark Presence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('submit.presence.form') }}" method="post">
                @csrf
                <!-- Add form fields for action, status, and time -->

                <div class="mb-3">
                    <label>Action :</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="actionRadio" id="actionIn" value="in">
                        <label class="form-check-label" for="actionIn">In</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="actionRadio" id="actionOut" value="out">
                        <label class="form-check-label" for="actionOut">Out</label>
                    </div>
                <div class="mb-3">
                    <label for="presenceFormStatus" class="form-label">Status</label>
                    <select class="form-control" id="presenceFormStatus" name="status" disabled>
                        <option value="present">Present</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="presenceFormTime" class="form-label">Time</label>
                    <input type="datetime-local" class="form-control" id="presenceFormTime" name="time" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="submitPresenceFormButton">Present</button>
            </form>
        </div>
    </div>
</div>
<script>
     function getCurrentTime() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();

        // Formatage pour ajouter un zéro devant les chiffres < 10
        hours = (hours < 10) ? "0" + hours : hours;
        minutes = (minutes < 10) ? "0" + minutes : minutes;

        return hours + ":" + minutes;
    }

        // Fonction pour mettre à jour la date et l'horloge
        function updateDateTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            var day = now.getDate();
            var month = now.getMonth() + 1; // Les mois commencent à 0
            var year = now.getFullYear();

            // Formatage pour ajouter un zéro devant les chiffres < 10
            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;
            month = (month < 10) ? "0" + month : month;
            day = (day < 10) ? "0" + day : day;

            var timeString = hours + ":" + minutes + ":" + seconds;
            var dateString = year + "-" + month + "-" + day;

            // Mettez à jour les éléments HTML avec la date et l'heure actuelles
            document.getElementById('currentDate').innerText = dateString;
            document.getElementById('clock').innerText = timeString;
        }

        // Mettez à jour la date et l'horloge chaque seconde
        setInterval(updateDateTime, 1000);

        // Mettez à jour l'heure actuelle lors de l'ouverture de la modale
        $('#presenceModal').on('shown.bs.modal', function (e) {
            updateDateTime();
        });
</script>


@endsection
