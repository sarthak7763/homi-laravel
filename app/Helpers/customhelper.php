<?php 
use App\Models\{User,IntrestedCity,SystemSetting,CmsPage,Property,FavProperty,Userbooking,Category,UserSubscription};
use Auth as Auth;
use Illuminate\Support\Facades\Session;


function getMobileFormat($mobile_num){
    if($mobile_num!=""){
        $data = "+1".$mobile_num;
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $data,  $matches ) )
        {
            $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
            return '1-'.$result;
        } else{
            return $mobile_num;
        }
    }else{
        return 0;
    }
}

function removeCountryCode($country_code,$phone_no){
    if($phone_no!="" && $country_code != ""){
        $formatted_number = preg_replace("/^\+?{$country_code}/", '',$phone_no);
        return preg_replace("/[^0-9]/","",$formatted_number);
    }
    else{
        return 0;
    }
}

function numberPlaceFormat($number){
     if($number!="" && $number>0){
        return number_format($number);
    }else{
        return $number;
    }
}

function moneyFormat($number){
    if($number!="" && $number>0){
        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $with_decimal_point= $formatter->formatCurrency($number, 'USD');
        $number_price=substr($with_decimal_point,0,-3);
        return $number_price;
        //  $result=money_format($number,'1');
        // $num = explode(".",$number);
        // $num[0] = implode(",", str_split(strrev($num[0]), 3));
        // $num = strrev($num[0]);

        // $ar = str_split($number, 3);
        //     $result = implode(',', $ar);

        // return $result; 
        //$f = new NumberFormatter("de_DE", NumberFormatter::CURRENCY);
        //return $f->formatCurrency($number,'CAD'); // Outputs "$12,345.00"
        //return number_format($number,0, '.', ',');
    }else if($number < 0){
        $number=abs($number);
        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $with_decimal_point= $formatter->formatCurrency($number, 'USD');
        $number_price=substr($with_decimal_point,0,-3);
        return "-".$number_price;
    }
    else{
        return $number;
    }
}

function getNotification(){
    $notifications = @Auth::user()->unreadNotifications;
    $notifications_count = @Auth::user()->unreadNotifications->count();
    
    return ["unread_notification"=>$notifications,"count_unread_notification"=>$notifications_count];
}

