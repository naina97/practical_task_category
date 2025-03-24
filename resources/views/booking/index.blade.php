@extends('layout/main')
@section('title', 'Booking')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />
@endsection

@section('content')
<div class="section-body mt-3">
    <div class="container-fluid">
       <!-- Breadcrumb and Button Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Booking List</li>
                </ol>
            </nav>

            <div class="d-flex gap-2">
                <a href="{{ route('booking.create') }}">
                    <button type="button" class="btn btn-danger">Add Booking</button>
                </a>
            </div>
        </div>
        @include('layout/toaster')
        <div class="row clearfix">
            <div class="col-12 col-sm-12">
                <div class="card">
                   <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Booking Date</th>
                                        <th>Booking Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking as $val)
                                        <tr>
                                            <td>{{ $val->id }}</td>
                                            <td>{{ $val->customer_name }}</td>
                                            <td>{{ $val->customer_email }}</td>
                                            <td>{{ $val->booking_date }}</td>
                                            <td>{{ $val->booking_type }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')

@endsection