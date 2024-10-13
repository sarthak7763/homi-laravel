<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,Email,SellerSubscription,UserSubscription,Subscription,Notifications,UserNotification};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,Redirect,Auth,Toastr,DB;
use DataTables;

class NotificationController extends Controller{


    public function index(Request $request)
    {
        
        try{
               
            if($request->ajax()) { 
               
            $data = Notifications::get();
          
            return Datatables::of( $data)
                  ->addIndexColumn()
                    ->addColumn('title', function($row){
                        
                        return $row->title;
                    })
                    ->addColumn('message', function($row){
                      return $row->message;
                        
                   
                    
                    })->addColumn('notification image', function($row){

                        if(!empty($row->image))
                        {
                        $notification_image = '<img style="height:50px;width:auto;" src="'.url('/').'/images/'.$row->image.'">';
                        }
                        else
                        {
                            $notification_image = "";

                        }

                        return $notification_image ;

                     
                    })->addColumn('action', function($row){
                       
                     }) 
                     ->rawColumns(['title','message','notification image','action'])
                    ->make(true);
                }
            return view('admin::notification.index');
        }
        
        catch (\Exception $e) 
            {
              return redirect()->back()->with('error', $e->getMessage());
            }

    }
    
    
    public function add()
    {
        $Property_owners = User::where('user_type','3')->get()->toArray();
        $Property_buyers = User::where('user_type','2')->get()->toArray();
        return view('admin::notification.add',compact('Property_owners','Property_buyers'));
    }



    public function store(Request $request)
    {
         $data = $request->all();
        $validator = Validator::make($request->all(), [
                        'title' => 'required',
                        'vendor_id' => 'required',
                        'buyer_id' => 'required',
                        'notification_message' => 'required',
        ],
        [
            'title.required' => 'Title is required.',
            'vendor_id.required' => 'Seller name is required.',
            'buyer_id.required' => 'Buyer name is required.',
            'notification_message.required'=>'Message is required',
            
        ]);
            if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
            }
                $user_data = array_merge($data['vendor_id'],$data['buyer_id']);
                
                if($request->hasFile('notification_image')){      
                $imageName = time().'.'.$request->notification_image->extension();
                $image = $request->notification_image->move(public_path('images/'), $imageName);

                }
                else
                {
                    $imageName = "";    
                }

                    $notify = new Notifications;
                    $notify->title=$data['title'];
                    $notify->message=$data['notification_message'];
                    $notify->image= $imageName;
                    $notify->status= 1;
                    $notify->save();
                    
                    $notify_id = $notify->id;
                    foreach($user_data as $key=>$value){
                        $user_notify = new UserNotification;
                        $user_notify->user_id= $value;
                        $user_notify->notification_id= $notify_id;
                        $user_notify->notification_type= 1;
                        $user_notify->is_read =1;
                        $user_notify->save();
                    }
                    toastr()->success('Notifications Saved successfully!');
                    return redirect()->route('admin-notification-list')->with('success',"Notification saved successfully"); 
                }
            }
    