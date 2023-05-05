<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request,Response};
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,Country,State,City};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables;

class CountryController extends Controller{
    public function index(Request $request) {
        try{    
            if ($request->ajax()) {
                $data = Country::get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name ', function ($data) {
                return $data->name;
                })
                ->addColumn('sortname', function ($data) {
                return $data->sortname;
                })
                // ->addColumn('slug', function ($data) {
                // return $data->slug;
                // })
                ->addColumn('status', function($data){
                    if($data->status==1){
                        $status='<span style="cursor:pointer;" class="badge badge-success badge_status_change" id="'.$data->id.'">Active</span>';
                    }else{
                        $status='<span style="cursor:pointer;" class="badge badge-danger badge_status_change" id="'.$data->id.'">Block</span>';
                    }
                    return $status;
                })
                // ->addColumn('delete_status', function($data){
                //     if($data->delete_status==1){
                //         $status='<span style="cursor:pointer;" class="badge badge-danger">Deleted</span>';
                //     }else{
                //         $status='<span style="cursor:pointer;" class="badge badge-success delete_status" id="'.$data->id.'">Not Deleted</span>';
                //     }
                //     return $status;
                //     })
                ->addColumn('action__', function($data){
                    $route=route('admin-country-edit',$data->id);
                    $action='<a href="'.$route.'" title="Edit" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
                    return $action;
                })    
                ->make(true);
            }
            return view('admin::country.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }   
    }
    public function add(){
        try{
            return view('admin::country.add');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function save(Request $request){
        $data = $request->all();
        $validatedData = $request->validate([
            'name' => 'required',
            'sortname' => 'required',
           ],
           [
              'name.required'=> 'Country Name is Required', // custom message
              'sortname.required'=> 'Country Abbreviation is Required' // custom message
           ]
        );
       
           $data = $request->all();
            try { 
               $country = new Country;
               $country->name=$data['name'];
               $country->sortname=$data['sortname'];
               $country->status=$data['status'];
               $country->save();
               toastr()->success('Country saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
               return redirect()->route('admin-country-list')->with('success','Country added successfully');
            } catch (Exception $e){
               return redirect()->back()->with('error', 'something wrong');
            }
    } 
    //DISPLAY EDIT DOCTOR FORM VIEW PAGE
    public function edit($id){
        try{
            $countryInfo =Country::where('id',$id)->first();
            return view('admin::country.edit', compact('countryInfo'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function update(Request $request){
        $data = $request->all();
        $country =Country::where('id',$request->id)->first();
          $validatedData = $request->validate([
            'name' => 'required',
            'sortname' => 'required',
           ],
           [
              'name.required'=> 'Country Name is Required', // custom message
              'sortname.required'=> 'Country Abbreviation is Required' // custom message
           ]
        );

        try {
            $countryData = [ "name"=>$data['name'],
                          //"slug"=>$data['slug'],
                          "sortname"=>$data['sortname'],
                          "status"=>$data['status']]; 

            Country::where('id',$data['id'])->update($countryData);
             toastr()->success('Country information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           return redirect()->route('admin-country-list')->with('success','Country info updated successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }
    }
   public function updateCountryStatus(Request $request)
  {
    try
    {
      $user=Country::where('id', $request->id)->first();
      if($user->status == 1)
      {
        $data = [ "status"=>0];
        Country::where('id', $request->id)->update($data);
      }else
      {
        $data = [ "status"=>1];
        Country::where('id', $request->id)->update($data);
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
            Country::where('id', $request->id)->update($data);
            return response()->json(["success" => "1"]);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }  
    }
}