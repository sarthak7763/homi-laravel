<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Storage,File,Password};
use App\Password_reset;
use App\Helpers\Helper;
use Spatie\Permission\Models\{Role,Permission};
use App\Models\{User,Bid,Complaint,Enquiry,Property,PropertyOffer};
use Mail,Hash,Auth,Validator,Exception,DataTables,Notification,DB,Str,Session;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller{
  public function index(){
    try{ 
      $complaints ="";
      // $notifications = auth()->user()->unreadNotifications;
      $total_users = User::role('Buyer')->count();     
      $active_property = Property::where('escrow_status',"Active")->count();
      $pending_property = Property::where('escrow_status',"Pending")->count();
      $total_property = Property::count();
      $sold_property = Property::where('escrow_status',"Sold")->count();
      $property_offer = PropertyOffer::where('sale_status',1)->count();
      $user = User::where('id', auth()->user()->id)->first();
      $bids = Bid::where('delete_status',0)->count();
      //$complaints = Complaint::where('complaint_status',"New")->count();
      $enquiry = Enquiry::count();

      $sales_record = DB::select("SELECT MONTHNAME(CONCAT('2018-', m.month, '-01')) AS month,
        COALESCE(total, 0) AS total
        FROM (SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
        UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
        UNION SELECT 11 UNION SELECT 12) m
        LEFT JOIN (SELECT MONTH(A.updated_at) AS month,sum(A.bid_price - B.seller_price) AS total
        FROM bids as A left join properties as B on A.property_id=B.id WHERE year(A.updated_at) = ".date('Y')."  AND A.bid_status = 'Closed' and B.escrow_status='Sold' and A.delete_status=0 and A.status=1 GROUP BY month Order By month DESC) dp ON dp.month = m.month
        ");

      $sales_record = json_decode(json_encode($sales_record),TRUE);      
      $sales_data=[];
      foreach($sales_record as $key=>$row) {
        if (array_key_exists($row['month'],$sales_data)){
          $sales_data[$row['month']] =  $row['total']+$sales_data[$row['month']];
        }else{
          $sales_data[$row['month']]  = $row['total'];
        }
      }

      foreach ($sales_data as $key => $value) {
        $sales_data['total'][] = $value;
        $sales_data['month'][] = $key;
      }  
      $sales_data=json_encode($sales_data);
      $inactive_user = User::role('Buyer')->where('status',0)->count();   
      $active_user = User::role('Buyer')->where('status',1)->count();   
            
      return view('admin::dashboard',compact('total_users','pending_property','total_property','bids','user','complaints','inactive_user','active_user','enquiry','sales_data','property_offer','sold_property','active_property'));            
    }
    catch (\Exception $e) {  
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100",]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function login(Request $request) {
    try{   
      if(@Auth::user() && @Auth::user()->roles[0]->id == 1 || @Auth::user()->roles[0]->id == 3){
        return redirect()->route('admin-profile');
      } 
      else {
        Auth::guard('web')->logout();
        $request->session()->flush();
        $request->session()->regenerate(); 
        return view('admin::auth.login');
      }
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function admin_login(Request $request) {
    $inputVal = $request->all();
    $rules = array(
      'email'    => 'required|email', 
      'password' => 'required|min:3' 
    );
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withInput()->withErrors("User Name & Password are incorrect.");
    } 
    else {
      try{
          $userdata = array(
              'email'     => $inputVal['email'],
              'password'  => $inputVal['password']
          );
          if(auth()->attempt($userdata) && Auth::user()->roles[0]->id == 1 || auth()->attempt($userdata) && Auth::user()->roles[0]->id == 3){   
              unset($inputVal['_token']);
              toastr()->success('Admin Logged In Successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
              return redirect()->route('admin-dashboard');
          }else {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            //toastr()->success('Admin Logged In Successfully!');
            return redirect()->route('admin-login')->withErrors('invalid Username or Password');  
          }
        }
      catch (\Exception $e) { 
        return redirect()->back()->with('error', 'something wrong');
      }
    }
  }

  public function admin_logout(Request $request) {
    try{
      Auth::guard('web')->logout();
      $request->session()->flush();
      $request->session()->regenerate();
      return redirect()->route('admin-login');
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function profile() {
    try{
      $adminInfo=User::where('id',auth()->user()->id)->first();
      return view('admin::profile',compact('adminInfo'));
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function profile_edit() {
    try{
      $adminInfo=User::where('id',auth()->user()->id)->first();
      return view('admin::edit-profile',compact('adminInfo'));
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function profileUpdate(Request $request){
    try {
      $data=$request->all();

      $request->validate([
        'email' => 'required|email:rfc,dns',
          'name'=>[
                  'required',
                ],
          'mobile' => [
              'nullable',
              'numeric',
              'digits_between:10,12'
          ],
      ],
      [
        'name.required' => 'Name field can’t be left blank.',
        'email.required'=>'Email field can not be empty',
        'email.email'=>'Please enter a valid email address',
      ]);

      $userid=auth()->user()->id;

      $admin = User::find($userid);
          if(is_null($admin)){
           return redirect('admin/profile/')->with('error','Something went wrong.');
        }

        $fileNameToStore="";
      //Upload Image
      if($request->hasFile('profile_pic')){

        try{
          $request->validate([
              'profile_pic' => 'required|mimes:jpeg,png,jpg'
            ]);
        }
        catch(\Exception $e){
                    if($e instanceof ValidationException){
                        $listmessage=[];
                        foreach($e->errors() as $key=>$list)
                        {
                            $listmessage[$key]=$list[0];
                        }

                        if(count($listmessage) > 0)
                        {
                            return back()->with('valid_error',$listmessage);
                        }
                        else{
                            return back()->with('error','Something went wrong.');
                        }
                        
                    }
                    else{
                        return back()->with('error','Something went wrong.');
                    }      
               }

        $fileNameToStore=uploadImage($request->file('profile_pic'),"images/user/",'');
      }
      else{
        $fileNameToStore="";
      }

      if($admin->user_type==1)
      {
        if($admin->email==$data['email'])
        {
            if($fileNameToStore!="")
            {
              $admin->name = $data['name'];
              $admin->mobile = $data['mobile'];
              $admin->profile_pic=$fileNameToStore;

            }
            else{
              $admin->name = $data['name'];
              $admin->mobile = $data['mobile'];
            }
        }
        else{
          $checkemail=User::where('email',$data['email'])->where('user_type','1')->get()->first();
          if($checkemail)
          {
            return redirect()->back()->with('error', 'Email already exists.');
          }
          else{
            if($fileNameToStore!="")
            {
              $admin->name = $data['name'];
              $admin->email=$data['email'];
              $admin->mobile = $data['mobile'];
              $admin->profile_pic=$fileNameToStore;

            }
            else{
              $admin->name = $data['name'];
              $admin->email=$data['email'];
              $admin->mobile = $data['mobile'];
            }
          }
        }


        try{
            $admin->save();
            return redirect('/admin/profile/')->with('success', 'Profile has been updated !');       

          }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
          }

      }
      else{
        return redirect('admin/profile/')->with('error','Something went wrong.');
      }

    }
    catch (\Exception $e){
      if($e instanceof ValidationException){
          $listmessage=[];
          foreach($e->errors() as $key=>$list)
          {
              $listmessage[$key]=$list[0];
          }

          if(count($listmessage) > 0)
          {
              return back()->with('valid_error',$listmessage);
          }
          else{
              return back()->with('error','Something went wrong.');
          }
          
      }
      else{
          return back()->with('error','Something went wrong.');
      }
    }
  }

  public function resetAdminPassword(Request $request){
    try {
    $data = $request->all();
    $request->validate([
        'password' => 'required|same:confirm_password|min:6',
        'confirm_password' => 'required',
      ],
      [
        'password.required'=>'Password field can’t be left blank.',
        'confirm_password.required' => 'Confirm password field can’t be left blank.',
        'password.same'=>'Password and confirm password must be same.',
        'password.min'=>'Password must contain minnimujm 6 characters',
      ]);

    $userid=auth()->user()->id;

    $admin = User::find($userid);
          if(is_null($admin)){
           return redirect('admin/profile/')->with('error','Something went wrong.');
        }

      $password=Hash::make($data['password']);
      $admin->password = $password;

      try{
          $admin->save();
          return redirect('/admin/profile/')->with('success', 'Profile has been updated !');       

        }catch(\Exception $e){
          return back()->with('error',$e->getMessage());
        }

    }
    catch (\Exception $e){
      if($e instanceof ValidationException){
          $listmessage=[];
          foreach($e->errors() as $key=>$list)
          {
              $listmessage[$key]=$list[0];
          }

          if(count($listmessage) > 0)
          {
              return back()->with('valid_error',$listmessage);
          }
          else{
              return back()->with('error','Something went wrong.');
          }
          
      }
      else{
          return back()->with('error','Something went wrong.');
      }
    }

  }

  //admin-revenue-graph-post
  public function graphRevenueDataPost(Request $request){
    try{
      $daterangepicker = $request->daterangepicker;
      $daterangepicker1 = $request->daterangepicker1;
      $sales_data = [];
      $year = date("Y");
      $words = explode('-', $daterangepicker);
      $words1 = explode('-',$daterangepicker1);
     
      if($request->graph_filters=="yearly"){
        $from = explode('-', $daterangepicker);
        $to = explode('-', $daterangepicker1);
        $start_year = $from['0'];
        $end_year = $to['0'];

        $first_date = '01-01-'.$start_year;
        $second_date = '30-12-'.$end_year;


        $newQuery = "SELECT $start_year AS year";
        $searchYear = $start_year+1;
        for($i=$searchYear; $i <= $end_year; $i++){
          $newQuery = $newQuery.' '."UNION SELECT $i"; 
        }
        
        $sales_record = DB::select("SELECT YEAR(CONCAT(y.year,'-1','-01')) AS year, 
        COALESCE(total, 0) AS total
        FROM ($newQuery) y
        LEFT JOIN (SELECT YEAR(A.updated_at) AS year, (A.bid_price - B.seller_price) AS total
        FROM bids as A left join properties as B on A.property_id=B.id where A.bid_status='Closed' and B.escrow_status='Sold' and A.delete_status=0 and A.status=1) dp ON dp.year = y.year
        ");
      
        $sales_record = json_decode(json_encode($sales_record),TRUE);      
         
          $sales_data=[];
          foreach($sales_record as $key=>$row) {
    
            if (array_key_exists($row['year'],$sales_data)){
                $sales_data[$row['year']] =  $row['total']+$sales_data[$row['year']];
            }else{
               $sales_data[$row['year']]  = $row['total'];
            }
          }

          foreach ($sales_data as $key => $value) {
            $sales_data['total'][] = $value;
            $sales_data['month'][] = $key;
          }  

        $sales_data['label'][] = 'Years';
      }
      elseif($request->graph_filters=="monthly"){
        $words = explode('-', $daterangepicker);
        $words1 = explode('-', $daterangepicker1);
        $start_date = $words['0'];
        $end_date = $words['1'];
        $start_date1 = $words1['0'];
        $end_date1 = $words1['1'];
        // print_r($start_date1); die;
        $first_date = '01-'.$start_date."-".$end_date;
        $second_date = '30-'.$start_date1."-".$end_date1;

        $startDate = date('d-m-Y', strtotime($first_date));
        $endDate = date('d-m-Y', strtotime($second_date));

        $sales_record = DB::select("select MONTHNAME(A.updated_at) as month,(A.bid_price - B.seller_price) as total from `bids` as A left join properties as B on A.property_id=B.id where A.bid_status='Closed' and B.escrow_status='Sold' and A.delete_status=0 and A.status=1 and A.updated_at between '$startDate' and '$endDate'");

        $newQuery = "SELECT $start_date AS month";
        $searchMonth = $start_date+1;
        for ($i=$searchMonth; $i <= $start_date1; $i++) {
          $newQuery = $newQuery.' '."UNION SELECT $i";    
        }

        $sales_record = DB::select("SELECT MONTHNAME(CONCAT('2018-', m.month, '-01')) AS month,COALESCE(total, 0) AS total FROM ($newQuery) m
                      LEFT JOIN (SELECT MONTH(A.updated_at) AS month, (A.bid_price - B.seller_price) AS total
                                FROM bids as A left join properties as B on A.property_id=B.id WHERE year(A.updated_at) = $year and A.bid_status='Closed' and A.delete_status=0 and A.status=1) dp ON dp.month = m.month");

        $sales_record = json_decode(json_encode($sales_record),TRUE);      
        $sales_data=[];
        foreach($sales_record as $key=>$row) {
          if (array_key_exists($row['month'],$sales_data)){
              $sales_data[$row['month']] =  $row['total']+$sales_data[$row['month']];
          }else{
             $sales_data[$row['month']]  = $row['total'];
          }
        }

        foreach ($sales_data as $key => $value) {
          $sales_data['total'][] = $value;
          $sales_data['month'][] = $key;
        }  
        
        $sales_data['label'][] = 'Months';   
      }
      elseif($request->graph_filters=="weekly"){
        $initial_date = $daterangepicker;
        $start_date =  date('Y-m-d', strtotime($initial_date));
        $end_date =  date('Y-m-d', strtotime($start_date. ' + 6 days'));
        $dates = $this->displayDates($start_date,$end_date);
        $sales_record = DB::select("SELECT date(A.updated_at) as label,(A.bid_price - B.seller_price) as total FROM `bids` as A left join properties as B on A.property_id=B.id WHERE A.bid_status='Closed' and B.escrow_status='Sold' and Date(A.updated_at) between DATE('$start_date') and DATE('$end_date') group by A.id");
        $result = [];
        $sales_record = json_decode(json_encode($sales_record),TRUE);
        foreach($sales_record as $key => $value){
          if (array_key_exists($value['label'],$result)){
            $result[$value['label']] = $result[$value['label']] + $value['total'];  
          }else{
            $result[$value['label']] = $value['total'];
          } 
        }

        $newResult = [];
        foreach($dates as $value){
          $data = [];
          if (array_key_exists($value,$result)){
            $data = [
              'label' => $value,
              'total' => $result[$value],
            ];
          }else{
            $data = [
              'label' => $value,
              'total' => 0
            ];
          } 
          $newResult[]  =$data; 
        }
        $sales_record = $newResult;
        foreach($sales_record as $row) {
              $sales_data['month'][] = $row['label'];
              $sales_data['total'][] = (int) $row['total'];
        }
        $sales_data['label'][] = 'Week Days';
      }  
      //$sales_data=json_encode($sales_data);
      return response()->json(["success" => "1","result"=>$sales_data]);
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  function displayDates($date1, $date2, $format = 'Y-m-d' ) {
    $dates = array();
    $current = strtotime($date1);
    $date2 = strtotime($date2);
    $stepVal = '+1 day';
    while( $current <= $date2 ) {
       $dates[] = date($format, $current);
       $current = strtotime($stepVal, $current);
    }
    return $dates;
  }

  public function adminForgotPassword(){
    try{
      return view('admin::auth.passwords.email');
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function adminForgotPasswordValidate($token){
    try{
      $user = User::where('forgot_token', $token)->where('is_forgot_verified', 0)->first();
      if ($user) {
        $email = $user->email;
        return view('admin::auth.passwords.reset', compact('email','token'));
      }
      toastr()->error('Error! Password reset link is expired','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"3000",]);
      return redirect()->route('admin-forget-password')->with('error', 'Password reset link is expired');
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', 'something wrong');
    }
  }


  public function adminResetPassword(Request $request){
    try{
      request()->validate([$request], [
          'email' => 'required|email',
      ]);

      $user = User::where('email', $request->email)->where('user_type',1)->first();
      if (!$user) {
          return back()->with('error', 'Failed! email is not registered.');
      }

      $token = Str::random(60);
      //SAVE USER DETAILS TABLE DATA
      $user['forgot_token'] = $token;
      $user['is_forgot_verified']=0;
      $user->save();
        
        $tokenLink="<a href=".route('admin-reset-password-link',$token).">Reset your password</a>";
     
        $email =$user->email;
        $mailParams=["name"=>$user->name, "email"=>$user->email,"token"=>$tokenLink];
        $mailResponse= Mail::send('emails.admin_reset_password_mail',["messageBody"=>$mailParams], function($message) use($email) 
        {
                $message->to($email);
                $message->subject('Homi: Admin Password Reset');
        });    
       
      toastr()->success('Password reset link has been sent to your email','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"3000",]);
      return back()->with('success', 'Password reset link has been sent to your email'); 
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', $e->getMessage());
    }         
  }

  public function adminUpdatePassword(Request $request) {
    
    request()->validate([$request],[
          'email' => 'required',
          'password' => 'required|min:6',
          'confirm_password' => 'required|same:password'
      ]);
    try{ 
      $user = User::where('email', $request->email)->where('forgot_token',$request->token)->first();
      if ($user) {
          $user['is_forgot_verified'] = 1;
          $user['forgot_token'] = '';
          $user['password'] = Hash::make($request->password);
          $user->save();

          return redirect()->route('admin-login')->withSuccess('Password has been changed');
      }else{
         return redirect()->route('admin-forgt-password')->withErrors('Error: Token Mismatch or Missing Email');
      }
    }
    catch (\Exception $e) { 
      toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->back()->with('error', $e->getMessage());
    }
  }
}