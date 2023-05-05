<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request,Response};
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,Country,State,City,Property};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,Toastr;

class CityController extends Controller{
    public function index(Request $request) {
        try{    
            if ($request->ajax()) {

                $data = City::whereHas('getState',function($w){
                  $w->orderBy('name','ASC');
                })->with(['getState'=>function($q){
                  $q->orderBy('name','ASC');
                }])->orderBy('name','ASC')->get();


              
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name ', function ($data) {
                return $data->name;
                })
                // ->addColumn('slug', function ($data) {
                //     return $data->slug;
                //     })
                ->addColumn('country', function ($data) {
                return $data->getState->getCountry->name;
                })
               
                ->addColumn('state', function ($data) {
                    return $data->getState->name;
                    })
                // ->addColumn('latitude', function ($data) {
                //     return $data->latitude;
                //     })
                // ->addColumn('logitude', function ($data) {
                //     return $data->logitude;
                //     })
                ->addColumn('status', function($data){
                    if($data->status==1){
                        $status='<span style="cursor:pointer;" class="badge badge-success badge_status_change" id="'.$data->id.'">Active</span>';
                    }else{
                        $status='<span style="cursor:pointer;" class="badge badge-danger badge_status_change" id="'.$data->id.'">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('delete_status', function($data){
                    if($data->delete_status==1){
                        $status='<span style="cursor:pointer;" class="badge badge-danger">Deleted</span>';
                    }else{
                        $status='<span style="cursor:pointer;" class="badge badge-success delete_status" id="'.$data->id.'">Not Deleted</span>';
                    }
                    return $status;
                    })
                ->addColumn('action__', function($data){
                    $route=route('admin-city-edit',$data->id);
                    $action='<a href="'.$route.'" title="Edit" class="btn btn-primary"><i class="fa fa-edit"></i></a> <button type="button" title="Delete" class="btn btn-danger badge_delete_status_change" data-id="'.$data->id.'"><i class="fa fa-trash"></i></button>';
                    
                    return $action;
                })    
                ->make(true);
            }
            return view('admin::city.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }   
    }
    public function add(){
        try{
            $stateList=State::where([['status',1]])->orderBy('name')->get();
            return view('admin::city.add',compact('stateList'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function save(Request $request){
        $data = $request->all();
        request()->validate([
            'name' => 'required',
            'state'=>'required',
          //  'abbr' => 'required|unique:countries',
          //  'slug' => 'required|alpha_dash|string|unique:countries'
           ]);
           $data = $request->all();
         try { 
               $city = new City;
               $city->state_id=$data['state'];
               $city->name=$data['name'];
             //  $city->abbr=$data['abbr'];
              // $city->slug=$data['slug'];
             //  $city->status=$data['status'];
             //  $city->longitude=$data['longitude'];
             //  $city->latitude=$data['latitude'];
               $city->save();
            toastr()->success('City information saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
               return redirect()->route('admin-city-list')->with('success','City information saved successfully!');
            } catch (Exception $e){
               return redirect()->back()->with('error', 'something wrong');
            }
    } 
    //DISPLAY EDIT DOCTOR FORM VIEW PAGE
    public function edit($id){
       try{
            $stateList=State::where([['status',1]])->orderBy('name')->get();
            $cityInfo =City::with('getState')->where('id',$id)->first();
            return view('admin::city.edit', compact('cityInfo','stateList'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function update(Request $request){
        $data = $request->all();
        $city =City::where('id',$request->id)->first();
        request()->validate([
            'name' => 'required'
            //'abbr' => 'required|unique:cities,abbr,'.$city->id,
           // 'slug' => 'required|alpha_dash|string|unique:cities,slug,'.$city->id,
           ]);
        try {
            $cityData = [ "name"=>$data['name'],
                          "state_id"=>$data['state'],
                           // "abbr"=>$data['abbr'],
                           // "longitude"=>$data['longitude'],
                           // "latitude"=>$data['latitude'],
                           "status"=>$data['status'],
                           "status_type"=>"Manual"
            ]; 

            City::where('id',$data['id'])->update($cityData);
             toastr()->success('City information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           return redirect()->route('admin-city-list')->with('success','City information updated successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }
    }
  
  public function updateCityStatus(Request $request)
  {
    try
    {
      $user=City::where('id', $request->id)->first();
      if($user->status == 1)
      {
        $data = [ "status"=>0, "status_type"=>"Manual"];
        $data_status = [ "status"=>0, "status_type"=>"Auto"];
        City::where('id', $request->id)->update($data);
        $PropertyList=Property::where([['city', $request->id],['status',1],['status_type','!=',"Manual"],['delete_status',0]])->get();
        if(!$PropertyList->isEmpty()){
          foreach ($PropertyList as $k => $li) {

            Property::where('id', $li->id)->update($data_status);
          }
        }
      }else
      {
        $data = [ "status"=>1, "status_type"=>""];
        City::where('id', $request->id)->update($data);
        $PropertyList=Property::where([['city', $request->id],['status',0],['status_type',"Auto"],['delete_status',0]])->get();
        if(!$PropertyList->isEmpty()){
          foreach ($PropertyList as $k => $li) {
            Property::where('id', $li->id)->update($data);
          }
        }
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e)
    {  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }


   
    public function updateDeleteStatus(Request $request){
       try{
            $data = ["delete_status"=>1];
            City::where('id', $request->id)->update($data);
            return response()->json(["success" => "1"]);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }  
    }

     public function deleteCity(Request $request){
       try{
           // $data = ["delete_status"=>1];
            City::where('id', $request->id)->delete();
            return response()->json(["success" => "1"]);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }  
    }
}