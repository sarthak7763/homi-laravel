<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use App\Models\{User,Property,FavProperty};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,HasRoles,Auth;

class FavPropertyController extends Controller{	
  public function deleteFavProperty(Request $request){
    try{
      FavProperty::where('id', $request->id)->delete();  
      return json_encode(['status' => 200]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }  
}
