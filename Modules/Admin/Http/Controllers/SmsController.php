<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\SmsTemplate;
use App\Models\MailAction;
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash, DataTables, Validator, Exception, Auth;

class SmsController extends Controller {

    public function index() {

        $data = SmsTemplate::get();

        return view('admin::sms_template.index',compact('data'));
    }

    public function add(){
        try{
            $sms_actions=MailAction::where('action_type',"sms")->get();
            return view('admin::sms_template.add',compact('sms_actions'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }

    public function save(Request $request){

        $data = $request->all();
        request()->validate([
            'action' => 'required|unique:sms_templates,action',
            'name'=>'required',
            'body'=>'required'
           ]);
           $data = $request->all();
            try { 
               $template = new SmsTemplate;
               $template->name=$data['name'];
               $template->action=$data['action'];
               $template->body=$data['body'];
               $template->save();
                toastr()->success('SMS template saved successfully!','',["progressBar"=> false, "showDuration"=>"1000", "hideDuration"=> "1000", "timeOut"=>"100"]);
               return redirect()->route('admin-sms-template-list')->with('success','sms template added successfully');
            }catch (\Exception $e){
                 return redirect()->back()->with('error', 'something wrong');      
            }
    } 

    //DISPLAY EDIT DOCTOR FORM VIEW PAGE
    public function edit($id){
       try{
            $shortCodesArr=[];
            $smsTemplate =SmsTemplate::where('id',$id)->first();
            $sms_actions=MailAction::where('action_type',"sms")->get();
            $shortCodes=MailAction::where('action',$smsTemplate->action)->first();
            if(!empty($shortCodes)){
                $shortCodesArr=explode(',', $shortCodes->options);
            }
            return view('admin::sms_template.edit', compact('smsTemplate','sms_actions','shortCodesArr'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }

    //DISPLAY EDIT DOCTOR FORM VIEW PAGE
    public function show($id){
       try{
            $sms =SmsTemplate::where('id',$id)->first();
            return view('admin::sms_template.show', compact('sms'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    } 

    public function update(Request $request){
        $data = $request->all();

        request()->validate([
            
            'body' => 'required',
            'name'=>'required',
           
           ]);
        try {
            $smsTemplateData = [ "name"=>$data['name'],
                                    "body"=>$data['body']
                               ]; 

            SmsTemplate::where('id',$data['id'])->update($smsTemplateData);
             toastr()->success('SMS template information updated successfully!','',["progressBar"=> false, "showDuration"=>"1000", "hideDuration"=> "1000", "timeOut"=>"100"]);
           return redirect()->route('admin-sms-template-list')->with('success','SMS template info updated successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }
    }
  
    public function delete(Request $request){
       try{
            SmsTemplate::where('id', $request->id)->delete();
            return redirect()->back()->with('success', 'Deleted');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }  
    }


  public function updateStatus(Request $request)
  {
    try
    {
      $user=SmsTemplate::where('id', $request->id)->first();
      if($user->status == 1)
      {
        $data = [ "status"=>0];
        SmsTemplate::where('id', $request->id)->update($data);
      }else
      {
        $data = [ "status"=>1];
        SmsTemplate::where('id', $request->id)->update($data);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e)
    {  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

    public function getSMSParameters(Request $request){
        $action=$request->action;
        $sms_type=$request->sms_type;
        $str='<option value="">Choose Parameter</option>';
        //Ajax call for city where values are going to be fetch by state_id
        if(isset($action) && !empty($action)){
            $parametersRow= MailAction::where('action',$action)->where('action_type',$sms_type)->first();
            $options_array=explode(',', $parametersRow->options);
            foreach($options_array as $li){
                $str.="<option value=".$li.">".$li."</option>";
            }
        }
        echo $str;  
    } 

     public function getActionBySmsType(Request $request){
    try
    {
      $sms_type=$request->sms_type;

      $str='<option value="">Choose Action</option>';
      //Ajax call for city where values are going to be fetch by state_id
      if(isset($sms_type) && !empty($sms_type)){
        $stateList= MailAction::where('action_type',$sms_type)->get();
        foreach($stateList as $li){
          $str.="<option value=".$li->action.">".$li->action."</option>";
        }
      }
      echo $str;  
    }
    catch(Exception $e)
    {
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
 
}