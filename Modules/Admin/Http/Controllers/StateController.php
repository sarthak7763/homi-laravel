<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\{User,Country,State,City,Property};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash, Validator, Exception, DataTables;

class StateController extends Controller{
    public function index(Request $request) {
        try{    
            if ($request->ajax()) {
                $data = State::with('getCountry')->orderBy('name')->get();
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
                    $route=route('admin-state-edit',$data->id);
                    $action='<a href="'.$route.'" title="Edit" class="btn btn-primary"><i class="fa fa-edit"></i></a> <button type="button" title="Delete" class="btn btn-danger badge_delete_status_change" data-id="'.$data->id.'"><i class="fa fa-trash"></i></button>';
                    return $action;
                })    
                ->make(true);
            }
            return view('admin::state.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }   
    }
    public function add(){
        try{
            $countryList=Country::where([['status',1]])->get();
            return view('admin::state.add',compact('countryList'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function save(Request $request){
        $data = $request->all();
         $validatedData = $request->validate([
            'name' => 'required|unique:states,name'
             
           ],
           [
              'name.required'=> 'State Name is Required', // custom message
              'name.unique'=> 'State Name already exist', 
           ]
        );

           $data = $request->all();
           try { 
               $state = new State;
               $state->country_id=$data['country'];
               $state->name=$data['name'];
            
               $state->save();
             toastr()->success('State saved successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
               return redirect()->route('admin-state-list')->with('success','State added successfully');
            } catch (Exception $e){
               return redirect()->back()->with('error', 'something wrong');
            }
    } 
    //DISPLAY EDIT DOCTOR FORM VIEW PAGE
    public function edit($id){
        try{
            $stateInfo =State::with('getCountry')->where('id',$id)->first();
            return view('admin::state.edit', compact('stateInfo'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function update(Request $request){
        $data = $request->all();
        $state =State::where('id',$request->id)->first();
        $validatedData = $request->validate([
            'name' => 'required|unique:states,name,'.$request->id],
           [
              'name.required'=> 'State Name is Required',
              'name.unique'=> 'State Name already exist',

           ]
        );
        try {
            $countryData = [ "name"=>$data['name'],
                          
                            "status"=>$data['status']]; 

            State::where('id',$data['id'])->update($countryData);
             toastr()->success('State updated successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           return redirect()->route('admin-state-list')->with('success','State info updated successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }
    }
  public function updateStateStatus(Request $request)
  {

    try{
      $user=State::where('id', $request->id)->first();

      if($user->status == 1) {
       
        $data = ["status"=>0,"status_type"=>"Auto"];
        State::where('id', $request->id)->update(['status'=>0]);
        //GET ALL CITY OF STATE ID
        $cityList=City::where([['state_id',$request->id],['status',1],['delete_status',0],['status_type','!=','Manual']])->get();
      
        if(!$cityList->isEmpty()){
        	foreach ($cityList as $key => $city) {
        		//DISBALE ALL CITY ID
        		City::where('id', $city->id)->update($data);
        	}
        }

        $PropertyList=Property::where([['state', $request->id],['status',1],['delete_status',0],['status_type','!=','Manual']])->get();
        if(!$PropertyList->isEmpty()){
        	foreach ($PropertyList as $k => $li) {
        		Property::where('id', $li->id)->update($data);
        	}
        }

      }else {
        $data = ["status"=>1,"status_type"=>""];
        //GET ALL CITY OF STATE ID
        $cityList=City::where([['state_id',$request->id],['status',0],['delete_status',0],['status_type','Auto']])->get();
        
        if(!$cityList->isEmpty()){
        	foreach ($cityList as $key => $city) {
        		//DISBALE ALL CITY ID
        		City::where('id', $city->id)->update($data);
        	}
        }

        $PropertyList=Property::where([['state', $request->id],['status',0],['delete_status',0],['status_type','Auto']])->get();
        
        if(!$PropertyList->isEmpty()){
          foreach ($PropertyList as $k => $li) {
            Property::where('id', $li->id)->update($data);
          }
        }

        State::where('id', $request->id)->update(['status'=>1]);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
    public function updateDeleteStatus(Request $request){
       try{
            $data = ["delete_status"=>1];
            State::where('id', $request->id)->update($data);
            return response()->json(["success" => "1"]);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }  
    }

     public function deleteState(Request $request){
       try{
        
            State::where('id', $request->id)->delete();
            return response()->json(["success" => "1"]);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }  
    }
}