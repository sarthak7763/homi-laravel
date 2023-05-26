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
use Illuminate\Validation\ValidationException;

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

            $action='<a href="'.$route.'" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
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
    try {
      $data=$request->all();

        $request->validate([
        'question' => 'required|unique:faqs,question',
        'answer'=>'required',
        'status'=>'required'
      ]);

      $checkfaqquestion=Faq::where('question',$data['question'])->get()->first();
      if($checkfaqquestion)
      {
        return back()->with('error','FAQ Question already exists.');
      }
      else{
        $faq = new Faq;
        $faq->answer=$data['answer'];
        $faq->question=$data['question'];
        $faq->status=$data['status'];
        $faq->save();
                
        toastr()->success('FAQ saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
         return redirect()->route('admin-faq-list')->with('success','FAQ saved successfully!');
      }
    }
    catch (\Exception $e){
      if($e instanceof ValidationException){
          $listmessage=[];
          foreach($e->errors() as $key=>$list)
          {
              $listmessage[$key]=$list[0];
          }

          if(count($listmessage) > 0)
          {
              return back()->with('valid_error',$listmessage);
          }
          else{
              return back()->with('error','Something went wrong.');
          }
          
      }
      else{
          return back()->with('error','Something went wrong.');
      }
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
    try {
      $data=$request->all();

      $validatedData = $request->validate([
      'question'=>'required',
      'answer'=>'required',
      'status'=>'required'
      ],
      [
        'question.required'=> 'Question is Required',
        'answer.required'=> 'Answer is Required',
        'status.required'=>'Faq status is required'
      ]);

      if(!array_key_exists("id",$data))
      {
        return redirect('admin/faq-list/')->with('error','Something went wrong.');
      }

      $faq = Faq::find($data['id']);
          if(is_null($faq)){
           return redirect('admin/faq-list/')->with('error','Something went wrong.');
        }

        if($faq->question==$data['question'])
        {
          $faq->answer=$data['answer'];
          $faq->status=$data['status'];
        }
        else{
          $checkfaqquestion=Faq::where('question',$data['question'])->get()->first();
          if($checkfaqquestion)
          {
            return back()->with('error','FAQ Question already exists.');
          }
          else{
            $faq->question=$data['question'];
            $faq->answer=$data['answer'];
            $faq->status=$data['status'];
          }
        }

        try{
            $faq->save();
            toastr()->success('Faq updated successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-faq-list')->with('success','Faq updated successfully');      

          }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
          }
    }
    catch (\Exception $e){
      if($e instanceof ValidationException){
          $listmessage=[];
          foreach($e->errors() as $key=>$list)
          {
              $listmessage[$key]=$list[0];
          }

          if(count($listmessage) > 0)
          {
              return back()->with('valid_error',$listmessage);
          }
          else{
              return back()->with('error','Something went wrong.');
          }
          
      }
      else{
          return back()->with('error',$e->getMessage());
      }
    }
  }
  
  public function statusUpdateFaq(Request $request){
    try{

      $data=$request->all();
      if(!array_key_exists("id",$data))
      {
        return redirect('admin/faq-list/')->with('error','Something went wrong.');
      }

      $faq=Faq::where('id', $request->id)->first();
      if($faq->status == 1){
        $updatedata = [ "status"=>0];
        Faq::where('id', $request->id)->update($updatedata);
      }else{
        $updatedata = [ "status"=>1];
        Faq::where('id', $request->id)->update($updatedata);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
  public function deleteFaq(Request $request){
    try{

        $data=$request->all();
        if(!array_key_exists("id",$data))
        {
          return redirect('admin/faq-list/')->with('error','Something went wrong.');
        }
      
        Faq::where('id', $request->id)->delete();
      return response()->json(["success" => "1"]);
    }catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }  
  }
}