function sendPushNotification($title,$description,$registrationIds,$payload,$device_type,$countUnreadNotif) {
    $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
    $headers = [
        'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];
    if($device_type=="Android"){
        $notification = ["body" => $description,
                    "title" => $title,
                    "payload"=>$payload,
                    "vibrate" => 1,
                    "sound" => 1,
                    "badge" => 1,
                    "color" => "#3364ac",
                    "type" => 'default'
        ];
    
        if($registrationIds!="") {
            $fields = ["registration_ids" => $registrationIds,
                        "priority" => "high",
                        "data" => $notification,
                        "type" => 'default'
            ];
        }
    }else{
        $notification = ["body" => $description,
                    "title" => $title,
                    "payload"=>$payload,
                    "vibrate" => 1,
                    "sound" => 1,
                    "badge" => $countUnreadNotif,
                    "content_available" => true,
                    "color" => "#3364ac",
                    "type" => 'default'
        ];
    
        if($registrationIds!="") {
            $fields = ["registration_ids" => $registrationIds,
                        "priority" => "high",
                        "notification" => $notification,
                        "data" => $notification,
                        "type" => 'default'
            ];
        }
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    return $result = curl_exec($ch);
    // dump($result);
    // if (curl_error($ch)) { return curl_error($ch);}
    //curl_close($ch);
    //dd($result);
}
/*-----------UPLOAD NEW IMAGE AND DELETE OLD IMAGE---------*/
    function uploadImage($image_file,$image_path,$old_image=null){
        $fileNameExt = $image_file->getClientOriginalName();
        $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
        $fileExt = $image_file->getClientOriginalExtension();
        //$fileNameToStore = $fileName.'_'.time().'.'.$fileExt;


        $fileNameToStore = time().'-'.Str::of(md5(time().$fileName))->substr(0, 50).'.'.$fileExt;




        $pathToStore = $image_file->move($image_path,$fileNameToStore);
        if(isset($old_image) && $old_image !=''){
            if(File::exists(public_path($image_path.'/').$old_image)){
                unlink(public_path($image_path.'/'.$old_image));
            }
        }
        // Image name to save into table column    
        return  $fileNameToStore;
    }
/*-----------UPLOAD NEW IMAGE AND DELETE OLD IMAGE---------*/
    function uploadMultipleImage($image_file=[],$image_path){
        $return_file_name=[];
        if(isset($image_file) && !empty($image_file)){
            $allowedfileExtension=['jpg','jpeg','png'];
            $files = $image_file;
            foreach($files as $file){
                $fileNameExt = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
                $fileExt = $file->getClientOriginalExtension();
               // $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
                $fileNameToStore = time().'-'.Str::of(md5(time().$fileName))->substr(0, 50).'.'.$fileExt;

                $pathToStore = $file->storeAs($image_path,$fileNameToStore);
                $check=in_array($fileExt,$allowedfileExtension);
                $return_file_name[]=$fileNameToStore;
                $flag=0;
                if($check){
                    $file->store('public/uploads/Banner');
                    $flag=1;   
                } 
                if($flag==0){
                    break;
                }
            }   
        } 
        return $return_file_name; 
    }

    function getProfilePic()
    {
       if (Auth::user()) {  
            $pic=User::select('profile_pic')->where([['id',@Auth::user()->id]])->first();
            return $pic->profile_pic; 
        }
        
    }

     function getAdminInfo()
    {
        $adminInfo=User::where('id',1)->first();
        return $adminInfo;
    }

    function getSellerinfo($id)
    {
        $sellerInfo=User::where('id',$id)->where('user_type',3)->get()->first();
        return $sellerInfo;
    }

    function getLogo()
    {
        $logo=SystemSetting::where([['option_slug','website-logo'],['setting_type','sitelogo'],['status',1]])->first();
        return $logo->option_value;
    }

    function getFavicon()
    {
        $favicon=SystemSetting::where([['option_slug','website-fev-icon'],['setting_type','sitefavicon'],['status',1]])->first();
        return $favicon->option_value;
    }

    function getbookingtaxprice()
    {
        $taxprice=SystemSetting::where([['option_slug','booking-tax'],['setting_type','siteappsettings'],['status',1]])->first();
        return $taxprice->option_value;
    }

    function getdistanceradiusvalue()
    {
        $radiusvalue=SystemSetting::where([['option_slug','distance-radius'],['setting_type','siteappsettings'],['status',1]])->first();
        return $radiusvalue->option_value;
    }

    function getFooterSocialLink()
    {
        $socialLinkData=SystemSetting::where([['setting_type','footersocialmedia'],['status',1]])->get();
        foreach($socialLinkData as $li){
            $data[]=$li->option_value;
        }
        return $data;
    }

    function gethomicontactinformation()
    {
        $contactinfoData=SystemSetting::where([['setting_type','homicontactinfo'],['status',1]])->get();
        foreach($contactinfoData as $li){
            $data[$li->option_slug]=$li->option_value;
        }
        return $data;
    }

    function getFooterCmsPageMenu(){
        $cms=CmsPage::select('page_name','page_slug')->where('status',1)->get()->toArray();
        return $cms; 

    }

     function getFAQPageLink(){
        
        $faq=CmsPage::select('page_name','page_slug')->where('status',1)->where('page_slug','faq')->first();
        if(isset($faq) && !empty($faq)){
            return $faq; 
        }else{
            return 0;
        }
      }

    /////////////////////////////////////////////////////////
 function error_500(){
        return response()->json([
            'code' => 500,
            'response' => 'error',
            'message' => __('Something went wrong, please contact admin'),
            'data'=> new \stdClass() 
        ],500);
    }
    
    function error_204(){
        /* no data */
        return response()->noContent();
    }

    function custom_error($code, $msg, $dumy_data=false){
        if($dumy_data!=false){
            $info = $dumy_data;
            array_walk_recursive($info , function(&$item) {
                $item = strval($item);
            });
        }else{
            $info = new \stdClass();
        }
        return response()->json([
            'code' => $code,
            'response' => 'success',
            'message' => $msg,
            'data'=> $info
        ],$code);
    }
    
    function validation_error($message){
        return response()->json([
            "message" => $message[0],
            "code" => 400,
            "error" => $message,
            "response" => 'success'
        ], 400);
    }

    function success($response=false, $msg=false, $code=false, $my_key = ""){
        if(!$msg){
            $msg = __('Success');
        }
        if(!$code){
            $code = 200;
        }
        
        // its will remove all the null and integer values to string
        if(!$response == false){
            if(gettype($response)!="array"){
                $response = $response->toArray();
            }
            array_walk_recursive($response, function(&$item) {
                $item = strval($item);
            });
        }else{
            $response = [];
        }
        $res_data = [
            "code"=> $code, 
            "response" => $msg,
            "message"=> $msg,
          
        ];

        if($my_key == ""){
            $res_data['data'] =  $response;
        } else {
            $res_data[$my_key] = $response;
        }
        return response()->json($res_data, $code);
    }


    function getdaysdiff($check_in_date,$check_out_date)
    {
        $earlier = new DateTime($check_in_date);
        $later = new DateTime($check_out_date);

        $abs_diff = $later->diff($earlier)->format("%a"); //3
        return $abs_diff;
    }

    function checkfavproperty($userid,$propertyid)
    {
        $checkproperty=Property::where('id',$propertyid)->where('property_status',1)->get()->first();
        if($checkproperty)
        {
            $checkpropertywishlist=FavProperty::where('property_id',$propertyid)->where('buyer_id',$userid)->get()->first();
            if($checkpropertywishlist)
            {
                $favourite=1;
            }
            else{
                $favourite=0;
            }
        }
        else{
            $favourite=0;
        }

        return $favourite;
    }

    function removeElementWithValue($array, $key, $value){
        $finalarray=[];
     foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
               unset($array[$subKey]);
          }
          else{
            $finalarray[]=$subArray;
          }
     }

     return $finalarray;
}

