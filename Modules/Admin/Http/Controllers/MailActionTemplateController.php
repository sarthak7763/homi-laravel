<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller; 
use App\Models\{MailTemplate,MailAction};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,DataTables,Validator,Exception,Auth;

class MailActionTemplateController extends Controller{
    public function index() {

        $data = MailTemplate::get();

        return view('admin::mail_template.index',compact('data'));
    }
    public function add(){
        try{

            $mail_actions=MailAction::where('action_type',"mail")->get();
            return view('admin::mail_template.add',compact('mail_actions'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function save(Request $request){

        $data = $request->all();
        request()->validate([
            'action' => 'required|unique:mail_templates,action',
            'subject'=>'required',
            'name'=>'required',
            'body'=>'required'
           ]);
           $data = $request->all();
            try { 
               $template = new MailTemplate;
               $template->name=$data['name'];
               $template->subject=$data['subject'];
               $template->action=$data['action'];
               $template->body=$data['body'];
               $template->save();
                toastr()->success('Mail template saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
               return redirect()->route('admin-mail-template-list')->with('success','mail template added successfully');
            }catch (\Exception $e){
                 return redirect()->back()->with('error', 'something wrong');      
            }
    } 
    //DISPLAY EDIT DOCTOR FORM VIEW PAGE
    public function edit($id){
       try{
            $shortCodesArr=[];
            $mailTemplate =MailTemplate::where('id',$id)->first();
            $mail_actions=MailAction::where('action_type',"mail")->get();
            $shortCodes=MailAction::where('action',$mailTemplate->action)->first();
            if(!empty($shortCodes)){
                $shortCodesArr=explode(',', $shortCodes->options);
            }
            return view('admin::mail_template.edit', compact('mailTemplate','mail_actions','shortCodesArr'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }

    //DISPLAY EDIT DOCTOR FORM VIEW PAGE
    public function show($id){
       try{
            $mail =MailTemplate::where('id',$id)->first();
            return view('admin::mail_template.show', compact('mail'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    } 

    public function update(Request $request){
        $data = $request->all();

        request()->validate([
            
            'body' => 'required',
             'subject'=>'required',
            'name'=>'required',
           
           ]);
        try {
            $mailTemplateData = [ "name"=>$data['name'],
                            "subject"=>$data['subject'],
                          
                            "body"=>$data['body']
                           ]; 

            MailTemplate::where('id',$data['id'])->update($mailTemplateData);
             toastr()->success('Mail template information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           return redirect()->route('admin-mail-template-list')->with('success','Mail template info updated successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }
    }
  
    public function delete(Request $request){
       try{
            MailTemplate::where('id', $request->id)->delete();
            return redirect()->back()->with('success', 'Deleted');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }  
    }

    public function getMailParameters(Request $request){
        $action=$request->action;
        $str='<option value="">Choose Parameter</option>';
        //Ajax call for city where values are going to be fetch by state_id
        if(isset($action) && !empty($action)){
            $parametersRow= MailAction::where('action',$action)->where('action_type',"mail")->first();
            $options_array=explode(',', $parametersRow->options);
            foreach($options_array as $li){
                $str.="<option value=".$li.">".$li."</option>";
            }
        }
        echo $str;  
    }

    
  public function updateStatus(Request $request)
  {
    try
    {
      $user=MailTemplate::where('id', $request->id)->first();
      if($user->status == 1)
      {
        $data = [ "status"=>0];
        MailTemplate::where('id', $request->id)->update($data);
      }else
      {
        $data = [ "status"=>1];
        MailTemplate::where('id', $request->id)->update($data);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e)
    {  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

    public function mailActionList(){
         $data=MailAction::where('action_type',"mail")->get();
        return view('admin::mail_actions.index', compact('data'));
    }

    public function mailActionSave(Request $request){
        $data = $request->all();
        $row=MailAction::where('id',$data['id'])->first();
        if($data['action']=="edit"){
            
            if($row){
                 $validator = Validator::make($request->all(), [
                    'params' => 'required'
                ]);

                $data['action']="edit";
            }else{
                 $validator = Validator::make($request->all(), [
                    'params' => 'required',
                     'name' => 'required',
                ]);
                
                $data['action']="save";
            }
        }
        

       

    
        //try{
            switch ($data['action']) {
                case 'edit':
                  if($validator->passes()) {
                        $mailTemplateData = ["options"=>$data['params'] ]; 
                        MailAction::where('id',$data['id'])->update($mailTemplateData);
                    }else{
                         return response()->json(['error'=>$validator->errors()]);
                    }
                    break;
                case 'delete':
                  
                    MailTemplate::where('action',$row['action'])->delete();
                    MailAction::where('id',$data['id'])->delete();

                    break;
                case 'save':
                      if($validator->passes()) {
                   $template = new MailAction;
                   $template->action=$data['name'];
                   $template->options=$data['params'];
                   $template->action_type="mail";
                   $template->save();}
                   else{
                     return response()->json(['error'=>$validator->errors()]);
                   }
                break;
                default:
            }
                 return response()->json(["status" => "success"]);
        // }catch (\Exception $e){
        //     return response()->json(["status" => "error"]);
        // }
    }
}