<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,CmsPage,Faq};
use App\Helpers\Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Mail;
use App\Mail\EmailVerification;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


           // $user=Auth::user();
           //      // dd($user);
           //          $user->assignRole('Admin');
        //return view('home');
    }

    public function getCmsPageData($slug){
       // print_r("hii"); die;
        if($slug=="FAQ" || $slug=="faq" || $slug=="Faq"){
            $page = Faq::where('status',1)->where('delete_status',0)->get();
            return view('faq',compact('page'));
          
        }else{
            $page=CmsPage::where('page_slug',$slug)->first();
            return view('cms-page',compact('page'));
        }

        
    }

    public function getotpmailtemplate()
    {
        return view('emails.OTP_verification');
    }

    public function getwelcomemailtemplate()
    {
        return view('emails.welcomeuser');
    }

    public function sendotpemail()
    {
        $email="sarthak.agarwal@emails.emizentech.com";
        $details=array('name'=>'Sarthak','otp'=>'1234');

        \Mail::to($email)->send(new \App\Mail\EmailVerification($details));
    }

    public function checksettime(Request $request)
    {
        date_default_timezone_set('America/Los_Angeles');
        $now = Carbon::now();
            
        dd($now);
    }

    
}
