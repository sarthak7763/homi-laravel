<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Modules\Admin\Http\Requests\PropertyTypeRequest;
use Modules\Admin\Http\Requests\EditPropertyTypeRequest;
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use App\Models\PropertyType;
use Validator,Exception,DataTables;


class PropertyTypeController extends Controller{
  public function index(){
    $propertyTypeList =  PropertyType::where('delete_status',0)->get();
    return view('admin::propertytype.index',compact('propertyTypeList'));  
  }

  public function add() {
    try{
      return view('admin::propertytype.add');
    }
    catch (\Exception $e)  {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function save(PropertyTypeRequest $request) {
    try {
      $data=$request->all();
      $fileNameToStore="";
      //Upload Image
      if($request->hasFile('icon')){
        $fileNameToStore=uploadImage($request->file('icon'),"public/uploads/property_type",'');
      }
        
      $property_type = new PropertyType;
      $property_type->name=$data['name'];
      $property_type->description=$data['description'];
      $property_type->icon=$fileNameToStore;
      $property_type->save();
        toastr()->success('Property Type saved successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->route('admin-property-type-list')->with('success',"Property Type Added Successfully");
    }
    catch (\Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  }
  
  public function edit($slug) {
    try{
      $propertyTypeInfo =PropertyType::where('slug',$slug)->first();
        
      return view('admin::propertytype.edit', compact('propertyTypeInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
    
  public function update(EditPropertyTypeRequest $request){
    $old_img="";
    $data = $request->all();
    try {
      $user=PropertyType::where('slug',$data['slug'])->first();
      //Upload User Image
      $old_img=$user->getRawOriginal('icon');
        
      if($request->hasFile('icon')){
        $data['icon']=uploadImage($request->file('icon'),"public/uploads/property_type",$old_img);
        Storage::disk('local')->delete('public/uploads/property_type/'.$old_img);
      }
      else{
        $data['icon'] = $user->getRawOriginal('icon');
      }
            
      $PropertyTypeData = ["name"=>$data['name'],
                    "description"=>$data['description'],
                    "icon"=>$data['icon'],
                  ]; 

      PropertyType::where('slug',$data['slug'])->update($PropertyTypeData);
             toastr()->success('Property type updated successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);  
      return redirect()->route('admin-property-type-list')->with('success','Property Type Updated Successfully');
    }catch (\Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  }

    public function show($slug){
      $propertyTypeInfo=PropertyType::where('slug',$slug)->first();
     
      return view('admin::propertytype.show',compact('propertyTypeInfo'));  
    }


  public function updateproperty_typeStatus(Request $request){
    try{
      $user=PropertyType::where('id', $request->id)->first();
      if($user->status == 1){
        $data = [ "status"=>0];
        PropertyType::where('id', $request->id)->update($data);
      }else{
        $data = [ "status"=>1];
        PropertyType::where('id', $request->id)->update($data);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e) {  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function deleteproperty_type(Request $request){
    try{
      $data = ["delete_status"=>1];
       PropertyType::where('id', $request->id)->delete();  
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

}