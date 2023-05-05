<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Http\Requests\AdminRequest\{AddComplaintRequest,EditComplaintRequest};
use App\Models\{Enquiry,ComplaintEnquiryResponse,MailAction,MailTemplate,User};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail;

class EnquiryController extends Controller
{

  public function index(Request $request) {
    try{
      if($request->ajax()) {   
        $data =  Enquiry::with('getReasonType')->orderBy('id', 'DESC')->get();
        return Datatables::of($data)
          ->addColumn('name', function($row){
            return $row->name;
          })
          ->addColumn('email', function($row){
            return $row->email;
          }) 
          ->addColumn('mobile_no', function($row){
            return getMobileFormat($row->mobile_no);
          }) 
          ->addColumn('reason_type', function($row){
            return $row->getReasonType->name;
          }) 
          ->addColumn('created_at', function($row){
            $created_at = date('M d, Y H:i A',strtotime($row->created_at));
            return $created_at;
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
           
          ->addColumn('action__', function($row){
            $route_view=route('admin-enquiry-detail',$row->id);
            $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
              return $action;
          })                    
          ->make(true);
      }
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }  
    return view('admin::enquiry.index');  
  }

  public function updateStatus(Request $request){
    try{
      $complaint=Enquiry::where('id', $request->id)->first();
      if($complaint->status == 1){
        $data = [ "status"=>0];
        Enquiry::where('id', $request->id)->update($data);
      }else{
        $data = [ "status"=>1];
        Enquiry::where('id', $request->id)->update($data);
      }
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
   
  public function deleteEnquiry(Request $request){
    try{
      $data = ["delete_status"=>1];
      Enquiry::where('id', $request->id)->update($data);  
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function show(Request $request){
    $enquiryInfo=Enquiry::where('id',$request->id)->first();
    return response()->json([
      'data' => $enquiryInfo,
      'state' => 'success']);
  }

  public function showDetail($id){
    $enquiryResponse=ComplaintEnquiryResponse::where('type_id',$id)->where('response_type',"enquiry")->first();
    $enquiryInfo=Enquiry::with('getReasonType')->where('id',$id)->first();
    return view('admin::enquiry.show',compact('enquiryInfo','enquiryResponse'));  
  }
}