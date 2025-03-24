<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $booking = Booking::all();
        return view('booking.index',compact('booking'));
    }

    public function create()
    {
        return view('booking.add_booking');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule    = [];
        $validationMessage = [];

        $validationRule = [
            'customer_name'  => 'required',
            'customer_email' => 'required|email',
            'booking_date'   => 'required',
            'booking_type'   => 'required',
            'booking_slot'   => 'nullable|required_if:booking_type,Half Day',
            'booking_from'   => 'nullable|required_if:booking_type,Custom',
            'booking_to'     => 'nullable|required_if:booking_type,Custom',
        ];
        
        $validationMessage = [
            'customer_name.required'  => 'Customer Name is required.',
            'customer_email.required' => 'Customer Email is required.',
            'customer_email.email'    => 'Enter a valid email address.',
            'booking_date.required'   => 'Booking Date is required.',
            'booking_type.required'   => 'Booking Type is required.',
            'booking_slot.required_if' => 'Booking Slot is required when Booking Type is Half Day.',
            'booking_from.required_if' => 'Booking From time is required when Booking Type is Custom.',
            'booking_to.required_if'   => 'Booking To time is required when Booking Type is Custom.',
        ];
        
        $validatedData     = $request->validate($validationRule, $validationMessage);
        try {
            $exists = Booking::where('booking_date', $request->booking_date)
                ->where(function ($query) use ($request) {
                    if ($request->booking_type == 'Full Day') {
                        $query->where('booking_type', '!=', 'Custom');
                    } elseif ($request->booking_type == 'Half Day') {
                        $query->where('booking_type', 'Full Day')
                            ->orWhere('booking_slot', $request->booking_slot);
                    } elseif ($request->booking_type == 'Custom') {
                        $query->where('booking_type', 'Full Day')
                            ->orWhere('booking_slot', 'First Half')
                            ->orWhereBetween('booking_from', [$request->booking_from, $request->booking_to]);
                    }
                })->exists();
        
            if ($exists) {
                $status = 'error';
                $message_text = 'Booking already exists for this date and slot.';
                return redirect()->route('booking.index')->with($status, $message_text);

            } else {
                $booking = new Booking();
        
                $booking->customer_name = $request->customer_name;
                $booking->customer_email = $request->customer_email;
                $booking->booking_date = $request->booking_date;
                $booking->booking_type = $request->booking_type;
                $booking->booking_slot = $request->booking_slot ?? null;
                $booking->booking_from = $request->booking_from ?? null;
                $booking->booking_to = $request->booking_to ?? null;
        
                if ($booking->save()) {
                    $status = 'success';
                    $message_text = 'Booking successful';
                } else {
                    $status = 'error';
                    $message_text = 'Booking failed';
                }
            }
        } catch (Throwable $e) {
            $status = 'error';
            $message_text = 'Booking failed: ' . $e->getMessage();
        }
        
        return redirect()->route('booking.index')->with($status, $message_text);
    }
}
