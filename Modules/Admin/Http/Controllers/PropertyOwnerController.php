<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Storage,File,Password};
use App\Helpers\Helper;
use Spatie\Permission\Models\{Role,Permission};
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Mail\Message;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;
use Illuminate\Validation\ValidationException;

class PropertyOwnerController extends Controller{
 
 
 public function index(Request $request) {
    try{ 
    
      if($request->ajax()) {   
        $data =  user::where('status','!=',2)->where('user_type','3')->latest();
        return Datatables::of($data)
          ->addIndexColumn()
            ->addColumn('name', function($row){
                $name = '<a href="'.route("admin-propertyOwner-details",$row->id).'">'.$row->name.'</a>';
                return $name;
            }) 
             ->addColumn('email', function($row){
                $email = $row->email;
                return $email;
            })
             ->addColumn('email_verified', function($row){
                $email_verified = $row->email_verified;
                if($email_verified==1){
                    $status='<span class="badge badge-success" style="cursor: pointer;" id="'.$row->id.'">Verified</span>';
                }elseif($email_verified==0){
                     $status='<span class="badge badge-danger" style="cursor: pointer;" id="'.$row->id.'">Not Verified</span>';
                }else {
                   $status='<span class="badge badge-danger" id="'.$row->id.'">NA</span>';
                }
                return $status;
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
                $route=route('admin-propertyOwner-edit',$row->id);
                $route_view=route('admin-propertyOwner-details',$row->id);
                $action='<a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a><a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';

                  // $action='<button class="btn btn-danger btn-sm badge_delete_status_change" title="Delete" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                
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
            
              if(!empty($request->get('start_date'))  ||  !empty($request->get('end_date'))) {
                $instance->where(function($w) use($request){
                   $start_date = $request->get('start_date');
                   $end_date = $request->get('end_date');
                   $start_date = date('Y-m-d', strtotime($start_date));
                   $end_date = date('Y-m-d', strtotime($end_date));

                   if($start_date!="" && $end_date!="")
                   {
                      $w->orwhereDate('created_at','>=',$start_date)
                      ->orwhereDate('created_at','<=',$end_date);
                   }
                   elseif($start_date=="" && $end_date!="")
                   {
                      $w->orwhereDate('created_at','<=',$end_date);
                   }
                   elseif($start_date!="" && $end_date=="")
                   {
                      $w->orwhereDate('created_at','>=',$start_date);
                   }
                   
                });
              } 
            })
            ->make(true);
          }  

      return view('admin::property_owner.index');  
    }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something went wrong');
    }
  }

  public function add() {
    try{
      return view('admin::property_owner.add');
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function save(Request $request){
    try {
      $data=$request->all();

	    $request->validate([
        'email' => 'required|email:rfc,dns',
	        'name'=>[
                  'required',
                  'regex:/^[\pL\s]+$/u',
                ],
          'mobile' => [
              'required',
               'numeric',
              'digits_between:10,12'
          ],
	    ],
      [
        'name.required' => 'Name field can’t be left blank.',
        'name.regex' => 'Please enter only alphabetic characters.',
        'email.required'=>'Email field can not be empty',
        'email.email'=>'Please enter a valid email address',
        'mobile.required'=>'Please enter a valid mobile number',
        'mobile.min'=>'Password can not be less than 10 character.',
        'mobile.max'=>'Password can not be more than 12 character',
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

        $fileNameToStore=uploadImage($request->file('profile_pic'),"images/owners/",'');
      }
      else{
      	$fileNameToStore="";
      }

      $substrword=substr($data['name'],0,4);
      $randomnumber=rand(11111,99999);
      $password = $substrword.'@'.$randomnumber;

      $checkemail=User::where('email',$data['email'])->where('user_type','3')->get()->first();
      if($checkemail)
      {
        return redirect()->back()->with('error', 'Email already exists.');
      }
      
      $hashedPassword = Hash::make($password);
      $email_verification_token=rand(1111,9999);

      $user = new User;
      $user->name=$data['name'];
      $user->email=$data['email'];
      $user->mobile=$data['mobile'];
      $user->password=$hashedPassword;
      $user->email_verified=1;
      $user->email_verification_token=$email_verification_token;
      $user->status=1;
      $user->profile_pic=$fileNameToStore;
      $user->user_type=3;
      $user->save();

      if($user){
        return redirect()->route('admin-propertyOwner-list')->with('success', 'Property Owner has been added !');
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
      return view('admin::property_owner.edit', compact('userInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', $e->getMessage());            
    }
  }
    
  public function update(Request $request){
    try {
      $data=$request->all();

      $request->validate([
        'id'=>'required',
        'email' => 'required|email:rfc,dns',
          'name'=>[
                  'required',
                  'regex:/^[\pL\s]+$/u',
                ],
          'mobile' => [ 
            'required',
            'numeric',
            'digits_between:10,12'
          ],
      ],
      [
        'id.required'=>'User not found.',
        'name.required' => 'Name field can’t be left blank.',
        'name.regex' => 'Please enter only alphabetic characters.',
        'email.required'=>'Email field can not be empty',
        'email.email'=>'Please enter a valid email address',
        'mobile.required'=>'Please enter a valid number',
        'mobile.min'=>'Password can not be less than 10 character.',
        'mobile.max'=>'Password can not be more than 12 character',
      ]);

      $user = User::find($data['id']);
          if(is_null($user)){
           return redirect('admin/user-list/')->with('error','Something went wrong.');
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

         $fileNameToStore=uploadImage($request->file('profile_pic'),"images/owners/",'');
      }
      else{
        $fileNameToStore="";
      }

      if($user->user_type==3)
      {
        if($user->email==$data['email'])
        {
            if($fileNameToStore!="")
            {
              $user->name = $data['name'];
              $user->mobile = $data['mobile'];
              $user->profile_pic=$fileNameToStore;

            }
            else{
              $user->name = $data['name'];
              $user->mobile = $data['mobile'];
            }
        }
        else{
          $checkemail=User::where('email',$data['email'])->where('user_type','3')->get()->first();
          if($checkemail)
          {
            return redirect()->back()->with('error', 'Email already exists.');
          }
          else{
            if($fileNameToStore!="")
            {
              $user->name = $data['name'];
              $user->email=$data['email'];
              $user->mobile = $data['mobile'];
              $user->profile_pic=$fileNameToStore;

            }
            else{
              $user->name = $data['name'];
              $user->email=$data['email'];
              $user->mobile = $data['mobile'];
            }
          }
        }


        try{
            $user->save();
            return redirect('/admin/propertyOwner-list/')->with('success', 'Property Owner has been updated !');       

          }catch(\Exception $e){
            return back()->with('error','wrong');
          }

      }
      else{
        return redirect('admin/propertyOwner-list/')->with('error','Something went wrong.');
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


  public function show($id) {
    try {
      $userInfo=User::where('id',$id)->first();
      return view('admin::property_owner.show',compact('userInfo'));  
    }
    catch(Exception $e) {
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

  public function updateUserEmailStatus(Request $request){
    try{
      $user=User::where('id', $request->id)->first();
      if($user->email_verified == 1){
        $data = [ "email_verified"=>0];
        User::where('id', $request->id)->update($data);
        $email_verified=1;
      }else if($user->email_verified == 0){
        $data = [ "email_verified"=>1];
        User::where('id', $request->id)->update($data);
        $email_verified=1;
      }else{
        $email_verified=0;
      }
        return response()->json(["success" => $email_verified]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
   
  public function deleteUser(Request $request){
    try{
      $data = ["status"=>2];
      $userInfo=User::where('id', $request->id)->first();  
      User::where('id', $request->id)->update($data);  
     
      toastr()->success('Buyer deleted successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function softDeletedUser(Request $request){
     try { 
      if($request->ajax()) {   
        $data =  User::role("Buyer")->where('status',2)->latest();
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
          
            ->addColumn('action__', function($row){
               
                $route_view=route('admin-user-details',$row->id);
               
                  $action='<button title="restore" class="btn btn-primary btn-sm badge_restore" data-id="'.$row->id.'"> <i class="fa fa-refresh"></i></button>';
                return $action;
            })  
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

}