<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use Auth,Image,Mail,DB,Hash,Validator,Exception;
use App\Models\{User,SystemSetting};
use Illuminate\Support\Arr;
use App\Helpers\Helper;


class SystemSettingController extends Controller {

    public function __construct(SystemSetting $SystemSetting) {
        $this->SystemSetting = $SystemSetting;
    }

    public function index() {
        try {
            $systemSettingData = SystemSetting::all();
            return view('admin::systemsettings.index', compact('systemSettingData'));
        } catch (\Throwable $th) {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    
    public function update(Request $request) {
        try {
            $data = $request->all();
            $arr = array();
            $cont = count($request->slug);
            for ($j = 0; $j < $cont; $j++) {
                if (isset($request->value[$j])) {
                    $arr[$j]['value'] = $request->value[$j];
                    $arr[$j]['slug'] = $request->slug[$j];
                    $arr[$j]['setting_type'] = $request->setting_type[$j];
                }
            }
           

            foreach ($arr as $arrEach) {

                SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);     
            }

            toastr()->success('System settings details updated successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect('admin/system-settings')->withSuccess("System settings details updated successfully.");

           
        } catch (\Throwable $th) {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function indexSiteLogo() {
        try {
            $systemSettingData = SystemSetting::where("setting_type", "sitelogo")->first();
           
             $systemfavData = SystemSetting::where("setting_type", "sitefavicon")->first();
            return view('admin::systemsettings.index-site-logo', compact('systemSettingData','systemfavData'));
        } catch (\Throwable $th) {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function updateSiteLogo(Request $request) {
      //  try {

            $data = $request->all();
            $fileNameToStore="";
            
             $request->validate([
            
               'value' =>  'required|image|mimes:jpg,png,jpeg,gif,svg|max:1048|dimensions:min_width=20,min_height=10,max_width=300,max_height=100'],
               
               ["value.required"=>"Logo Image File is required",
               "value.image"=>"Logo Image File should be an image",
               "value.mimes"=>"Logo Image must be a file of type: jpg, png, jpeg, gif, svg.",
               "value.max"=>"Logo Image file should be less than 2MB",
               "value.dimensions"=>"Logo Image file should be in between width*hight : 10*20 minimum to 300*100 maximum dimension"
             ]
            );

          
            //Upload Image
            $logo=SystemSetting::where('setting_type','sitelogo')->first();

            if($logo){
                $old_logo=$logo->option_value;
            }
         
            if($request->hasFile('value')){
                $data['logo_img']=uploadImage($request->file('value'),"public/uploads/sitelogo/",$old_logo);
                Storage::disk('local')->delete('public/'.$old_logo);
                $data['logo_image']="/uploads/sitelogo/".$data['logo_img'];
            }else{
                $data['logo_image'] =  $old_logo;
            }


            SystemSetting::where("setting_type", "sitelogo")->update(['option_value' =>$data['logo_image']]);
            
            toastr()->success('Site logo updated successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-site-logo')->withSuccess("Site Logo updated successfully.");       

        // } catch (\Throwable $th) {
        //     toastr()->error('Either something went wrong or invalid access!', 'Error');
        //     return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        // }
    }

      public function updateSiteFavIcon(Request $request) {
        try {

            $data = $request->all();
            $fileNameToStore="";
            
             $request->validate([
            
               'favicon' =>  'required|image|mimes:jpg,png,jpeg,gif,svg|max:1048|dimensions:min_width=10,min_height=10,max_width=50,max_height=50'],
               
               ["favicon.required"=>"Favicon Image File is required",
               "favicon.image"=>"Favicon Image File should be an image",
               "favicon.mimes"=>"Favicon Image must be a file of type: jpg, png, jpeg, gif, svg.",
               "favicon.max"=>"Favicon Image file should be less than 2MB",
               "favicon.dimensions"=>"Favicon Image file dimension should be in between width*hight : 10*10 minimum to 50*50 maximum dimension"]
            );

          
            //Upload Image
            $logo=SystemSetting::where('setting_type','sitefavicon')->first();
            if($logo){
                $old_logo=$logo->option_value;
            }
         
            if($request->hasFile('favicon')){
                $data['logo_img']=uploadImage($request->file('favicon'),"public/uploads/sitelogo/",$old_logo);
                Storage::disk('local')->delete('public/'.$old_logo);
                $data['logo_image']="/uploads/sitelogo/".$data['logo_img'];
            }else{
                $data['logo_image'] =  $old_logo;
            }


            SystemSetting::where("setting_type", "sitefavicon")->update(['option_value' =>$data['logo_image']]);
            
            toastr()->success('Site logo updated successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-site-logo')->withSuccess("Site favicon updated successfully.");       

        } catch (\Throwable $th) {
            toastr()->error('Either something went wrong or invalid access!', 'Error');
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }
   
}
