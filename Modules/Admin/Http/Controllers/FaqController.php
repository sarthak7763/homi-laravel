<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request,Response};
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{Faq,User};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,Toastr,Auth;

class FaqController extends Controller{
  
  public function index(Request $request) {
    try{    
      if ($request->ajax()) {
        $data = Faq::get();    
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('question ', function ($data) {
          return $data->question;
        })
        ->addColumn('answer', function ($data) {
          return $data->answer;
        }) 
            
        ->addColumn('status', function($data){
            if($data->status==1){
                $status='<span style="cursor:pointer;" class="badge badge-success badge_status_change" id="'.$data->id.'">Active</span>';
            }else{
                $status='<span style="cursor:pointer;" class="badge badge-danger badge_status_change" id="'.$data->id.'">Inactive</span>';
            }
            return $status;
        })
         
        ->addColumn('action__', function($data){
            $route=route('admin-faq-edit',$data->id);

            $action='<a href="'.$route.'" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a><a href="'.$route.'" title="Delete" data-id="'.$data->id.'" class="btn btn-danger delete_status btn-sm"><i class="fa fa-trash"></i></a>';
            return $action;
        })    
        ->make(true);
      }
      return view('admin::faq.index');
    }catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }   
  }
  public function add(){
      try{
          return view('admin::faq.add');
      }catch(Exception $e){
          return redirect()->back()->with('error', 'something wrong');            
      }
  }
  public function save(Request $request){
    $data = $request->all();
    request()->validate([
        'question' => 'required|unique:faqs,question',
        'answer'=>'required',
    ]);
    $data = $request->all();
    try{ 
      $faq = new Faq;
      $faq->answer=$data['answer'];
      $faq->question=$data['question'];
      $faq->status=$data['status'];
      $faq->add_by=Auth::user()->id;
      $faq->save();
              
      toastr()->success('FAQ saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
       return redirect()->route('admin-faq-list')->with('success','FAQ saved successfully!');
    } catch (Exception $e){
       return redirect()->back()->with('error', 'something wrong');
    }
  } 
  //DISPLAY EDIT DOCTOR FORM VIEW PAGE
  public function edit($id){
    try{  
      $faqInfo =Faq::where('id',$id)->first();
      return view('admin::faq.edit', compact('faqInfo'));
    }catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
  public function update(Request $request){
    $data = $request->all();
    $faq =Faq::where('id',$request->id)->first();
    request()->validate([
        'answer' => 'required',
        'question' => 'required|unique:faqs,question,'.$request->id,
       ]);
    try {
        $faqData = [ "question"=>$data['question'],
                      "answer"=>$data['answer'],
                      "status"=>$data['status']
        ]; 
        Faq::where('id',$data['id'])->update($faqData);
         toastr()->success('Faq updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
       return redirect()->route('admin-faq-list')->with('success','faq updated successfully');
    }catch (\Exception $e){
        return redirect()->back()->with('error', 'something wrong');
    }
  }
  
  public function statusUpdateFaq(Request $request){
    try{
      $faq=Faq::where('id', $request->id)->first();
      if($faq->status == 1){
        $data = [ "status"=>0];
        Faq::where('id', $request->id)->update($data);
      }else{
        $data = [ "status"=>1];
        Faq::where('id', $request->id)->update($data);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
  public function deleteFaq(Request $request){
    try{
        Faq::where('id', $request->id)->delete();
      return response()->json(["success" => "1"]);
    }catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }  
  }
}