<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request,Response};
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,MailAction,Property,SmsTemplate};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,Auth,Mail,Str;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Jobs\{GlobalSms};
use Toastr;
class GlobalSmsController extends Controller {
  public function index(Request $request) {
    $templateList=[];
    $actionList=MailAction::where('action_type',"admin_sms")->get();
    foreach($actionList as $li){

      $templateList[]=SmsTemplate::where('action',$li->action)->first();
    }

    $propertyList= Property::get();
    $userList=User::role('Buyer')->where('status',1)->where('delete_status',0)->get();
    return view('admin::global_mail_sms.send_global_sms',compact('templateList','userList','propertyList'));     
  }

  public function sendSMSByAdmin(Request $request){
    try {
      $data=$request->all();
      $validatedData = $request->validate([
        'message' => 'required',
        'user_id.*' => 'required'
      ]);

      if(Auth::user()){ 
        $userInfo=User::whereIn('id',@$data['user_id'])->get();
        foreach($userInfo as $li){
          $message="Hey ".$li->name." ".$data['message'];
          $sms_data=["sms_text"=>$message,"receiver_number"=>$li->country_std_code.$li->mobile_no]; 
          dispatch(new GlobalSms($sms_data));
        }

        toastr()->success('SMS sent successfully!','',["progressBar"=> false, "showDuration"=>"1000", "hideDuration"=> "1000", "timeOut"=>"100"]);
        return redirect()->route('admin-global-sms-send')->with('success','SMS sent successfully!');
      }else{
        return redirect()->route('admin-login');
      }
    } catch (Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }
  public function ajaxGetSmsTemplateByid(Request $request){
    try {
      $sms_template_id=$request->sms_template_id;
      $sms_template= SmsTemplate::where('id',$sms_template_id)->first();
      if(!empty($sms_template)){
        return response()->json(["status"=>"success","result"=>$sms_template]);
      }else{
        return response()->json(["status"=>"error","result"=>""]);
      }
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
}