function removeElementWithKey($mainArray,$searchkey)
{
    $finalarray=[];
    foreach ($mainArray as $key => $mainData){

        if(isset($mainData[$searchkey])){
            $finalarray[] = array_except($mainData, [$searchkey]);
        }
        else{
            $finalarray[]=$mainData;
        } 
     }

     return $finalarray;
}

function array_except($array, $keys) {
  return array_diff_key($array, array_flip((array) $keys));   
} 

function AddElementtoarray($mainArray,$searchkey,$searchvalue)
{
    foreach ($mainArray as $key => $mainData){
        $mainArray[$key][$searchkey] = $searchvalue;
     }
     
    return $mainArray;

}

function generatebookingid()
{
    $currentdate=date('Y-m-d');
    $lastiddata=Userbooking::orderBy('id','DESC')->get()->first();
    if($lastiddata)
    {
        $lastbookingid=$lastiddata->id;
        $finalbookingid=$lastbookingid+1;
        $newbookingid=str_pad($finalbookingid,4,"0",STR_PAD_LEFT);
    }
    else{
        $newbookingid=0001;
    }

    $generatebookingid='HM'.date('dmy',strtotime($currentdate)).'-'.$newbookingid;
    return $generatebookingid;
}

function generateinvoiceid()
{

    if (date('m') >= 4) {
        $financial_year = date('Y') + 1;
    } else {
        $financial_year = date('Y');
    }

    $lastiddata=Userbooking::orderBy('id','DESC')->get()->first();
    if($lastiddata)
    {
        $lastbookingid=$lastiddata->id;
        $finalbookingid=$lastbookingid+1;
        $newbookingid=str_pad($finalbookingid,4,"0",STR_PAD_LEFT);
    }
    else{
        $newbookingid=0001;
    }

    $generateinvoiceid='HOMI'.$financial_year.'UI'.$newbookingid;
    return $generateinvoiceid;
}

function getcountrylist()
{
  $countrylist=DB::table('countries')->get();
  if($countrylist)
  {
    $countrylistarray=$countrylist->toArray();
    $country_list=[];
    foreach($countrylistarray as $list)
    {
      $country_list[]=$list->phonecode;
    }
  }
  else{
    $country_list=[];
  }

    $country_list=array_unique($country_list);

    return $country_list;
}

function getcountrycode($countryid)
{
    $countrydet=DB::table('countries')->where('id',$countryid)->get()->first();
    if($countrydet)
    {
        $country_code=$countrydet->phonecode;
    }
    else{
        $country_code="";
    }

    return $country_code;
}

