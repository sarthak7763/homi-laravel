<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use App\Models\{User,Property,PropertyGallery};
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Image;
use Illuminate\Validation\ValidationException;

class PropertyGalleryController extends Controller{
  
  public function viewGallery($slug){
    try{  
      $propertyInfo=Property::where('slug',$slug)->first();
      
      $galleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',1)->orderBy('id','DESC')->get();

      return view('admin::property.gallery',compact('propertyInfo','galleryList'));

    }catch (\Exception $e) {
      return redirect()->back()->with('error',$e->getMessage());
    }
  }

  public function storepropertyimage(Request $request)
  {
    try{
                $request->validate([
                  'property_id'=>'required',
                  'property_gallery' => 'required|mimes:jpeg,png,jpg'
                ]);

                $property_id=$request->property_id;

                $checkproperty=Property::where('id',$property_id)->get()->first();
                if($checkproperty)
                {
                  $propertyslug=$checkproperty->slug;
                  $fileNameToStore=uploadImage($request->file('property_gallery'),"images/property/gallery/",'');

                  $propertygallery = new PropertyGallery;
                  $propertygallery->property_id=$property_id;
                  $propertygallery->image=$fileNameToStore;
                  $propertygallery->status=1;
                  $propertygallery->type=1;

                  $propertygallery->save();

                  toastr()->success('Property information saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);

                  return redirect()->route('admin-property-gallery-view',$propertyslug)->with('success',"Property Image saved successfully.");

                }
                else{
                  return redirect()->route('admin-property-list')->with('error','Invalid Property.'); 
                }
    }
    catch(\Exception $e){
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

  public function deleteImage(Request $request)
  {
    try
    {
        $galleryInfo =PropertyGallery::where('id',$request->image_id)->first();
         $old_img=$galleryInfo->image;
         $file_path = public_path().'/images/property/gallery/'.$old_img;
          unlink($file_path);
        
        $galleryInfo->delete();
         toastr()->success('File deleted successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
       return response()->json(['success' => 'Files Deleted']);
    }
    catch(Exception $e)
    {
         return response()->json(['error' => 1]);       
    }
  }  

 
}