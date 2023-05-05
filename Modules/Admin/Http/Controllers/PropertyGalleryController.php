<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use App\Models\{MailAction,MailTemplate,User,Property,PropertyGallery,Country,State,City};
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Image;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\FFMpeg\CopyFormat;
class PropertyGalleryController extends Controller{
  public function index() {
    try{   
      $galleryList =  PropertyGallery::get();
      return view('admin::propertygallery.index',compact('galleryList'));
    
    }catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function viewDocument($slug){
    try{  
      $propertyInfo=Property::where('slug',$slug)->first();
      $liste=[];
      $dgalleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Document")->orderBy('name','DESC')->get();
    
      return view('admin::property.document',compact('propertyInfo','dgalleryList'));
    }catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  
  public function viewGallery($slug){
    try{  
      $propertyInfo=Property::where('slug',$slug)->first();
      
      $galleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Image")->orderBy('id','DESC')->get();
      
       $featuredImg=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Image")->where('is_featured',1)->orderBy('id','DESC')->get();


      return view('admin::property.gallery',compact('propertyInfo','galleryList','featuredImg'));
    }catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }


  public function viewVideo($slug){
    try{  
      $propertyInfo=Property::where('slug',$slug)->first();
      $vgalleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Video")->orderBy('id','DESC')->get();

      return view('admin::property.video',compact('propertyInfo','vgalleryList'));
    }catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

    public function add() {
        try{
            $propertyList=Property::where('delete_status',0)->get();
            return view('admin::propertygallery.add',compact('propertyList'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }
    }

    //SAVE VIDEO 
    public function save(Request $request){
      $data = $request->all();
      
      request()->validate([
        "upload_file"=>"required | mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv |max:9000000"
      ]);

      $data = $request->all();
      try {
        $path = $request->file('upload_file')->store('public/uploads/PropertyGallery');
        $name =  $request->file('upload_file')->getClientOriginalName();
        $fileName_no_extension = pathinfo($name,PATHINFO_FILENAME).'_'.time().'.jpg';
       
        FFMpeg::fromDisk('local')
        ->open($path)
        ->getFrameFromSeconds(1)
        ->export()
        ->inFormat(new CopyFormat)
        ->save('public/uploads/PropertyGallery/'.$fileName_no_extension);

        $PropertyGallery = new PropertyGallery;
        $PropertyGallery->property_id=$data['vproperty_id'];
        $PropertyGallery->attachment=$request->file('upload_file')->hashName();
        $PropertyGallery->type=$data['type'];
        $PropertyGallery->thumbnail = $fileName_no_extension;
        $PropertyGallery->add_by=auth()->user()->id;
        $PropertyGallery->save();
        
        if($PropertyGallery->id){
          toastr()->success('Video saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           return redirect()->route('admin-property-video-view',$data['vproperty_slug']);
        }     
      }catch (Exception $e){
       return redirect()->back()->with('error', 'something wrong');
      }
    }
     //SAVE DOC 
    public function saveDocument(Request $request){
      $validatedData =$request->validate([
        'document_file'=>'required|mimes:pdf',
        'doc_title' => "required"
      ],['document_file.required'=>'Document File is required',
        'doc_title.required'=>'Document Name is required',
        'document_file.mimes'=>'Allow only pdf file format',

      ]);
      try{
        $doc=$request->doc_title;
        if ($request->hasfile('document_file')) {
          $images = $request->file('document_file');
          $name = $images->getClientOriginalName();
          $path = $images->store('public/uploads/PropertyGallery');
          
          PropertyGallery::create([
            'property_id'=>$request->property_id,
            'attachment'=>$images->hashName(),
            'type'=>$request->type,
            'name'=>$doc,
            'add_by' => auth()->user()->id
          ]);


          toastr()->success('Document saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
          return redirect()->route('admin-property-documents-view',$request->property_slug)->with('success','Document saved successfully!');
        }
      }
      catch(Exception $e){
        return redirect()->back()->with('error', 'Something went wrong');
      }
    }
   
    //SAVE VIDEO   
  public function save1(Request $request){
    try{
      $str="";
      $validator = Validator::make($request->all(), [
        "upload_file"=>"required | mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv |max:9000000"
    
      ]);
     
      $type=$request->type;
        
      $path = $request->file('upload_file')->store('public/uploads/PropertyGallery');
      $name =  $request->file('upload_file')->getClientOriginalName();
         
      PropertyGallery::create([
            'property_id'=>$request->vproperty_id,
            'attachment'=>$request->file('upload_file')->hashName(),
            'type'=>$type,
            'add_by' => auth()->user()->id
      ]);
      toastr()->success('File uploaded successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->route('admin-property-video-view',$request->vproperty_slug)->with('success',"Video uploaded successfully");
    }catch (\Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function store(Request $request){
    if($request->hasFile('profile_image')) {
        //get filename with extension
        $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('profile_image')->getClientOriginalExtension();
  
        //filename to store
        $filenametostore = $filename.'_'.time().'.'.$extension;
 
        //small thumbnail name
        $smallthumbnail = $filename.'_small_'.time().'.'.$extension;
 
        //medium thumbnail name
        $mediumthumbnail = $filename.'_medium_'.time().'.'.$extension;
 
        //large thumbnail name
        $largethumbnail = $filename.'_large_'.time().'.'.$extension;
 
        //Upload File
        $request->file('profile_image')->storeAs('public/profile_images', $filenametostore);
        $request->file('profile_image')->storeAs('public/profile_images/thumbnail', $smallthumbnail);
        $request->file('profile_image')->storeAs('public/profile_images/thumbnail', $mediumthumbnail);
        $request->file('profile_image')->storeAs('public/profile_images/thumbnail', $largethumbnail);
  
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/profile_images/thumbnail/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 150, 93);
 
        //create medium thumbnail
        $mediumthumbnailpath = public_path('storage/profile_images/thumbnail/'.$mediumthumbnail);
        $this->createThumbnail($mediumthumbnailpath, 300, 185);
 
        //create large thumbnail
        $largethumbnailpath = public_path('storage/profile_images/thumbnail/'.$largethumbnail);
        $this->createThumbnail($largethumbnailpath, 550, 340);
  
        return redirect('image')->with('success', "Image uploaded successfully.");
    }
  }

  public function createThumbnail($path, $width, $height){
      $img = Image::make($path)->resize($width, $height, function ($constraint) {
          $constraint->aspectRatio();
      });
      $img->save($path);
  }

  public function storeMultiFile(Request $request){
      $rules = [];

    $validator = Validator::make($request->all(), [
     'files' => 'required',
      'files.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:8000|dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
      // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000',
      
    ]
    // ,[ 'files.*.image'=>"The file you are trying to upload should be an image only",
    //     'files.*.mimes'=>"The image extension should be jpg, png, jped,gif, svg only",
    //     'files.*.max'=>"The image you are trying to upload has exceed the maximum size 2048KB.",
    //     'files.*.dimensions'=>"Please change your image to match the required upload dimensions. Dimensions 100*100 to 3000*3000"
    
  
    // ]
    );

    //  foreach(range(0, $files) as $index) {
    //     $rules['files.' . $index] = 'required|mimes:png,jpeg,jpg,gif|max:2048';
    // }

    //  if ($validator->fails()) {
    //     return response()->json(array(
           
    //         'error' => $validator->getMessageBag()
    //     ) , 400);
    // }
 
    if($validator->passes()) {
     // $files = count($request->file('files')) - 1;
      if($request->TotalFiles > 0)
      {           
       for ($x = 0; $x < $request->TotalFiles; $x++) 
       {
        if ($request->hasFile('files'.$x)) 
        {
          $file      = $request->file('files'.$x);
          //$path1=uploadMultipleImage($request->file('files'.$x),"public/uploads/PropertyGallery");
          $path = $file->store('public/uploads/PropertyGallery');
          $name = $file->getClientOriginalName();

          //$insert[$x]['name'] = $name;
          PropertyGallery::create([
            'property_id'=>$request->property_id,
            'attachment'=>$file->hashName(),
            'type'=>"Image",
            'add_by' => auth()->user()->id
          ]);

          //$insert[$x]['path'] = $path;
        }
      }
      $featured_count=0;
        $galleryInfo =PropertyGallery::where([['is_featured',1],['property_id',$request->property_id]])->get();
        if($galleryInfo){
           $featured_count=$galleryInfo->count();
         }

        if($galleryInfo->count() >6)
        {
          $statusUpdate = ["status"=>1];
          Property::where('id', $request->property_id)->update($statusUpdate);
        }else{
          $statusUpdate = ["status"=>0];
          Property::where('id', $request->property_id)->update($statusUpdate);
        }

        //PropertyGallery::insert($insert);
        toastr()->success('Image uploaded successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
        return response()->json(['success'=>'Ajax Multiple file has been uploaded','featured_count'=>$featured_count]);
      }
      else
      {
         return response()->json(["message" => "Please try again."]);
      }
    }else{
      $string="";
      $d=$validator->getMessageBag()->toArray();
       $karry=array_values($d);
      
    
      foreach($karry as $k=>$li){
          $counter=$k+1;
        foreach($li as $key=>$l){
          if(strpos($l, "files") !== false){
            $a="files";
            $b="Image";
            $string.='<li>'.str_replace($a,$b,$l).'</li>';
          }else{
            $a="files.".$k;
            $b="Image ".$counter;
            $string.='<li>'.str_replace($a,$b,$l).'</li>';
          }
       
        }

      }
        return response()->json(['error_str'=> $string]);
    }
  }



  public function setFeaturedImagePosition(Request $request){
      $data = [ "position"=>$request->position];
      PropertyGallery::where('id', $request->id)->update($data);
      return response()->json(["message" => "success"]);

  }

  public function setFeatured(Request $request){
      $galleryInfo =PropertyGallery::where([['is_featured',1],['property_id',$request->property_id]])->get();
      if($galleryInfo){
         $featured_count=$galleryInfo->count();
         if($featured_count==5){
          
               return response()->json(["status"=>0,"message" => "Maximum Limit exceeded. Only 5 image can select as featured image."]);
         }else{
            $data = [ "is_featured"=>1];
            PropertyGallery::where('id', $request->image_id)->update($data);
              return response()->json(["status"=>1,"message" => "success"]);
         }
       }
  }

  public function removeFeatured(Request $request){

    $data = ["is_featured"=>0];
    $resp=PropertyGallery::where('id', $request->id)->update($data);
    if($resp){
      return response()->json(["status" => "success"]);
    }else{
      return response()->json(["status" => "error"]);
    }
    
  }

  //DISPLAY EDIT DOCTOR FORM VIEW PAGE
  public function delete(Request $request){
    
    $galleryInfo =PropertyGallery::where('attachment',$request->file)->first();
    Storage::disk('local')->delete('public/uploads/PropertyGallery/'.$galleryInfo->attachment);
    $galleryInfo->delete();
    toastr()->success('File Deleted Successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           
    return response()->json(['success' => 'Files Deleted']);
    
  }

  public function deleteImage1($id)
  {
    try
    {
      $galleryInfo =PropertyGallery::where('id',$id)->first();  
      Storage::disk('local')->delete('public/uploads/PropertyGallery/'.$galleryInfo->attachment);  
      $galleryInfo->delete();    
      return redirect()->route('admin-property-gallery-list')->with('success',"Gallery image deleted successfully"); 
    }
    catch(Exception $e)
    {
        return redirect()->back()->with('error', 'something wrong');            
    }
  }

  public function deleteImage(Request $request)
  {
    try
    {
        $galleryInfo =PropertyGallery::where('id',$request->image_id)->first();
         $old_img=$galleryInfo->getRawOriginal('attachment');
        Storage::disk('local')->delete('public/uploads/PropertyGallery/'.$old_img);
        
        $galleryInfo->delete();
         toastr()->success('File deleted successfully','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
       return response()->json(['success' => 'Files Deleted']);
    }
    catch(Exception $e)
    {
         return response()->json(['error' => 1]);       
    }
  }  


  public function updateDocumentStatus(Request $request)
  {
    try
    {
      $propertyGallery=PropertyGallery::where('id', $request->id)->first();
      if($propertyGallery->status == 1)
      {
        $data = [ "status"=>0];
        PropertyGallery::where('id', $request->id)->update($data);
      }else
      {
        $data = [ "status"=>1];
        PropertyGallery::where('id', $request->id)->update($data);
      }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e)
    {  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

 
}