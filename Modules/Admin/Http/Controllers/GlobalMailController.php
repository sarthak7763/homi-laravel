<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request,Response};
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,MailAction,Property,SmsTemplate};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,Auth,Mail,Str,Toastr;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Jobs\{GlobalMail};

class GlobalMailController extends Controller {
  public function index(Request $request) {
    $userList=User::role('Buyer')->where('delete_status',0)->where('email_verified',1)->get();
    return view('admin::global_mail_sms.send_global_mail',compact('userList'));       
  }

  public function sendMailByAdmin(Request $request){
    try {
      $data=$request->all();
      $validatedData = $request->validate([
        'message' => 'required',
        'user_id.*' => 'required'
      ]);

      if(Auth::user()){ 
        $userInfo=User::whereIn('id',$data['user_id'])->get();
        foreach($userInfo as $li){ 
          $mail_data=["username"=>$li->name,
                      "subject"=>$data['subject'],
                      "mail_body"=>$data['message'],
                      "email"=>$li->email
          ]; 

          dispatch(new GlobalMail($mail_data));
        }
        
        toastr()->success('Mail sent successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
              
        return redirect()->route('admin-global-mail-send')->with('success','Mail sent successfully!');
      }else{
        return redirect()->route('admin-login');
      }
    }catch (Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function ajaxGetMailTemplateByid(Request $request){
    try {
      $mail_template_id=$request->mail_template_id;
      $mail_template_id= SmsTemplate::where('id',$mail_template_id)->first();
      if(!empty($mail_template_id)){
        return response()->json(["status"=>"success","result"=>$mail_template_id]);
      }else{
        return response()->json(["status"=>"error","result"=>""]);
      }        
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
}