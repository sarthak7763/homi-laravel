<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Route, Auth,Hash,Validator,Mail,DB;
use App\Models\{User,EmailTemplate};

class EmailTemplateController extends Controller {

    public function __construct(EmailTemplate $EmailTemplate) {
        $this->EmailTemplate = $EmailTemplate;
    }
   
    public function index() {
        try {
            $emails = EmailTemplate::orderBy('id', 'DESC')->get();
            return view('admin::emailtemplates.index', compact('emails'));
        } catch (Exception $ex) {
          
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }
 
    public function create() {
        try {
            return view('admin::emailtemplates.create');
        } catch (Exception $ex) {
          
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }
  
    public function store(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
                    'title' => 'required|string|max:255|unique:email_templates',
                    'subject' => 'required',
                    'content' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
           try {
                $data = $request->all();
                unset($data['_token']);


                EmailTemplate::create($data);

                
                return redirect('admin/emails')->withSuccess("Email template add successfully!");
            } catch (Exception $ex) {
               
                return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
            }
       }
    }
 
    public function show($slug) {
        try {
            $email = [];
            if ($slug != null) {
                $email = EmailTemplate::where('slug', $slug)->first();
            }
            return view('admin::emailtemplates.show', compact('email'));
        } catch (\Exception $e) {
           
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }
  
    public function edit($slug) {
        try {
            $email = [];
            if ($email != '') {
                $email = EmailTemplate::where('slug', $slug)->first();
            }
            return view('admin::emailtemplates.edit', compact('email'));
        } catch (\Exception $e) {
           
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function update(Request $request) {
        $email = EmailTemplate::where('slug', $request->slug)->first();
        $validator = Validator::make($request->all(), [
                    'title' => 'required|string|max:100|unique:email_templates,title,' . $email->id,
                    'subject' => 'required',
                    'content' => 'required',
                        ], [
                    'title.required' => 'Please enter email template title',
                    'subject.required' => 'Please enter email template subject',
                    'content.required' => 'Please enter content',
        ]);

        $data = $request->all();
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            try {
                unset($data['_token']);

                EmailTemplate::where('slug', $request->slug)->update($data);

               
                return redirect('admin/emails')->withSuccess("Email template has been updated successfully.");
            } catch (Exception $ex) {
                
                return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
            }
        }
    }

    public function destroy($slug) {
        try {
            $this->EmailTemplate->where('slug', $slug)->delete();
          
            return redirect('admin/emailtemplates')->withSuccess("Email template remove successfully.");
        } catch (\Exception $e) {
         
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function emailStatus($slug) {
        $explode = explode('_', $slug);
        if (trim($explode[1]) == 0 || trim($explode[1]) == 1) {
            try {
                $this->EmailTemplate->where('slug', $explode[0])->update(['status' => $explode[1]]);
               
                return redirect('admin/emails')->withSuccess("Email template status has been updated successfully.");
            } catch (\Exception $e) {
               
                return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
            }
        }
    }
}