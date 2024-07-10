@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="dashboard-title">Welcome Super Manager!</h2>
        <div class="row">
            @if ($errors->any())
         <div class="alert alert-danger">
             <ul>
                 @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                 @endforeach
             </ul>
         </div>
          @endif
          <div class="mt-4">
            <h4 class="dashboard-title">Rédiger un Compte Rendu</h4>
            <form action="{{ route('submit.report') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="reportContent" class="form-label dashboard-title">Contenu du Rapport</label>
                    <textarea class="form-control" id="reportContent" name="content" rows="6" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary dashboard-title">Envoyer le Rapport</button>
            </form>
          </div>

          <div class="mt-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#presenceModal">Mark Presence</button>
         </div>


         <div class="mt-4 dashboard-title">
            <h4>Current Date:</h4>
            <div id="currentDate"></div>
            <h4>Current Time:</h4>
            <div id="clock"></div>
         </div>

          {{-- Search bar --}}
      <form action="{{ route('super-manager.dashboard.search') }}" method="GET" >
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search by User ID" name="user_id">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary search-button" type="submit">Search</button>
            </div>
        </div>
    </form>
    <form action="{{ route('super-manager.dashboard.search') }}" method="GET">
        @csrf
        <div class="input-group mb-3">
            <input type="date" class="form-control" placeholder="Search by Date" name="search_date">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary search-button" type="submit">Search</button>
            </div>
        </div>
    </form>

    {{-- Print button --}}
    <div class="mb-3">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
    </div>

         <div class="card-body">
            <div class="card-body">
               <!-- Reports section -->
               <div class="mt-4">
                <h4 class="dashboard-title">Reports List</h4>
                @if ($reports->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Action</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->user_id }}</td>
                                    <td>{{ $report->action }}</td>
                                    <td>{{ $report->status }}</td>
                                    <td>{{ $report->time }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No reports available.</p>
                @endif
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


       hours = (hours < 10) ? "0" + hours : hours;
       minutes = (minutes < 10) ? "0" + minutes : minutes;

       return hours + ":" + minutes;
   }


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


           document.getElementById('currentDate').innerText = dateString;
           document.getElementById('clock').innerText = timeString;
       }


       setInterval(updateDateTime, 1000);


       $('#presenceModal').on('shown.bs.modal', function (e) {
           updateDateTime();
       });



</script>
@endsection
