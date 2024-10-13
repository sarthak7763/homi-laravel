<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,Email};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,Redirect,Toastr;
use DataTables;

class EmailTemplateController extends Controller{


    public function add() 
    {
        try
        {
            return view('admin::EmailTemplate.add');
        }
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'something wrong');
        }
    }



    public function store(Request $request)
    {
       
        try
        {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'subject' => 'required',
                        'message' => 'required',
                        'email_type' => 'required',
            ],
            [
            'name.required' => 'Name is required.',
            'subject.required' => 'Subject is required.',
            'message.required'=>'Message is required',
            'email_type.required'=>'Email type is required',
            ]);
            if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
            }
                $email_template = new Email;
                $email_template->name=$data['name'];
                $email_template->subject=$data['subject'];
                $email_template->message=$data['message'];
                $email_template->email_type=$data['email_type'];
                $email_template->save();
                toastr()->success('Email templates saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           return redirect()->route('admin-email-template-list')->with('success',"Email template saved successfully"); 
            }
        catch(Exception $e){ 
        return redirect()->back()->with('error', $e->getmessage());     
       }
    }

    public function index(Request $request)
    {
        try{
            if($request->ajax()) {  
            
                $data = Email::all();
                return Datatables::of( $data)
                  ->addIndexColumn()
                    ->addColumn('name', function($row){
                        
                       return $row->name;
                    })
                    ->addColumn('subject', function($row){
                        return $row->subject;
                        
                     })->addColumn('message', function($row){
                        return $row->message;
                        
                     })->addColumn('email type', function($row){
                        return $row->email_type;
                     })
                     ->addColumn('action', function($row){
                        $route=route('admin-email-template-edit',$row->id);
                        $action='<a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
                        return $action;
                     }) 
                     ->rawColumns(['name','subject','message','email type','action'])
                    ->make(true);
                }
            return view('admin::EmailTemplate.index');
        }
        
        
           catch (\Exception $e) 
            {
              return redirect()->back()->with('error', $e->getMessage());
            }
    }








    public function edit($id){
        try
        {
            $templateInfo =Email::where('id','=',$id)->first();
            return view('admin::EmailTemplate.edit', compact('templateInfo'));
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error', 'something wrong');            
        }
    }

    public function update( Request $request,$id){
       try
        {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'subject' => 'required',
                        'message' => 'required',
                        'email_type' => 'required',
            ],
            [
            'name.required' => 'Name is required.',
            'subject.required' => 'Subject is required.',
            'message.required'=>'Message is required',
            'email_type.required'=>'Email type is required',
            ]);
            if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
            }

                $template_update=Email::find($id);
                if(is_null($template_update)){
                return redirect()->route('admin-email-template-list')->with('error',"Something went wrong6.");
                }
                else{  
                    $template_update->name=$data['name'];
                    $template_update->subject=$data['subject'];
                    $template_update->message=$data['message'];
                    $template_update->email_type=$data['email_type'];
                    $template_update->save();
                    toastr()->success('Email templates updated successfully!');
                    return redirect()->route('admin-email-template-list')->with('success',"Email template updated successfully"); 
                }
        }
        catch(Exception $e){ 
        return redirect()->back()->with('error', $e->getmessage());     
       }
    }
}