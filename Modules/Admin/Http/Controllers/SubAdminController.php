<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exports\SubAdminExport;
use Maatwebsite\Excel\Facades\Excel;
use Route,Auth,Hash,Validator,Mail,DB;
use App\Models\{User,EmailTemplate,MailAction,MailTemplate};
use App\Jobs\{SendAddBidMailToBidders,SendAddBidSMSToBidders};

class SubAdminController extends Controller {

    public function __construct(User $User) {
        $this->User = $User;
    }

    public function subAdminList(Request $request) {
        try {
            $requestData = $request->all();
            $subadmin = User::role(['sub-admin'])->orderBy('id', 'desc')->where(function ($query) use ($request) {
                        if ($request->has('start_date') && $request->has('end_date')) {
                            $query->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date);
                        }
                    })->where('delete_status',0)->get();
            return view('admin::sub-admins.index', compact('subadmin', 'requestData'));
        } catch (Exception $ex) {
              toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function subAdminAdd() {
        try {
            $permissions = Permission::orderBy("id", "DESC")->get();
            $perArr = [];
            if (!$permissions->isEmpty()) {
                foreach ($permissions as $per) {
                    $perArr[$per->controller][] = ["name" => $per->name,"caption"=>$per->caption, "id" => $per->id];
                }
            }

            return view('admin::sub-admins.create', compact('permissions', 'perArr'));
        } catch (Exception $ex) {
               toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function checkPhoneExist(Request $request){
            $data = $request->all();
        $key=['phone_number' => 'unique:users,mobile_no'];
        $val = [ 'phone_number.unique' => 'Mobile number already exist'];
           $validator = Validator::make($data, $key, $val); 
           if ($validator->fails()) {
              return response()->json(["error" => "1","message"=>$validator->errors()]);
        } else {
            return response()->json(["success" => "1","message"=>""]);
        }
    }

    public function subAdminAddStore(Request $request) {

        $data = $request->all();
        $key = [
            //'username' => 'required|unique:users,username',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
            'mobile_no' => 'required|min:4:mobile_no|unique:users,mobile_no',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required',
            'photo' => 'required|image',
            'contact_code' => 'required',
            'country_code' => 'required',
            'permission_name' => 'required',
             'permission_name.*'  =>'required'
        ];

        $val = [
            //'username.required' => 'Please enter username',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'email.required' => 'Please enter email address',
            'mobile_no.required' => 'Please enter phone number',
            'password.required' => 'Please enter password',
            'password.min' => 'password must be at least 6 characters long',
            'confirm_password.required' => 'Please enter confirm password',
            'photo.required' => 'Please select profile photo',
            'contact_code.required' => 'Please enter phone number',
            'country_code.required' => 'Please enter phone number',
            'permission_name.required' => 'Please select permission',
            'permission_name.*'  => 'Please select permission',
        ];

        $validator = Validator::make($data, $key, $val);

        if ($validator->fails()) {
           // dd($validator->errors());
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            try {
                $picturename="";
                DB::beginTransaction();
                unset($data['_token']);

                $data = $request->all();
                if ($request->hasFile('photo')) {
                    
                    $picturename=uploadImage($request->file('photo'),"public/uploads/user_profile_pic",'');

                }
                
                
                $permissions = Permission::whereIn("id", $data["permission_name"])->get();
                $permission_default = Permission::where("controller","default")->get();

              
                $formatted_number =removeCountryCode($data['contact_code'],$data['mobile_no']);

                
                $subAdmin = [
                    //"username" => @$data['username'],
                    "profile_pic" => $picturename,
                    "name" => @$data['first_name'] . ' ' . @$data['last_name'],
                    "first_name" => @$data['first_name'],
                   "last_name" => @$data['last_name'],
                    "email" => @$data['email'],
                    "mobile_no" => $formatted_number,
                    "country_std_code" => @$data['contact_code'],
                    "country_name" => @$data['country_name'],
                    "country_code" => @$data['country_code'],
                    "password" => Hash::make($data['password']),
                 
                ];

                $UserData = User::create($subAdmin);
                $UserData->assignRole('sub-admin');
                $UserData->givePermissionTo($permissions);
                 $UserData->givePermissionTo($permission_default);

                if (@$UserData->status == "1") {
                 
                    $fullName = @$data['first_name'] . ' ' . @$data['last_name'];
                 
                    $password = @$data['password'];
                  
                }
                
                DB::commit();

                $mailParams=[$UserData->name,
                $data['password'],
                $UserData->email,
                getMobileFormat($UserData->mobile_no)
                ];

                dispatch(new SendAddBidMailToBidders(["add_subadmin",$mailParams,$UserData->email,$UserData->name]));
       


                toastr()->success('Sub-admin added successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                return redirect('admin/sub-admins')->withSuccess("Sub-admin added successfully!");
            } catch (Exception $ex) {
                DB::rollback();
                toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
            }
        }
    }




    public function subAdminView($slug) {
        try {
            $permissions = Permission::orderBy("id", "DESC")->get();
            $perArr = [];
            if (!$permissions->isEmpty()) {
                foreach ($permissions as $per) {
                    $perArr[$per->controller][] = ["name" => $per->name, "id" => $per->id];
                }
            }

            $user = [];
            if ($slug != null) {
                $user = User::role(['sub-admin'])->where('slug', $slug)->first();
            }

            $userPr = [];
            if (isset($user->permissions)) {
                foreach ($user->permissions as $val) {
                    $userPr[$val->controller][] = ["name" => $val->name, "id" => $val->id];
                }
            }


            return view('admin::sub-admins.show', compact('user', 'perArr', 'userPr'));
        } catch (\Exception $e) {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function subAdminStatus(Request $request) {
        $data = $request->all();
        if ($data['status'] == 0 || $data['status'] == 1) {
            try {
                if ($data['status'] == 1) {
                    User::role(['sub-admin'])->where('slug', $data['slug'])->update(['status' => $data['status']]);
                    return json_encode(['status' => 200]);
                } else {
                    User::role(['sub-admin'])->where('slug', $data['slug'])->update(['status' => $data['status']]);
                    return json_encode(['status' => 201]);
                }
            } catch (\Exception $e) {
                return json_encode(['status' => 500]);
            }
        }
    }

    public function subAdminDestroy(Request $request) {
        $data = $request->all();
        if (isset($data['slug'])) {
            try {
                User::role(['sub-admin'])->where('slug', $data['slug'])->delete();
                return json_encode(['status' => 200]);
            } catch (\Exception $e) {
                return json_encode(['status' => 500]);
            }
        } else {
            return json_encode(['status' => 500]);
        }
    }

    public function subAdminEdit($slug) {
        try {
            $permissions = Permission::orderBy("id", "DESC")->get();
            $perArr = [];
            if (!$permissions->isEmpty()) {
                foreach ($permissions as $per) {
                    $perArr[$per->controller][] = ["name" => $per->name,"caption"=>$per->caption, "id" => $per->id];
                }
            }

            $user = [];
            if ($slug != null) {
                $user = User::role(['sub-admin'])->where('slug', $slug)->first();
            }
            $userPr = [];
            if (isset($user->permissions)) {
                foreach ($user->permissions as $val) {
                    $userPr[$val->controller][] = ["name" => $val->name, "id" => $val->id];
                }
            }


            return view('admin::sub-admins.edit', compact('user', 'permissions', 'userPr', 'perArr'));
        } catch (\Exception $e) {
            toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
        }
    }

    public function subAdminUpdate(Request $request) {
        $data = $request->all();
        $user = User::where('slug', $request->slug)->first();

        $validator = Validator::make($data, [
                   // 'username' => 'required|unique:users,username,' . $user->id,
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $user->id.'|regex:/(.+)@(.+)\.(.+)/i',
                    'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:4:mobile_no|unique:users,mobile_no,' . @$user->id,
                   
                    'contact_code' => 'required',
                    'country_code' => 'required',
                    'permission_name' => 'required',
                    'permission_name.*' => 'required',
                        ], [
                    //'username.required' => 'Please enter username',
                    'first_name.required' => 'Please enter first name',
                    'last_name.required' => 'Please enter last name',
                    'status.required' => 'Please select status',
                    'email.required' => 'Please enter email address',
                    'mobile_no.required' => 'Please enter phone number',
                    'contact_code.required' => 'Please select country',
                    'country_code.required' => 'Please select country',
                    'permission_name.*' => 'Please select permission',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            try {
                DB::beginTransaction();

                DB::table('model_has_permissions')->where('model_id', $data['user_id'])->delete();

                unset($data['_token']);

                $userData = [];

                 //Upload User Image
                   $user=User::where('id',$data['user_id'])->first();
      $old_img=$user->getRawOriginal('profile_pic');
    
      if($request->hasFile('photo')){
        $data['profile_pic']=uploadImage($request->file('photo'),"public/uploads/user_profile_pic",$old_img);
        Storage::disk('local')->delete('public/uploads/user_profile_pic/'.$old_img);
      }
      else
      {
        $data['profile_pic'] = $user->getRawOriginal('profile_pic');
      }

            
                $formatted_number =removeCountryCode($data['contact_code'],$data['mobile_no']);


                $subAdmin = [
                    //"username" => @$data['username'],
                    "profile_pic" => $data['profile_pic'],
                    "name" => @$data['first_name'] . ' ' . @$data['last_name'],
                    "first_name" => @$data['first_name'],
                    "last_name" => @$data['last_name'],
                    "email" => @$data['email'],
                    "mobile_no" =>$formatted_number,
                    "country_std_code" => @$data['contact_code'],
                    "country_name" => @$data['country_name'],
                    "country_code" => @$data['country_code']
                  
                ];

                $UserData = User::role(['sub-admin'])->where('slug', $request->slug)->update($subAdmin);

                $user = User::role(['sub-admin'])->where('slug', $request->slug)->first();
              
                $permissions = Permission::whereIn("id", $data["permission_name"])->get();
                $permission_default = Permission::where("controller","default")->get();


                $user->givePermissionTo($permissions);
                $user->givePermissionTo($permission_default);

                DB::commit();

                toastr()->success('Subadmin details has been updated successfully.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                return redirect('admin/sub-admins')->withSuccess("Subadmin details has been updated successfully.");
            } catch (Exception $ex) {
                DB::rollback();
                toastr()->error('Either something went wrong or invalid access!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                return redirect()->back()->with('errors', "Either something went wrong or invalid access!");
            }
        }
    }

    public function subAdminChangePass(Request $request) {
        $data = $request->all();

         request()->validate([
        'password' => 'required|min:7|same:confirm_password|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@%&_]).*$/',
        'confirm_password' => 'required|same:password'
      ]);   
      
      $user=User::where('slug', $request->slug)->first();
      $password= Hash::make($data['password']);
      $userData = ["password"=>$password]; 
      User::where('id',$data['id'])->update($userData);
      toastr()->success('Sub-admin password updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      return redirect()->route('admin-sub-admins')->with('success','Sub-admin password updated successfully');
    }

}
