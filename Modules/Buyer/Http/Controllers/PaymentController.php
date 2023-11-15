<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('buyer::payment');
       
    }

    

}
