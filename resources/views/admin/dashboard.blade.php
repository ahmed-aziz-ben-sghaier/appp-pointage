@extends('layouts.admin_layout')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Dashboard Statistics') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <h3>Welcome to the Admin Dashboard</h3>

                    <div class="total-users">
                        <span class="label">Total Users:</span>
                        <span class="count">{{ $totalUsers }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Presence Chart') }}</div>
                <div class="card-body">
                    <canvas id="presenceChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Delay Chart') }}</div>
                <div class="card-body">
                    <canvas id="delayChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('User Performance') }}</div>
                <div class="card-body">
                    <canvas id="performanceChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Users with Roles') }}</div>
                <div class="card-body">
                    <form action="{{ route('confirm_roles') }}" method="post">
                        @csrf
                        @foreach($allUsersWithRoles as $user)
                            <div class="user-with-roles">
                                <strong>{{ $user->name }}</strong> - Roles:
                                @foreach($user->roles as $role)
                                    <span class="badge badge-primary">{{ $role->name }}</span>
                                @endforeach
                                <br>
                                <label for="user_roles_{{ $user->id }}">Choose Role:</label>
                                <select name="user_roles[{{ $user->id }}]" id="user_roles_{{ $user->id }}">
                                    <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                                    <option value="super_manager" {{ $user->hasRole('super_manager') ? 'selected' : '' }}>Super Manager</option>
                                    <option value="manager" {{ $user->hasRole('manager') ? 'selected' : '' }}>Manager</option>
                                    <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        @endforeach
                        <button type="submit">Confirmer les rôles</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Users and Delays') }}</div>
                <div class="card-body">
                    <ul>
                        @foreach($allUsersWithRoles as $user)
                            <li>{{ $user->name }}: {{ $user->delayRequests->count() }} delays: {{ $user->listePAdditions->count() }} present</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>







        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Séance 1 (8:00 - 12:00)') }}</div>
                <div class="card-body">
                    <ul>
                        @foreach($seance1 as $user)
                            <li>{{ $user['user']->name }} - {{ $user['date'] }} - {{ $user['seance'] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Séance 2 (13:00 - 17:00)') }}</div>
                <div class="card-body">
                    <ul>
                        @foreach($seance2 as $user)
                            <li>{{ $user['user']->name }} - {{ $user['date'] }} - {{ $user['seance'] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>





       





        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d102134.13107256824!2d10.056956744700654!3d36.873800179561535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd348b432a6c4b%3A0xfcaf3fad4f127a29!2sCNAM%20Tunis%203!5e0!3m2!1sfr!2stn!4v1709299660649!5m2!1sfr!2stn" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>




    </div>
</div>


    <script>



        // Chart for Presence

        var presenceCtx = document.getElementById('presenceChart').getContext('2d');
        var presenceChart = new Chart(presenceCtx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Number of Users Present',
                    data: @json($counts),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: [{
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM DD'
                            }
                        }
                    }],
                    y: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });



        // Chart for Delays
        var delayCtx = document.getElementById('delayChart').getContext('2d');
        var delayChart = new Chart(delayCtx, {
            type: 'line',
            data: {
                labels: @json($delayDates),
                datasets: [{
                    label: 'Number of Delays',
                    data: @json($delayCounts),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: [{
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM DD'
                            }
                        }
                    }],
                    y: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Chart.js code for User Performance
    var performanceCtx = document.getElementById('performanceChart').getContext('2d');
    var userPerformanceData = @json($usersPerformance);

    var performanceChart = new Chart(performanceCtx, {
    type: 'bar',
    data: {
        labels: userPerformanceData.map(item => item.user),
        datasets: [
            {
                label: 'User Performance < 100',
                data: userPerformanceData.map(item => (item.performance < 100 ? item.performance : null)),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'User Performance = 100',
                data: userPerformanceData.map(item => (item.performance === 100 ? item.performance : null)),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});











    </script>

@endsection


