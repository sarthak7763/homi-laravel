<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Reason;
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables;

class ReasonController extends Controller{
  public function index(Request $request) {
    try{    
      if ($request->ajax()) {
        $data = Reason::get();
          return Datatables::of($data)
          ->addIndexColumn()
          ->addColumn('name ', function ($data) {
          return $data->name;
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
              $route=route('admin-reason-edit',$data->id);
              $action='<a href="'.$route.'" title="Edit" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
              return $action;
          })    
          ->make(true);
      }
      return view('admin::reason.index');
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }   
  }

  public function add(){
    try{
        $reasonList=reason::where([['status',1]])->get();
        return view('admin::reason.add',compact('reasonList'));
    }
    catch(Exception $e)
    {
        return redirect()->back()->with('error', 'something wrong');            
    }
  }

  public function save(Request $request){ 
    $data = $request->all();
    $validatedData = $request->validate([
      'name' => 'required'
      //'type' => 'required',
      ],
      [
        'name.required'=> 'Reason Name is Required'// custom message
        //'type.required'=> 'Reason Type is Required' // custom message
      ]
    );
    
    $data = $request->all();
    try {  
      $reason = new Reason;
      $reason->name=$data['name'];
     // $reason->type=$data['type'];
      $reason->type="Enquiry";
      $reason->status=$data['status'];
      $reason->save();
      
     toastr()->success('Reason saved successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->route('admin-reason-list')->with('success','Reason added successfully');
    } 
    catch (Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  } 
  
  //DISPLAY EDIT DOCTOR FORM VIEW PAGE
  public function edit($id){
    try{
      $reasonInfo =Reason::where('id',$id)->first();
      return view('admin::reason.edit', compact('reasonInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
  
  public function update(Request $request){
    $data = $request->all();
    $state =Reason::where('id',$request->id)->first();
    request()->validate([
        'name' => 'required'
       ]);
   
    try {
      $reasonData = [ "name"=>$data['name'],
                      "type"=>"Enquiry",
                      "status"=>$data['status']]; 

      Reason::where('id',$data['id'])->update($reasonData);
        toastr()->success('Reason updated successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
       return redirect()->route('admin-reason-list')->with('success','Reason info updated successfully');
    }
    catch (\Exception $e){
        return redirect()->back()->with('error', 'something wrong');
    }
  }
  
  public function updateReasonStatus(Request $request){
    try{
      $user=Reason::where('id', $request->id)->first();
      if($user->status == 1)
      {
        $data = [ "status"=>0];
        Reason::where('id', $request->id)->update($data);
      }else
      {
        $data = [ "status"=>1];
        Reason::where('id', $request->id)->update($data);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function editDeleteStatus(Request $request){
    try{
      $data = ["delete_status"=>1];
      Reason::where('id', $request->id)->update($data);
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }  
  }

}