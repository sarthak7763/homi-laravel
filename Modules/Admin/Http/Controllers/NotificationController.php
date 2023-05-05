<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Storage,File,Password};
use App\Password_reset;
use App\Models\{User,Bid,Complaint,Enquiry,Property};
use App\Helpers\Helper;
use Spatie\Permission\Models\{Role,Permission};
use Hash,Auth,Validator,Exception,DataTables,DB,Notification,Session;

class NotificationController extends Controller {

  public function notificationList(){
    $notifications = Auth::user()->notifications;
    $unread_notifications = Auth::user()->unreadNotifications;
    $read_notifications = Auth::user()->readNotifications;
    
    return view('admin::notification',compact('notifications','unread_notifications','read_notifications'));        
  }

  public function markNotification(Request $request){
    Auth::user()->unreadNotifications
        ->when($request->input('id'), function ($query) use ($request) {
            return $query->where('id', $request->input('id'));
        })
        ->markAsRead();
    return response()->noContent();
  }

  public function deleteNotification(){
    DB::table('notifications')->where('notifiable_id',Auth::user()->id)->delete();
    return response()->json(['success'=>'Deleted Successfully']);
  }



 
}