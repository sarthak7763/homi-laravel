<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function Booking(Request $request)
    {
        return view('buyer::my-bookings');
       
    }
}