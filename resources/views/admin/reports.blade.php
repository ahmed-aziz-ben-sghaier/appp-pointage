@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reports') }}</div>

                    <div class="card-body">
                        <p>Welcome to the reports page.</p>
                        

                        @if ($reportsData->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Content</th>
                                    <th>Date&Time</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportsData as $report)
                                    <tr>
                                        <td>{{ $report->user_id }}</td>
                                        <td>{{ $report->content }}</td>
                                        <td>{{ $report->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No reports data available.</p>
                    @endif



                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if(isset($userId))
                            <p>User ID: {{ $userId }}</p>
                        @endif
                        {{-- Search bar --}}
                        <form action="{{ route('admin.reports.search') }}" method="GET">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search by User ID" name="user_id">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>

                        <form action="{{ route('admin.reports.search') }}" method="GET">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" placeholder="Search by Date" name="search_date">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>



                        {{-- Print button --}}
                        <div class="mb-3">
                            <button class="btn btn-primary" onclick="window.print()">Print</button>
                        </div>


                        @if ($listePData->count() > 0)
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
                                    @foreach ($listePData as $item)
                                        <tr>
                                            <td>{{ $item->user_id }}</td>
                                            <td>{{ $item->action }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->time }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No data available.</p>
                        @endif





                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
