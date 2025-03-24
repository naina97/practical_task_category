@extends('layout/main')
@section('title', 'Country Add')

@section('page-style')
<style>
    .text-red{
        color:red;
    }
</style>

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
                    {{-- <li class="breadcrumb-item active" aria-current="page"> <a href="#">Add Booking</a></li> --}}
                </ol>
            </nav>
        </div>
        <div class="row clearfix">
            <div class="col-12 col-sm-12">
                <div class="tab-content">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Booking</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Customer Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="customer_name" type="text" value="{{old('customer_name')}}" >
                                            @error('customer_name')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Customer Email <span class="text-danger">*</span></label>
                                            <input class="form-control" name="customer_email" value="{{old('customer_name')}}" type="email" >
                                            @error('customer_email')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Booking Date <span class="text-danger">*</span></label>
                                            <input type="date"  class="form-control" name="booking_date" >
                                            @error('booking_date')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Booking Type <span class="text-danger">*</span></label>
                                            <select class="form-control" name="booking_type" id="booking_type" >
                                                <option value="Full Day">Full Day</option>
                                                <option value="Half Day">Half Day</option>
                                                <option value="Custom">Custom</option>
                                            </select>
                                            @error('booking_type')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12" id="booking_slot_div" style="display: none;">
                                        <div class="form-group">
                                            <label>Booking Slot</label>
                                            <select class="form-control" name="booking_slot" id="booking_slot">
                                                 <option value="">Select value</option>
                                                <option value="First Half">First Half</option>
                                                <option value="Second Half">Second Half</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12" id="booking_time_div" style="display: none;">
                                        <div class="form-group">
                                            <label>Booking From</label>
                                            <input class="form-control" type="time" name="booking_from"><br>
                                        </div>
                                        <div class="form-group">
                                            <label>Booking To</label>
                                            <input class="form-control" type="time" name="booking_to"><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right m-t-20">
                                        <button type="submit" class="btn btn-primary">SAVE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')

<script>
    $(document).ready(function() 
    {
        $('#booking_type').change(function()
        {
            var bookingType = $(this).val();

            if (bookingType === 'Half Day') {
                $('#booking_slot_div').show();
                $('#booking_time_div').hide();
                // Clear custom booking fields when switching to Half Day
                $('input[name="booking_from"], input[name="booking_to"]').val('');
            } 
            else if (bookingType === 'Custom') 
            {
                $('#booking_slot_div').hide();
                $('#booking_time_div').show();
                // Clear booking slot when switching to Custom
                $('#booking_slot').val('');
            } 
            else
            {
                $('#booking_slot_div').hide();
                $('#booking_time_div').hide();
                // Clear all conditional fields when switching to Full Day
                $('input[name="booking_from"], input[name="booking_to"]').val('');
                $('#booking_slot').val('');
            }
        });
    });
</script>
@endsection