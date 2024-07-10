@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Absence Requests') }}</div>

                    <div class="card-body">
                        {{-- Your absence requests view content goes here --}}
                        <p>Welcome to the absence requests page. Please see the list of workers who arrived late.</p>


                        @if(count($delayRequests) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Delay Date</th>
                                    <th>Delay Time</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($delayRequests as $delayRequest)
                                    <tr>
                                        <td>{{ $delayRequest->user->name }}</td>
                                        <td>{{ $delayRequest->delay_date }}</td>
                                        <td>{{ $delayRequest->delay_time }}</td>
                                        <td>{{ $delayRequest->reason }}</td>

                                        <td>
                                            <!-- Formulaire d'ajout -->
                                            <form action="{{ route('admin.add.user.to.liste_p', $delayRequest->user->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Ajouter</button>
                                            </form>

                                            <!-- Bouton "Supprimer" -->
                                            <form action="{{ route('admin.remove.delay.request', $delayRequest->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No delay requests found.</p>
                    @endif





                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
