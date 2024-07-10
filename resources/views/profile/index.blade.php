@extends('layouts.app')
@section('content')
<div class="container">
</div class="row justify-content-center">
<div class="col-md-10">
    <div class="card">
        <section style="background-color: #eee;">
            <div class="container py-2">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">user profile</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                @if(isset($userprofile) && $userprofile->picture )
                                <img src="{{ asset('/image/cnam4.jpg') . '/' . $userprofile->picture }}"alt="avatar" class="rounded-circle img-fluid" style="width: 150px">


                            @else
                                <p>No profile picture available</p>
                            @endif
                            @if($userinfo)
                                <h5 class="my-3">{{ $userinfo->name }}</h5>
                                <p class="text-muted mb-1">{{ $userinfo->email }}</p>
                            @else
                                <p>No user information available</p>
                            @endif
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">mobile number</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$userinfo->mobile}}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Address</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$userinfo->address}}</p>
                                    </div>
                                </div>
                                <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Status</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{$userinfo->status}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Company name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{$userinfo->company}}</p>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Position</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{$userinfo->position}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row ">
                                <div class="col-sm-3">
                                    <a href="#" class="btn btn-sm btn-success " data-toggle="modal" data-target="#proInfoModal">
                                        <i class="fa fa-edit"></i>edit profile info
                                    </a>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="proInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-dark">
            <div class="modal-header bg-light">
                <h2 class="card-title">update profile</h2>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="avatar-form"enctype="multipart/form-data"action="{{route('updateinfo')}}" method="POST">
                        @csrf
                        <input type="hidden" name="userid" value="{{ optional($userprofile)->user_id }}">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">mobile number</p>
                            </div>
                            <div class="col-sm-8 pull-right">
                                <input type="text" class="form-control" name="updmobile" id="updmobile" value="{{$userinfo->mobile}}">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Address</p>
                            </div>
                            <div class="col-sm-8 pull-right">
                                <input type="text" class="form-control" name="updaddress" id="updaddress" value="{{ optional($userprofile)->address }}">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Status</p>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select" name="status" id="status">
                                    <option value="single" {{ (optional($userinfo)->status === 'single') ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ (optional($userinfo)->status === 'married') ? 'selected' : '' }}>Married</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Company name</p>
                            </div>
                            <div class="col-sm-8 pull-right">
                                <select class="form-select" name="upcompany" id="updcompany">
                                    <option value="RH" {{ ($userinfo->company === 'RH') ? 'selected' : '' }}>RH</option>
                                    <option value="PS" {{ ($userinfo->company === 'PS') ? 'selected' : '' }}>PS</option>
                                </select>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Position</p>
                            </div>
                            <div class="col-sm-8 pull-right">
                                <input type="text" class="form-control" name="updposition" id="updposition" value="{{$userinfo->position}}">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success">save Profile Info update</button>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
