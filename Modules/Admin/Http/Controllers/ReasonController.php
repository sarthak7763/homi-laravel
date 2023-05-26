<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\CancelReasons;
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables;
use Illuminate\Validation\ValidationException;

class ReasonController extends Controller{
  public function index(Request $request) {
    try{    
      if ($request->ajax()) {
        $data = CancelReasons::get();
          return Datatables::of($data)
          ->addIndexColumn()
          ->addColumn('name', function ($data) {
          return $data->reason_name;
          })
        
          ->addColumn('status', function($data){
              if($data->reason_status==1){
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
        return view('admin::reason.add');
    }
    catch(Exception $e)
    {
        return redirect()->back()->with('error', 'something wrong');            
    }
  }

  public function save(Request $request){ 
    try {
      $data=$request->all();

      $validatedData = $request->validate([
      'name' => 'required',
      'status'=>'required'
      ],
      [
        'name.required'=> 'Reason Name is Required',
        'status.required'=>'Reason status is required'
      ]);

      $checkreasonname=CancelReasons::where('reason_name',$data['name'])->get()->first();
      if($checkreasonname)
      {
        return redirect()->back()->with('error', 'Reason name already exists.');
      }
      else{
        $reason = new CancelReasons;
        $reason->reason_name=$data['name'];
        $reason->reason_description=$data['description'];
        $reason->reason_status=$data['status'];
        $reason->save();
        
       toastr()->success('Reason saved successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
        return redirect()->route('admin-reason-list')->with('success','Reason added successfully');
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
      $reasonInfo =CancelReasons::where('id',$id)->first();
      return view('admin::reason.edit', compact('reasonInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
  
  public function update(Request $request){
    try {
      $data=$request->all();

      $validatedData = $request->validate([
      'name' => 'required',
      'status'=>'required'
      ],
      [
        'name.required'=> 'Reason Name is Required',
        'status.required'=>'Reason status is required'
      ]);

      if(!array_key_exists("id",$data))
      {
        return redirect('admin/reason-list/')->with('error','Something went wrong.');
      }

      $reason = CancelReasons::find($data['id']);
          if(is_null($reason)){
           return redirect('admin/reason-list/')->with('error','Something went wrong.');
        }

        if($reason->reason_name==$data['name'])
        {
          $reason->reason_description=$data['description'];
          $reason->reason_status=$data['status'];
        }
        else{
          $checkreasonname=CancelReasons::where('reason_name',$data['name'])->get()->first();
          if($checkreasonname)
          {
            return redirect()->back()->with('error', 'Reason name already exists.');
          }
          else{
            $reason->reason_name=$data['name'];
            $reason->reason_description=$data['description'];
            $reason->reason_status=$data['status'];
          }
        }

        try{
            $reason->save();
            toastr()->success('Reason updated successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-reason-list')->with('success','Reason updated successfully');      

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
  
  public function updateReasonStatus(Request $request){
    try{
      $data=$request->all();
      if(!array_key_exists("id",$data))
      {
        return redirect('admin/reason-list/')->with('error','Something went wrong.');
      }

      $reason=CancelReasons::where('id', $request->id)->first();
      if($reason->reason_status == 1)
      {
        $updatedata = [ "reason_status"=>0];
        CancelReasons::where('id', $request->id)->update($updatedata);
      }else
      {
        $updatedata = [ "reason_status"=>1];
        CancelReasons::where('id', $request->id)->update($updatedata);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

}