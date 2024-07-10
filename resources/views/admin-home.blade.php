@extends('layouts.admin_layout')

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

                    <h3>welcome to the admin Dashboard</h3>

                    {{ __('You are logged in!') }}
                </div>
                <div class="card" style="background-image: url('/image/téléchargement (4).jpg');background-size: cover;background-position: center;height: 400px;width: 90%;margin: 2.5ch;">
            </div>
        </div>

    </div>
</div>
<footer class="bg-gray-800 text-white py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                    <div class="card-body">
                        <h5 class="card-title">             </h5>
                        <p class="card-text">                  </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection
