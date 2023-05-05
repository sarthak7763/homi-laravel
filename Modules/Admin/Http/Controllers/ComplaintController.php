<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Http\Requests\AdminRequest\{AddComplaintRequest,EditComplaintRequest};
use App\Models\{Complaint,Enquiry,ComplaintEnquiryResponse,User,MailAction,MailTemplate};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Illuminate\Mail\Message;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Notification,Str;
use App\Notifications\{AdminComplaintStatusNotification,AdminComplaintResponseNotification};
use App\Jobs\{SendAddBidMailToBidders,SendAddBidSMSToBidders,SendEnquiryMail};


class ComplaintController extends Controller
{
  public function index(Request $request) {
 
    try
    {
      if($request->ajax()) 
      {   
        $data =  Complaint::with('getComplaintUserInfo')->with('getReasonType')->orderBy('id', 'DESC')->get();

        return Datatables::of($data)
          ->addIndexColumn()
          // ->addColumn('id', function($row){
          //   //  $id = $row->count();
          //     //return $id;
          // })

          ->addColumn('add_by', function($row){
            $add_by='<a href="'.route('admin-user-details',$row->getComplaintUserInfo->id).'">'.@$row->getComplaintUserInfo->name.'</a>';
           
            return $add_by;
          }) 

        
          // ->addColumn('attachment', function($row){
          //     $attachment = '';
          //     $attachment = '<button  type="button" class="waves-effect openModal" data-toggle="modal"  data-target="#Modal-overflow" data-id="'.$row->id.'"><img src="'.$row->attachment.'" height="50" width="50" id="thumbnil"></button>';
              
          //   return $attachment;
          // })
          // ->addColumn('title', function($row){
          //   $title = '<div>'.substr($row->title,0,10).'...'.'</div>';
          //   return $title;
          // }) 
          // ->addColumn('description', function($row){
          //     $description = $row->description;
          //     return $description;
          // }) 
          ->addColumn('complaint_no', function($row){
              $complaint_no =  @$row->complaint_no ? $row->complaint_no : "--"; 
              return $complaint_no;
          }) 

            ->addColumn('reason_type', function($row){
            return @$row->getReasonType->name ? $row->getReasonType->name : "--"; 
           
          }) 
          
          ->addColumn('created_at', function($row){
            $created_at = @$row->created_at ? date('M d, Y H:i A',strtotime($row->created_at)) :"";
            return $created_at;
          }) 

          ->addColumn('complaint_status', function($row){
             
            $complaint_status='<button type="button" class="btn btn-primary btn-sm dropdown-toggle complaint_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->complaint_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item complaint_status_btn" data-id="'.$row->id.'" data-status="New"><i class="fa fa-volume-control-phone"></i>New</button><button class="dropdown-item complaint_status_btn" data-id="'.$row->id.'" data-status="In Progress"><i class="fa fa-spinner"></i>In Progress</button><button class="dropdown-item complaint_status_btn" data-id="'.$row->id.'" data-status="Closed"><i class="fa fa-eye-slash"></i>Closed</button></div>';
             
            return $complaint_status;
          }) 
          ->addColumn('status', function($row){
              $status = $row->status;
              if($status==1){
                  $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
              }else{
                   $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
              }
              return $status;
          }) 
          // ->addColumn('delete_status', function($row){
          //     $delete_status = $row->delete_status;
          //     if($delete_status==1){
          //         $delete_status='<span class="badge badge-danger" style="cursor: pointer;">Deleted</span>';
          //     }else{
          //          $delete_status='<span class="badge badge-info badge_delete_status_change" id="'.$row->id.'" style="cursor: pointer;">Not Deleted</span>';
          //     }
          //     return $delete_status;
          // }) 
          ->addColumn('action__', function($row){
            
               
               $route_view=route('admin-complaint-detail',$row->id);
                        $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
            // $action='<button  type="button" class="waves-effect openModal btn btn-primary btn-sm" data-toggle="modal"  data-target="#Modal-overflow" data-id="'.$row->id.'">Write Solution</button>';

              return $action;
          })                    
          ->make(true);
      }
    }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something wrong');
    }  
    return view('admin::complaint.index');  
  }

    public function add() {
      try
      {
        $userList=User::role("Buyer")->get();
        return view('admin::complaint.add',compact('userList'));
      }
      catch (\Exception $e) 
      {
        return redirect()->back()->with('error', 'something wrong');
      }
    }

    public function save(AddComplaintRequest $request) 
    {
      // try 
      // {

        $data=$request->all();
        $fileNameToStore="";
        //Upload Image
        if($request->hasFile('attachment'))
        {
          $fileNameToStore=uploadImage($request->file('attachment'),"public/uploads/complaint",'');
        }
       /*complaint_status 1. New 
                          2. In Progress
                          6. Closed */
        $complaint_no= rand(0000,9999);
        $complaint = new Complaint;
        $complaint->title=$data['title'];
        $complaint->complaint_no=$complaint_no;
        $complaint->add_by=$data['add_by'];
        $complaint->description=$data['description'];
        $complaint->attachment=$fileNameToStore;
        $complaint->complaint_status="New";
        

        $complaint->save();
       
        return redirect()->route('admin-user-complaint-list')->with('success',"Complaint added successfully");
      // }
      // catch (\Exception $e)
      // {
      //   return redirect()->back()->with('error', 'something wrong');
      // }
    }
  
    public function edit($id)
    {
      try
      {
        $complaintStatus=["New","In Progress","Approved","Reopened","Awaiting Approval","Closed"];
        $userList=User::role("Buyer")->get();
        $complaintInfo =Complaint::where('id',$id)->first();
        
        return view('admin::complaint.edit', compact('complaintInfo','userList','complaintStatus'));
      }
      catch(Exception $e)
      {
        return redirect()->back()->with('error', 'something wrong');            
      }
    }
    
    public function update(EditComplaintRequest $request)
    {
      $old_img="";
      $data = $request->all();
       // try 
       // {
          $complaint=Complaint::where('id',$data['id'])->first();
         //Upload User Image
          $old_img=$complaint->getRawOriginal('attachment');
        
          if($request->hasFile('attachment')){
            $data['attachment']=uploadImage($request->file('attachment'),"public/uploads/complaint",$old_img);
            Storage::disk('local')->delete('public/uploads/complaint/'.$old_img);
          }
          else
          {
            $data['attachment'] = $complaint->getRawOriginal('attachment');
          }
            
          $complaintData =["title"=>$data['title'],
                            "description"=>$data['description'],
                            "attachment"=>$data['attachment'],
                            "add_by"=>$data['add_by'],
                            "complaint_status"=>$data['complaint_status']
                          ]; 

        Complaint::where('id',$data['id'])->update($complaintData);
              
        return redirect()->route('admin-user-complaint-list')->with('success','Complaint updated successfully');
      // }catch (\Exception $e){
      //   return redirect()->back()->with('error', 'something wrong');
      // }
    }


    public function updateStatus(Request $request)
    {
      try
      {
        $complaint=Complaint::where('id', $request->id)->first();
        if($complaint->status == 1)
        {
          $data = [ "status"=>0];
          Complaint::where('id', $request->id)->update($data);
        }else
        {
          $data = [ "status"=>1];
          Complaint::where('id', $request->id)->update($data);
        }

        return response()->json(["success" => "1"]);
      }
      catch(Exception $e)
      {  
        return redirect()->back()->with('error', 'something wrong');     
      }  
    }
   

    public function deleteComplaint(Request $request)
    {
      try
      {
        $data = ["delete_status"=>1];
        Complaint::where('id', $request->id)->update($data);  
        return response()->json(["success" => "1"]);
      }
      catch(Exception $e)
      {
        return redirect()->back()->with('error', 'something wrong');     
      }  
    }

    public function show(Request $request)
    {
      $complaintInfo=Complaint::where('id',$request->id)->first();
      return response()->json([
        'data' => $complaintInfo,
        'state' => 'success']);
     
    }

      public function showDetail($id)
    {
      $complaintInfo=Complaint::with('getComplaintUserInfo')->where('id',$id)->first();
      $complaintResponse=ComplaintEnquiryResponse::where('type_id',$id)->where('response_type',"complaint")->first();
     return view('admin::complaint.show',compact('complaintInfo','complaintResponse'));  
    }

    public function updateComplaintStatus(Request $request)
    {
      
      try
      {
          $complaintInfo=Complaint::where('id',$request->id)->first();
          $buyerInfo=User::where('id',$complaintInfo->add_by)->first();
        
        if($request->status=="In Progress"){

           $update=Complaint::where('id', $request->id)->update(["complaint_status"=>$request->status]);
           $buyerInfo->notify(new AdminComplaintStatusNotification(Auth::user(),$complaintInfo));



        }else if($request->status=="Closed"){

           $update=Complaint::where('id', $request->id)->update(["complaint_status"=>$request->status]);
           $buyerInfo->notify(new AdminComplaintStatusNotification(Auth::user(),$complaintInfo));

        }
         
          if($update){
             $complaint=Complaint::where('id', $request->id)->first();
             return response()->json(["status" => "1","result"=>$complaint]);
          }else{
             return response()->json(["status" => "0"]);
          }
         
      }
      catch(Exception $e)
      {  
        return redirect()->back()->with('error', 'something wrong');     
      }  
    }


  public function responseComplaint(Request $request) {
    try {
      request()->validate(['description' => 'required'],['description.required' => 'Please fill the details before send']);
      $data=$request->all();
      $email=$data['email']; 
      if($data['response_type']=="complaint"){
        $complaintData=Complaint::with('getComplaintUserInfo')->where('id', $data['id'])->first(); 
        $buyerInfo=User::where('id', $complaintData->add_by)->first(); 
            
        $row=ComplaintEnquiryResponse::where('type_id',$data['id'])->where('response_type',$data['response_type'])->first();
  
        if(!empty($row)){
          $update=["description"=>$data['description']];
          ComplaintEnquiryResponse::where('id', $row->id)->update($update);
          $buyerInfo->notify(new AdminComplaintResponseNotification(Auth::user(),$row));
          $mailParams=[$complaintData->title,
                      $complaintData->complaint_no,
                      $complaintData->attachment,
                      $data['description'],
                      $complaintData->getComplaintUserInfo->email,
                      $complaintData->getComplaintUserInfo->name];

          $mailData=["action_name"=>"admin_reply_to_buyer_for_complaint","short_codes_variable"=>$mailParams,"email"=>$complaintData->getComplaintUserInfo->email,"username"=>$complaintData->getComplaintUserInfo->name];
          //COMPLAINT_NAME,COMPLAINT_NO,ATTACHMENT,RESPONSE_BY_ADMIN,EMAIL,NAME_OF_COMPLAINTER
          dispatch(new SendEnquiryMail($mailData));
        }else{
          $complaint = new ComplaintEnquiryResponse;
          $complaint->type_id=$data['id'];
          $complaint->response_type=$data['response_type'];
          $complaint->description=$data['description'];
          $complaint->save();
          //$buyerInfo->notify(new AdminComplaintResponseNotification(Auth::user(),$complaint));
          /*complaint_status 1. New  2. In Progress 6. Closed */
          Complaint::where('id', $data['id'])->update(['complaint_status'=>"Closed"]);
          $mailParams=[$complaintData->title,
                      $complaintData->complaint_no,
                      $complaintData->attachment,
                      $data['description'],
                      $complaintData->getComplaintUserInfo->email,
                      $complaintData->getComplaintUserInfo->name ];

         $mailData=["action_name"=>"admin_reply_to_buyer_for_complaint","short_codes_variable"=>$mailParams,"email"=>$complaintData->getComplaintUserInfo->email,"username"=>$complaintData->getComplaintUserInfo->name];
          dispatch(new SendEnquiryMail($mailData));
        }
        return redirect()->route('admin-complaint-detail',$data['id'])->with('success',"Response Send Successfully");
      }
      else
      {

     
        $enquiryData=Enquiry::where('id', $data['id'])->first(); 
        $buyerInfo=User::where('email', $enquiryData->email)->first(); 
        $row=ComplaintEnquiryResponse::where('type_id',$data['id'])->where('response_type',$data['response_type'])->first();
        if(!empty($row)){
          $update=["description"=>$data['description']];
          ComplaintEnquiryResponse::where('id', $row->id)->update($update);
          $buyerInfo->notify(new AdminComplaintResponseNotification(Auth::user(),$row));
          $mailParams=[$enquiryData->description,
                        $data['description'],
                        $enquiryData->email,
                        $enquiryData->name,
                        getMobileFormat($enquiryData->mobile_no)];


          $mailData=["action_name"=>"admin_reply_to_buyer_for_enquiry",
                    "short_codes_variable"=>$mailParams,
                    "email"=>$enquiryData->email,
                    "username"=>$enquiryData->name
          ];

          dispatch(new SendEnquiryMail($mailData));
        }
        else{

          $complaint = new ComplaintEnquiryResponse;
          $complaint->type_id=$data['id'];
          $complaint->response_type=$data['response_type'];
          $complaint->description=$data['description'];
          $complaint->save();
          $buyerInfo->notify(new AdminComplaintResponseNotification(Auth::user(),$complaint));

          $mailParams=[$enquiryData->description,
                        $data['description'],
                        $enquiryData->email,
                        $enquiryData->name,
                        getMobileFormat($enquiryData->mobile_no)];

          //ENQUIRY_MESSAGE,ENQUIRY_RESPONSE_BY_ADMIN,EMAIL,USERNAME,MOBILE_NO
          $mailData=["action_name"=>"admin_reply_to_buyer_for_enquiry","short_codes_variable"=>$mailParams,"email"=>$enquiryData->email,"username"=>$enquiryData->name];
          dispatch(new SendEnquiryMail($mailData));
          //dispatch(new SendAddBidMailToBidders(["admin_reply_to_buyer_for_enquiry",$mailParams,$enquiryData->email]));
          //$mailResponse=$this->sendDynamicMail("admin_reply_to_buyer_for_enquiry",$mailParams,$enquiryData->email); 
        }

        
        return redirect()->route('admin-enquiry-detail',$data['id'])->with('success',"Response Send Successfully");
      } 
    }
    catch (\Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  }
  
}