<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Storage,File,Password};
use Illuminate\Support\Arr;
use Illuminate\Mail\Message;
use App\Helpers\Helper;
use App\Models\Contactenquiry;
use App\Models\User;
use Spatie\Permission\Models\{Role,Permission};
use PDF;


use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;


class EnquiryController extends Controller{
 
 
 public function index(Request $request) {
    try{ 
      if($request->ajax()) {   
        $data =  Contactenquiry::latest();
        return Datatables::of($data)
          ->addIndexColumn()
            ->addColumn('name', function($row){
                return $row->name;
            }) 
             ->addColumn('email', function($row){
                return $row->email;
            })
          ->addColumn('status', function($row){
              $status = $row->status;
              if($status==1){
                  $booking_status_html='<span class="badge badge-success badge_enquiry_status_change" style="cursor: pointer;" id="'.$row->id.'">Resolved</span>';
              }elseif($status==0){
                   $booking_status_html='<span class="badge badge-danger badge_enquiry_status_change" style="cursor: pointer;" id="'.$row->id.'">Unresolved</span>';
              }else {
                 $booking_status_html='<span class="badge badge-danger" id="'.$row->id.'">N.A.</span>';
              }
              return $booking_status_html;
          }) 
          ->addColumn('created_at', function ($data) {
              $created_date=date('d M, Y g:i A', strtotime($data->created_at));
              return $created_date;   
          })
          ->addColumn('action__', function($row){
              $route_view=route('admin-enquiry-details',$row->id);
              $action='<a href="'.$route_view.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';
              return $action;
          })  
            ->make(true);
          }  

      return view('admin::enquiry.index');  
    }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function updateEnquiryStatus(Request $request){
    try{
      $data=$request->all();
      if(!array_key_exists("id",$data))
      {
        return redirect('admin/enquiry-list/')->with('error','Something went wrong.');
      }

      $contactenquiry=Contactenquiry::where('id', $request->id)->first();
      if($contactenquiry->status == 1){
        $updatedata = [ "status"=>0];
        Contactenquiry::where('id', $request->id)->update($updatedata);
        $status=1;
      }else if($contactenquiry->status == 0){
        $updatedata = [ "status"=>1];
        Contactenquiry::where('id', $request->id)->update($updatedata);
        $status=1;
      }else{
        $status=0;
      }
        return response()->json(["success" => $status]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function show($id){
    try{
      $enquiryinfo =Contactenquiry::where('id',$id)->first();
      return view('admin::enquiry.show', compact('enquiryinfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
   
  public function deleteInquiry(Request $request){
    try{
      $data = ["status"=>2];
      $catInfo=Category::where('id', $request->id)->first();  
      Category::where('id', $request->id)->update($data);  
     
      toastr()->success('Buyer deleted successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function showinvoice($id)
  {
  	try{
      $bookinginfo =Userbooking::where('id',$id)->first();
      $property_id=$bookinginfo->property_id;
      $checkproperty=Property::where('id',$property_id)->get()->first();
      if($checkproperty)
      {
        $property_title=$checkproperty->title;
        $owner_id=$checkproperty->add_by;
        $checkuser=User::where('id',$owner_id)->where('user_type',3)->get()->first();
        if($checkuser)
        {
          $owner_name=$checkuser->name;
          $owner_email=$checkuser->email;
          $owner_number=$checkuser->mobile;
        }
        else{
          $owner_name="N.A.";
          $owner_email="N.A.";
          $owner_number="N.A.";
        }
      }
      else{
        $property_title="N.A.";
        $owner_name="N.A.";
        $owner_email="N.A.";
        $owner_number="N.A.";
      }

      $contactinfodata=gethomicontactinformation(); 

      $bookingdata = [
            'contact_address'=>$contactinfodata['homi-contact-address'],
            'contact_email'=>$contactinfodata['homi-contact-email'],
            'contact_number'=>$contactinfodata['homi-contact-number'],
            'property_title' => $property_title,
            'invoice_id'=>$bookinginfo->invoice_id,
            'booking_id'=>$bookinginfo->booking_id,
            'booking_date'=>date('d M,Y',strtotime($bookinginfo->created_at)),
            'user_name'=>$bookinginfo->user_name,
            'user_email'=>$bookinginfo->user_email,
            'user_number'=>$bookinginfo->user_number,
            'user_address'=>'4068 Post Avenue Newfolden, MN 56738',
            'owner_name'=>$owner_name,
            'owner_email'=>$owner_email,
            'owner_number'=>$owner_number,
            'owner_address'=>'4068 Post Avenue Newfolden, MN 56738',
            'check_in_date'=>date('d M,Y',strtotime($bookinginfo->user_checkin_date)),
            'check_out_date'=>date('d M,Y',strtotime($bookinginfo->user_checkout_date)),
            'adults_count'=>$bookinginfo->user_adult_count,
            'children_count'=>$bookinginfo->user_children_count,
            'subtotal_price'=>$bookinginfo->booking_property_price,
            'tax_price'=>$bookinginfo->booking_tax_price,
            'total_price'=>$bookinginfo->booking_price
        ];

        $data=array_merge($contactinfodata,$bookingdata);

      	$pdf = PDF::loadView('booking_invoice', $data);
      	//$pdf->setPaper('a4', 'landscape');
   		return $pdf->stream();
    }
    catch(Exception $e){
      return redirect()->back()->with('error', $e->getMessage());            
    }
  }

}