function getpropertydetbylang($lang,$id)
{
    $propertydet=Property::where('id',$id)->get()->first();
    if($propertydet)
    {
        if($lang=="en")
        {
            $property_array=array(
                'title'=>$propertydet->title,
                'description'=>$propertydet->property_description
            );
        }
        else{
            if($propertydet->title_pt!="")
            {
                $property_title=$propertydet->title_pt;
            }
            else{
                $property_title=$propertydet->title;
            }

            if($propertydet->property_description_pt!="")
            {
                $property_description=$propertydet->property_description_pt;
            }
            else{
                $property_description=$propertydet->property_description;
            }

            $property_array=array(
                'title'=>$property_title,
                'description'=>$property_description
            );
        }
    }
    else{
        $property_array=[];
    }

    return $property_array;

}


function getcategorynamebylang($lang,$id)
{
    $categorydet=Category::where('id',$id)->get()->first();
    if($categorydet)
    {
        if($lang=="en")
        {
            $category_name=$categorydet->name;
        }
        else{
            if($categorydet->name_pt!="")
            {
                $category_name=$categorydet->name_pt;
            }
            else{
                $category_name=$categorydet->name;
            }
        }
    }
    else{
        $category_name="";
    }

    return $category_name;

}

function getconditionnamebylang($lang,$id)
{
    $conditiondet=DB::table('property_condition')->where('id',$id)->get()->first();
    if($conditiondet)
    {
        if($lang=="en")
        {
            $condition_name=$conditiondet->name;
        }
        else{
            if($conditiondet->name_pt!="")
            {
                $condition_name=$conditiondet->name_pt;
            }
            else{
                $condition_name=$conditiondet->name;
            }
        }
    }
    else{
        $condition_name="";
    }

    return $condition_name;

}



 function sellermoduleaccess(){
    $user_id = Auth::User()->id;

    $current_date  = date('Y-m-d');
    
    $check_subscription = UserSubscription::where('user_id',$user_id)->where('subscription_status',1);
    
    $check_subscription_expire_time = $check_subscription->where("user_subscriptions.starting_date",'<=',$current_date)
                                                        ->where("user_subscriptions.ending_date",'>=',$current_date)
                                                        ->first();

            if($check_subscription_expire_time){ 
                    return 'true';
            }
            else{
                    return 'false';
            }
}



function getemailtemplate($template_id,$email,$username,$otp="",$sellername="",$selleremail="",$property_title="",$property_type="",$property_price="",$property_address="",$property_image_link="",$subscription_plan_name="",$subscription_plan_price="",$fund_amount="",$fund_screenshot="",$user_password="")
  {
    try
            {
                $emailcontentdata=DB::table('email_templates')->where('id',$template_id)->get()->first();
                if($emailcontentdata)
                {
                    $email_content=$emailcontentdata->message;
                    $email_subject=$emailcontentdata->subject;
            
                $variablesarray=array('[email]','[user]','[otp]','[contactname]','[contactinformation]','[contactinformationlink]','[contactsite]','[contactsitelink]','[sellername]','[selleremail]','[property_title]','[property_type]','[property_price]','[property_address]','[property_image_link]','[subscription_plan_name]','[subscription_plan_price]','[fund_amount]','[fund_screenshot]','[password]');
            
                $variablesvaluesarray=array($email,$username,$otp,'Homi Team','info@homi.com','mailto:info@homi.com','www.homi.com','https://www.homi.com',$sellername,$selleremail,$property_title,$property_type,$property_price,$property_address,$property_image_link,$subscription_plan_name,$subscription_plan_price,$fund_amount,$fund_screenshot,$user_password);
            
                $email_content=str_replace($variablesarray,$variablesvaluesarray,$email_content);
                $email_subject=str_replace($variablesarray,$variablesvaluesarray,$email_subject);
                $email_subject=str_replace('&nbsp;','',$email_subject);
                $email_subject=strip_tags($email_subject);
            
                $details['email_content']=$email_content;
                $details['email_subject']=$email_subject;
                // dd($email);
            
                \Mail::to($email)->send(new \App\Mail\EmailMasterMailTemplate($details));
            
            }
        }
        
        catch (\Exception $e){
        dd($e);
        }

   
  }


   
?>
