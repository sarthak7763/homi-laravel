<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Storage,File,Password};
use App\Password_reset;
use App\Helpers\Helper;
use Spatie\Permission\Models\{Role,Permission};
//use Modules\Admin\Http\Requests\{UserRequest,EditUserValidateRequest};
use App\Models\{User,Country,MailAction,MailTemplate,FavProperty,IntrestedCity,Enquiry,Complaint,ComplaintEnquiryResponse,Bid,State,City};
use Illuminate\Support\Arr;
use Illuminate\Mail\Message;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;
use App\Jobs\{SendAddBidMailToBidders,SendAddBidSMSToBidders};
use Illuminate\Validation\ValidationException;

class OwnersController extends Controller{
 
 
 public function index(Request $request) {
    try{ 
      if($request->ajax()) {   
        $data =  User::where('status','!=',2)->where('user_type','3')->where('delete_status','!=',1)->latest();
        return Datatables::of($data)
          ->addIndexColumn()
            ->addColumn('name', function($row){
                $name = '<a href="'.route("admin-user-details",$row->id).'">'.$row->name.'</a>';
                return $name;
            }) 
             ->addColumn('email', function($row){
                $email = $row->email;
                return $email;
            })
            ->addColumn('status', function($row){
                $status = $row->status;
                if($status==1){
                    $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                }elseif($status==0){
                     $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                }else {
                   $status='<span class="badge badge-danger" id="'.$row->id.'">Inactive</span>';
                }
                return $status;
            }) 
            ->addColumn('created_at', function ($data) {
                $created_date=date('d M, Y g:i A', strtotime($data->created_at));
                return $created_date;   
            })
            ->addColumn('action__', function($row){
                $route=route('admin-owners-edit',$row->id);
                $route_view=route('admin-owners-details',$row->id);
                $action='<a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                	<button class="btn btn-danger btn-sm badge_delete_status_change" title="Delete" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                
                return $action;
            })  

            //->orderColumn('1', '2 $1')
            ->filter(function ($instance) use ($request) {
              if (!empty($request->get('search'))) {
                $instance->where(function($w) use($request){
                    $search = $request->get('search');
                    $w->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('name', 'LIKE', "%$search%");
                });
              }
           
              if($request->get('status') == '0' || $request->get('status') == '1') {
                $instance->where('status', $request->get('status'));
              }

              if($request->get('email_verified') == '0' || $request->get('email_verified') == '1') {
                $instance->where('email_verified', $request->get('email_verified'));
              }
            
              if(!empty($request->get('start_date'))  &&  !empty($request->get('end_date'))) {
                $instance->where(function($w) use($request){
                   $start_date = $request->get('start_date');
                   $end_date = $request->get('end_date');
                   $start_date = date('Y-m-d', strtotime($start_date));
                   $end_date = date('Y-m-d', strtotime($end_date));
                   $w->orwhereRaw("date(created_at) >= '" . $start_date . "' AND date(created_at) <= '" . $end_date . "'");
                });
              } 
            })
            ->make(true);
          }  

        
          return view('admin::owners.index');  
      }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function add() {
    try{
      return view('admin::user.add');
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function save(Request $request){
    try {
      $data=$request->all();

	    $request->validate([
	        'name' => 'required',
	        'email' => 'required|email'
	    ]);

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

        $fileNameToStore=uploadImage($request->file('profile_pic'),"public/storage/uploads/user_profile_pic/",'');
      }
      else{
      	$fileNameToStore="";
      }

      if($data['user_password']!="")
      {
      	$password=$data['user_password'];
      }
      else{
      	$password = Str::random(5)."#".Str::random(4)."@";
      }

      $checkemail=User::where('email',$data['email'])->where('user_type','2')->get()->first();
      if($checkemail)
      {
      return redirect()->back()->with('error', 'Email already exists.');
      }
      
      $hashedPassword = Hash::make($password);
      $email_verification_token=Str::random(12);

      $user = new User;
      $user->name=$data['name'];
      $user->email=$data['email'];
      $user->password=$hashedPassword;
      $user->email_verified=0;
      $user->email_verification_token=$email_verification_token;
      $user->status=1;
      $user->profile_pic=$fileNameToStore;
      $user->user_type=2;
      $user->save();

      if($user){
        return redirect()->route('admin-user-list')->with('success', 'User has been added !');
      }
      else{
      	return redirect()->back()->with('error', 'something wrong2');
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

  public function edit($id){
    try{
      $userInfo =User::where('id',$id)->first();
      return view('admin::user.edit', compact('userInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
    
  public function update(Request $request){
    $old_img="";
    $data = $request->all();
   // dd($data);
    try {
      $user=User::where('id',$data['id'])->first();
      //Upload User Image
      $old_img=$user->getRawOriginal('profile_pic');
    //dd($old_img);
      if($request->hasFile('profile_pic')){
        $data['profile_pic']=uploadImage($request->file('profile_pic'),"public/storage/uploads/user_profile_pic/",$old_img);
        Storage::disk('local')->delete('public/storage/uploads/user_profile_pic/'.$old_img);
      }
      else{
        $data['profile_pic'] = $user->getRawOriginal('profile_pic');
      }
     
      $userData = ["name"=>$data['name'],
                  "email"=>$data['email'],
                  "profile_pic"=>$data['profile_pic']
                ]; 

      User::where('id',$data['id'])->update($userData);
   
      toastr()->success('Buyer information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->route('admin-user-list')->with('success','Buyer information updated successfully');

    }catch (\Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function updateUserStatus(Request $request){
    try{
      $user=User::where('id', $request->id)->first();
      if($user->status == 1){
        $data = [ "status"=>0];
        User::where('id', $request->id)->update($data);
        $status=1;
      }else if($user->status == 0){
        $data = [ "status"=>1];
        User::where('id', $request->id)->update($data);
        $status=1;
      }else{
        $status=0;
      }
        return response()->json(["success" => $status]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
   
  public function deleteUser(Request $request){
    try{
      $data = ["delete_status"=>1,"status"=>0];
      $userInfo=User::where('id', $request->id)->first();  
      User::where('id', $request->id)->update($data);  
     
      //MAIL SEND FOR REGISTER BUYER TO ADMIN
      $mailParams=[$userInfo->name,$userInfo->email];
       dispatch(new SendAddBidMailToBidders(["buyer_deleted",$mailParams,$userInfo->email,$userInfo->name]));
      
      toastr()->success('Owners deleted successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

   public function restoreUser(Request $request){
    try{
      $data = ["delete_status"=>0,"status"=>1];
      $userInfo=User::where('id', $request->id)->first();  
      User::where('id', $request->id)->update($data); 
       //MAIL SEND FOR REGISTER BUYER TO ADMIN
      $mailParams=[$userInfo->name,$userInfo->email];
      dispatch(new SendAddBidMailToBidders(["buyer_restored",$mailParams,$userInfo->email,$userInfo->name]));
      
      toastr()->success('Buyer Restored Successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function destroyUserData(Request $request){
    try{
      $userInfo=User::where('id', $request->id)->first();  
       //MAIL SEND FOR REGISTER BUYER TO ADMIN
      $mailParams=[$userInfo->name,$userInfo->email];
      dispatch(new SendAddBidMailToBidders(["buyer_account_deleted",$mailParams,$userInfo->email,$userInfo->name]));
      
      User::where('id', $request->id)->delete();  
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function checkEmailExist(Request $request){
    try{
      $email=$request->email;
      if($email!=""){
        $userRows=User::where('email',$email)->where('user_type',2)->get();
        $count_mail=$userRows->count();
        if($count_mail==0){
           echo "true";
        }
        elseif(empty($userRows)){
         echo "true";
        }
        else{
          echo "false";
        }
      }
      else{
        echo "false";
        }
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  

  }

  public function show($id) {
    try {
      $userInfo=User::where('id',$id)->first();
      $intrestedCity=IntrestedCity::with('getIntrestedCity')->where('user_id',$id)->get();
   
      $bids=Bid::with(['BidderInfo','BidPropertyInfo'])->where([['bidder_id',$id],['delete_status',0]])->get();
      $bidsCount=$bids->count();

      $favProperty=FavProperty::with('getFavPropertyInfo')->where([['buyer_id',$id],['delete_status',0]])->get();
      $favPropertyCount=$favProperty->count();

      $complaint =  Enquiry::where('email',$userInfo->email)->with('getReasonType')->where('delete_status',0)->get();
      $complaintCount=$complaint->count();

      return view('admin::owners.show',compact('userInfo','bids','favProperty','bidsCount','favPropertyCount','complaint','complaintCount','intrestedCity'));  
    }
    catch(Exception $e) {
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function softDeletedUser(Request $request){
     try {
      $stateList = State::where('status',1)->get();  
      
      if($request->ajax()) {   
        $data =  User::role("Buyer")->with('getUserCountry','getUserState','getUserCity')->where('delete_status',1)->latest();
        return Datatables::of($data)
          ->addIndexColumn()
           
            ->addColumn('name', function($row){
                $name = $row->name;
                return $name;
            }) 
             ->addColumn('email', function($row){
                $email = $row->email;
                return $email;
            })
            ->addColumn('mobile_no', function($row){
                $mobile_no = getMobileFormat($row->mobile_no);

                return $mobile_no;
            }) 
          
            ->addColumn('status', function($row){
                $status = $row->status;
                if($status==1 && $row->delete_status==0){
                    $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                }elseif($status==0 && $row->delete_status==0){
                     $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                }else {
                   $status='<span class="badge badge-danger" id="'.$row->id.'">Inactive</span>';
                }
                return $status;
            }) 
          
            ->addColumn('action__', function($row){
               
                $route_view=route('admin-user-details',$row->id);
               
                  $action='<a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>  <button title="restore" class="btn btn-primary btn-sm badge_restore" data-id="'.$row->id.'"> <i class="fa fa-refresh"></i></button>
                <button title="delete" class="btn btn-danger btn-sm badge_delete_status_change" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                return $action;
            })  
            ->filter(function ($instance) use ($request) {
              if (!empty($request->get('search'))) {
                $instance->where(function($w) use($request){
                    $search = $request->get('search');
                    $w->orWhere('mobile_no', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('name', 'LIKE', "%$search%");
                });
              }
             
              if(!empty($request->get('country'))) {
                $instance->where('country', $request->get('country'));
              }

              if(!empty($request->get('state'))) {
                $instance->where('state', $request->get('state'));
              }

              if(!empty($request->get('city'))) {
                $instance->whereIn('city', $request->get('city'));
              }
           
              if($request->get('status') == '0' || $request->get('status') == '1') {
                $instance->where('status', $request->get('status'));
              }
              
              if(!empty($request->get('start_date'))  &&  !empty($request->get('end_date'))) {
                $instance->where(function($w) use($request){
                   $start_date = $request->get('start_date');
                   $end_date = $request->get('end_date');
                   $start_date = date('Y-m-d', strtotime($start_date));
                   $end_date = date('Y-m-d', strtotime($end_date));
                   $w->orwhereRaw("date(created_at) >= '" . $start_date . "' AND date(created_at) <= '" . $end_date . "'");
                });
              } 
            })
            
            ->make(true);
          }  

      return view('admin::user.soft_deleted_user_list',compact('stateList'));  
    }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

 public function checkEmailExistforExistingUser(Request $request){
    try {
      if(Auth::user()){ 
        $id =$request->id;
        $email=$request->email;
        if(!empty($id)) { 
            $rules = array('email' => 'required|email|unique:users,email,'. $id.',id');
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { 
            echo "false";
        } else {
            echo "true";
        }
      }
    }
    catch(Exception $e) {
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }


}