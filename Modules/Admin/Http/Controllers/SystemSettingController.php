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
    public function create() {
        return view('admin::systemsettings.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
                    'option_name' => 'required',
                    'option_value' => 'required',
                    'setting_type' => 'required',
                    'status' => 'required',
                    
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->messages());
        }
        try {
              $countLogo=SystemSetting::where('setting_type','sitelogo')->count();
              $countfav=SystemSetting::where('setting_type','sitefavicon')->count();
               if($data['setting_type']=="sitelogo"){
                if($countLogo>0){
                    toastr()->error('Logo option already exist.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                    return redirect('admin/system-settings')->withError("Logo option already exist.."); 
                }else{
                    SystemSetting::create($data);
                    toastr()->success('Option add successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                    return redirect('admin/system-settings')->withSuccess("Logo option added successfully."); 
                }
            }
            else if($data['setting_type']=="sitefavicon"){
                if($countfav>0){
                    toastr()->error('Favicon option already exist.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                    return redirect('admin/system-settings')->withError("Favicon option already exist.."); 
                }else{
                    SystemSetting::create($data);
                    toastr()->success('Option add successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                    return redirect('admin/system-settings')->withSuccess("Favicon option added successfully."); 
                }
            }else{

                    SystemSetting::create($data);
                    toastr()->success('Option add successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                    return redirect('admin/system-settings')->withSuccess($data['option_name']." option add successfully."); 

               }
            
           
        } catch (Exception $ex) {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
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
                    $arr[$j]['option_update_name'] = $request->option_update_name[$j];
                    
                }
            }
           

            foreach ($arr as $arrEach) {
                if ($arrEach['setting_type'] == 'smtp') {
                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                    
                   
                } 
                elseif ($arrEach['setting_type'] == 'stripe') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                   

                } 
                elseif ($arrEach['setting_type'] == 'footersocialmedia') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                   
                } 
                elseif ($arrEach['setting_type'] == 'currency') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                   

                } elseif ($arrEach['setting_type'] == 'top-bar') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                    

                } elseif ($arrEach['setting_type'] == 'email_footer_content') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                     
                
                } elseif ($arrEach['setting_type'] == 'footer_content') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                  
                }
                elseif ($arrEach['setting_type'] == 'email_signature') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                  
                }
                elseif ($arrEach['setting_type'] == 'header_content') {

                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                  
                }
                 elseif ($arrEach['setting_type'] == 'customersupport') {
                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                  

                } elseif ($arrEach['setting_type'] == 'blogs') {
                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                   

                } elseif ($arrEach['setting_type'] == 'googleservicekeys') {
                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                    

                } elseif ($arrEach['setting_type'] == 'homecontentsection') {
                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                    


                } elseif ($arrEach['setting_type'] == 'returnpolicydayssection') {
                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                    

                } elseif ($arrEach['setting_type'] == 'pointssystems') {
                    SystemSetting::where("option_slug", $arrEach['slug'])->update(['option_value' => $arrEach['value']]);
                   

                } 
            }

            toastr()->success($arr[0]['option_update_name'].' details updated successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect('admin/system-settings')->withSuccess($arr[0]['option_update_name']." details updated successfully.");

  
              
            // if ($request->hasFile('value')) {

            //      $validator = Validator::make($request->all(), [
            //         'value' => "required|image|mimes:jpg,png,jpeg,gif,svg|dimensions:min_width=50,min_height=20,max_width=150,max_height=40"],
            //         ['value.image'=>"The Logo should be image type only",
            //         'value.mimes'=>"The Logo extension should be jpg,jpeg,png,gif,svg type only",
            //         //'value.max'=>"The Logo maximum size should be 2MB",
            //         'value.dimensions'=>"The Logo dimensions should be min width:50 and min height:20 and max width:150 and max height:40",
            //          ]
                   
            //        );
            //        if($validator->passes()) {
            //     $i = 0;
            //     foreach ($data['value'] as $getdata) {
            //         if ($data['setting_type'][$i] == 'sitelogo') {
            //             if (!empty($getdata)) {
            //                 $picturename = $getdata->store('public/uploads/sitelogo');
            //                 $picturename = str_replace('public', '', $picturename);
            //                 try {
            //                     SystemSetting::where("option_slug", $data['slug'][$i])->update(['option_value' => $picturename]);
            //                 } catch (\Exception $e) {
            //                     //toastr()->error('Error in logo images save.', 'Error');
            //                     return redirect()->back();
            //                 }
            //             }
            //         }
            //          if ($data['setting_type'][$i] == 'sitefavicon') {
            //             if (!empty($getdata)) {
            //                 $picturename = $getdata->store('public/uploads/sitelogo');
            //                 $picturename = str_replace('public', '', $picturename);
            //                 try {
            //                     SystemSetting::where("option_slug", $data['slug'][$i])->update(['option_value' => $picturename]);
            //                 } catch (\Exception $e) {
            //                     //toastr()->error('Error in logo images save.', 'Error');
            //                     return redirect()->back();
            //                 }
            //             }
            //         }
            //         $i++;
            //     }
            //      toastr()->success('Logo updated successfully.', 'Success');
            //       return redirect('admin/system-settings')->withSuccess("Logo updated successfully.");
            // }else{
            //     toastr()->error('Logo not updated.', 'Success');
            //     $v=implode(',',$validator->errors()->all());
            //     return redirect('admin/system-settings')->with('error',$v);
            // }
            // }else{
            //     toastr()->error('Select Logo Image.', 'Error');
            //     return redirect('admin/system-settings')->withError("Select logo image.");
            // }

           
           
        } catch (\Throwable $th) {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function OptionStatus($slug) {
        $explode = explode('@', $slug);
        if (trim($explode[1]) == 0 || trim($explode[1]) == 1) {
            try {
                SystemSetting::where('setting_type', $explode[0])->update(['status' => $explode[1]]);
                toastr()->success($explode[0].' option status has been updated successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                return redirect('admin/system-settings')->withSuccess($explode[0]." option status has been updated successfully.");
            } catch (\Exception $e) {
                toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
            }
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
