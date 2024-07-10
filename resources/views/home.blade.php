@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                    <h3>welcome to the user Dashboard</h3>

                    {{ __('You are logged in!') }}
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#presenceModal">Marquer la Présence</button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#delayRequestModal">Demander un Retard</button>
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
<!-- Modale de Présence -->
<div class="modal fade" id="presenceModal" tabindex="-1" aria-labelledby="presenceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="presenceModalLabel">Marquer la Présence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Date et heure actuelles : <span id="currentDateTime"></span></p>
                <p>Choisissez l'action appropriée :</p>


                <div class="btn-group" role="group" aria-label="First Series">
                    <button type="button" class="btn btn-primary" id="in815Button" onclick="openPresenceForm('in', '08:15')">In (8:15)</button>
                    <button type="button" class="btn btn-danger" id="out1200Button" onclick="openPresenceForm('out', '12:00')">Out (12:00)</button>
                </div>


                <div class="btn-group mt-3" role="group" aria-label="Second Series">
                    <button type="button" class="btn btn-primary" id="in1300Button" onclick="openPresenceForm('in', '13:00')">In (13:00)</button>
                    <button type="button" class="btn btn-danger" id="out1700Button" onclick="openPresenceForm('out', '17:00')">Out (17:00)</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delayRequestModal" tabindex="-1" aria-labelledby="delayRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delayRequestModalLabel">Demander un Retard</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="delayRequestForm" action="{{ route('submit.delay.request') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="delayDate" class="form-label">Date de Retard</label>
                        <input type="date" class="form-control" id="delayDate" name="delayDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="delayTime" class="form-label">Temps de Retard</label>
                        <input type="time" class="form-control" id="delayTime" name="delayTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="delayReason" class="form-label">Raison du Retard</label>
                        <textarea class="form-control" id="delayReason" name="delayReason" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Soumettre</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="presenceFormModal" tabindex="-1" aria-labelledby="presenceFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="presenceForm" action="{{ route('submit.presence.form') }}" method="post">
                @csrf
                <input type="hidden" name="action" id="presenceFormAction">
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
            var month = now.getMonth() + 1;
            var year = now.getFullYear();


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


        setInterval(updateDateTime, 1000);

        // Mettez à jour l'heure actuelle lors de l'ouverture de la modale
        $('#presenceModal').on('shown.bs.modal', function (e) {
            updateDateTime();
        });
    function openPresenceForm(action, time) {
        // Remplir les champs du formulaire
        document.getElementById('presenceFormAction').value = action;
        document.getElementById('presenceFormStatus').value = 'present';
        document.getElementById('presenceFormTime').value = time;

        // Ouvrir le formulaire de présence
        $('#presenceFormModal').modal('show');
    }




    // Fonction pour démarrer le chronomètre et vérifier les plages horaires
function startTimer() {
    var currentTime = new Date();
    var currentHours = currentTime.getHours();
    var currentMinutes = currentTime.getMinutes();
    var currentSeconds = currentTime.getSeconds();

    // Convertir l'heure actuelle en minutes pour faciliter la comparaison
    var totalCurrentMinutes = currentHours * 60 + currentMinutes;

    // Plages horaires pour chaque bouton
    var in815StartTime = 5 * 60; // 5:00
    var in815EndTime = 9 * 60 ; // 9:00
    var out1200StartTime = 12 * 60; // 12:00
    var out1200EndTime = 12 * 60 + 59; // 12:59
    var in1300StartTime = 12 * 60 + 30; // 12:30
    var in1300EndTime = 13 * 60 + 5; // 13:05
    var out1700StartTime = 17 * 60; // 17:00
    var out1700EndTime = 20 * 60; // 20:00

    // Vérifier si le temps actuel est dans la plage horaire spécifique pour chaque bouton
    var isIn815Time = totalCurrentMinutes >= in815StartTime && totalCurrentMinutes <= in815EndTime;
    var isOut1200Time = totalCurrentMinutes >= out1200StartTime && totalCurrentMinutes <= out1200EndTime;
    var isIn1300Time = totalCurrentMinutes >= in1300StartTime && totalCurrentMinutes <= in1300EndTime;
    var isOut1700Time = totalCurrentMinutes >= out1700StartTime && totalCurrentMinutes <= out1700EndTime;

    // Activer ou désactiver les boutons en fonction du temps actuel
    document.getElementById('in815Button').disabled = !isIn815Time;
    document.getElementById('out1200Button').disabled = !isOut1200Time;
    document.getElementById('in1300Button').disabled = !isIn1300Time;
    document.getElementById('out1700Button').disabled = !isOut1700Time;
}

// Démarrer le chronomètre au chargement de la page
window.onload = function() {
    startTimer();
    setInterval(startTimer, 1000); // Actualiser le chronomètre chaque seconde
};


</script>



@endsection


