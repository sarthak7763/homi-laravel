<?php 
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request,Response};
use App\Models\{Permissiondata,User};
use App\Helpers\Helper;
use Spatie\Permission\Models\{Role,Permission};
use Auth,Validator,Exception,DataTables,DB,Toastr;
class PermissionController extends Controller
{
   
    function __construct()
    {
         // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         // $this->middleware('permission:role-create', ['only' => ['create','store']]);
         // $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {   
        try {
        $permissions = Permissiondata::orderBy('id','DESC')->get();
        }catch (\Throwable $th) {
            return redirect()->back()->with("error","Something Went Wrong");
             }
        return view('admin::permission.index',compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        
    }

    public function create()
    {   
        try {
        $permissions = Role::pluck('name','name')->all();
        }catch (\Throwable $th) {
        return redirect()->back()->with("error","Something Went Wrong");
         }
        return view('admin::permission.create',compact('permissions'));
    }

    public function store(Request $request)
    {   
        
        request()->validate([
            'name' => 'required|unique:permissions',
        ]);
       // try {
            $permission = new Permissiondata();
            $permission->name=$request->name;
            $permission->guard_name=$request->guard_name;
            $permission->controller=$request->controller;
            $permission->caption=$request->caption;
            $permission->save();
            

       // Permissiondata::create($request->all());
        // }catch (\Throwable $th) {
        //     return redirect()->back()->with("error","Something Went Wrong");
        //      }
        return redirect()->route('admin-add-permission')
                        ->with('success','Permission created successfully.');
    }

    public function show($id)
    {
        try {
        $permissions =Permissiondata::find($id);
        $resourcePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
          ->where("role_has_permissions.role_id",$id)
          ->get();
        }catch(Throwable $e){
            report(e);
            return false;
            return redirect()->back()->with("error");
        }
        return view('admin::permission.show',compact('permissions','resourcePermissions'));
    }
    
   
    public function edit($id)
    {   try{
      $permissions = Permissiondata::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
      }catch (\Throwable $th) {
        return redirect()->back()->with("error","Something went wrong");
       }
        return view('admin::permission.edit',compact('permissions','permission','rolePermissions'));
    }

  
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions',
        ]);
        try{
        $permission = Permissiondata::find($id);
        $permission->name = $request->input('name');
        $permission->save();
        }catch (\Throwable $th) {
            return redirect()->back()->with("error","Something went wrong");
           }
        return redirect()->route('admin-permission-list')
                        ->with('success','Permission updated successfully');
    }

    public function destroy($id)
    {   
         try{
        Permission::find($id)->delete();
         }catch (\Throwable $th) {
            return redirect()->back()->with("error","Something went wrong");
           }
         return redirect()->route('admin-permission-list')
                        ->with('success','Permission deleted successfully'); 
    }
}
