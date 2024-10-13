<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Storage,File,Password};
use App\Password_reset;
use App\Helpers\Helper;
use Spatie\Permission\Models\{Role,Permission};
use App\Models\{Subscription};
use Illuminate\Support\Arr;
use Illuminate\Mail\Message;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;
use App\Jobs\{SendAddBidMailToBidders,SendAddBidSMSToBidders};
use Illuminate\Validation\ValidationException;

class SubscriptionController extends Controller{
 
 
 public function index(Request $request) {
    try{ 
      if($request->ajax()) {   
        $data =  Subscription::where('delete_status','!=',1)->latest();
        return Datatables::of($data)
          ->addIndexColumn()
            ->addColumn('name', function($row){
                $name = '<a href="'.route("admin-user-details",$row->id).'">'.$row->name.'</a>';
                return $name;
            }) 
             ->addColumn('plan_duration', function($row){
                $plan_duration = $row->plan_duration;
                return $plan_duration;
            })
            ->addColumn('plan_price', function($row){
              $plan_price = $row->plan_price;
              return $plan_price;
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
                $route=route('admin-subscription-edit',$row->id);
                $route_view=route('admin-subscription-details',$row->id);
                $action='<a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                	<button class="btn btn-danger btn-sm badge_delete_status_change" title="Delete" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                
                return $action;
            })  

            //->orderColumn('1', '2 $1')
            ->filter(function ($instance) use ($request) {
              if (!empty($request->get('search'))) {
                $instance->where(function($w) use($request){
                    $search = $request->get('search');
                    $w->orWhere('name', 'LIKE', "%$search%");
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

      return view('admin::subscription.index');  
    }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function add() {
    try{
      
      return view('admin::subscription.add');
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function save(Request $request){
    try {
      $data=$request->all();
      $validator = Validator::make($data, [
          'name'            => 'required',
          'title'            => 'required',
          'plan_duration'    => 'required',
          'plan_price'       => 'required',
          'product_listing'  => 'required',
          'plan_description' => 'required',
          'status'           => 'required'
      ]);

      if ($validator->fails()) {
          return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
      } else {
           
        $user                   = new Subscription;
        $user->name             = $data['name'];
        $user->plan_title            = $data['title'];
        $user->plan_duration    = $data['plan_duration'];
        $user->plan_price       = $data['plan_price'];
        $user->product_listing  = $data['product_listing'];
        $user->plan_description = $data['plan_description'];
        $user->status           = $data['status'] ? $data['status']: '1'; 
        $user->save();

        if($user){
          return redirect()->route('admin-subscription-list')->with('success', 'Subscription plan has been added !');
        }
        else{
          return redirect()->back()->with('error', 'something wrong2');
        }
      }
    }
    catch (\Exception $e){
      dd($e);
      return back()->with('error','Something went wrong.');
	  }
  }

  public function edit($id){
    try{
      $userInfo =Subscription::where('id',$id)->first();
      return view('admin::subscription.edit', compact('userInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
    
  public function update(Request $request){
    try {
      $data=$request->all();
        $validator = Validator::make($data, [
          'name'            => 'required',
          'title'            => 'required',
          'plan_duration'    => 'required',
          'plan_price'       => 'required',
          'product_listing'  => 'required',
          'plan_description' => 'required',
          'status'           => 'required'
      ]);

      if ($validator->fails()) {
          return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
      } else {
          $subcData = [
            "name"=>$data['name'],
            "plan_title" => $data['title'],
            "plan_duration"=>$data['plan_duration'],
            "plan_price"=>$data['plan_price'],
            "product_listing"=>$data['product_listing'],
            "plan_description"=>$data['plan_description'],
            "status"=>$data['status'] ?$data['status']: 1,
          ]; 

          Subscription::where('id',$data['id'])->update($subcData);
   
          toastr()->success('Subscription plan updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
        return redirect()->route('admin-subscription-list')->with('success','Subscription plan updated successfully');
      }  

    }catch (\Exception $e){
      dd($e);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function updateUserStatus(Request $request){
    try{
      $user=Subscription::where('id', $request->id)->first();
      if($user->status == 1){
        $data = [ "status"=>0];
        Subscription::where('id', $request->id)->update($data);
        $status=1;
      }else if($user->status == 0){
        $data = [ "status"=>1];
        Subscription::where('id', $request->id)->update($data);
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
   
  public function deleteSub(Request $request){
    try{
      $data = ["delete_status"=>1,"status"=>0];
      $userInfo=Subscription::where('id', $request->id)->first();  
      Subscription::where('id', $request->id)->update($data);  
      toastr()->success('Subscription deleted successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

   public function restoreUser(Request $request){
    try{
      $data = ["delete_status"=>0,"status"=>1];
      $userInfo=Subscription::where('id', $request->id)->first();  
      Subscription::where('id', $request->id)->update($data); 
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
      $userInfo=Subscription::where('id', $request->id)->first();  
       //MAIL SEND FOR REGISTER BUYER TO ADMIN
      $mailParams=[$userInfo->name,$userInfo->email];
      dispatch(new SendAddBidMailToBidders(["buyer_account_deleted",$mailParams,$userInfo->email,$userInfo->name]));
      
      Subscription::where('id', $request->id)->delete();  
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

 
  public function show($id) {
    try {
      $plan=Subscription::where('id',$id)->first();
      
      return view('admin::subscription.show',compact('plan'));  
    }
    catch(Exception $e) {
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function softDeletedUser(Request $request){
     try {
      $stateList = State::where('status',1)->get();  
      
      if($request->ajax()) {   
        $data =  Subscription::role("Buyer")->with('getUserCountry','getUserState','getUserCity')->where('delete_status',1)->latest();
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

}