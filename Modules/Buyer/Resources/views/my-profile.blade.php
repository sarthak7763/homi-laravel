@extends('buyer::layouts.master')
@section('content')
<style>
    .mt-40 {
    margin-top: -40px;
}

.user-box.profilepics-icon img {
    height: 100%;
    object-fit: cover;
    object-position: center center;
}
.user-box {
    border: 1px solid #7591a3;
    padding: 5px;
    

    
}

.display-block {
    display: block;
}


.display-none {
    display: none;
}  
</style>
<div class="col-md-8 col-lg-9 mt-4">  
<div class="profile-box border px-4 mt-3">
     <div class="row">
               <div class="col-12 text-center">
                  <div class="user-box overflow-visible position-relative profilepics-icon mb-0 mt-40">
                    @if($userInfo->profile_pic)
                           <img class="rounded-pill profilepics" src="{{url('/')}}/images/user/{{$userInfo->profile_pic}}">
                           @else
                           
                           <img class="rounded-pill profilepics" src="{{url('/')}}/images/user-img.png"> 
                           @endif   
                     
                    <div class="useravtarIcon">
                        <input type="file" id="myFile" class="opacity-0 position-absolute bottom-0" name="filename">
                        
                     </div>
                  </div>
               </div>
            </div>
    <div class="profile-box-form">
        <h1 class="mb-3">My Profile</h1>
        <div>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
       
  
    <div class="ox-auto uinfo-table">
       
<table class="table-responsive table-striped table w-100 table-bordered" id="sellerinfo">
<thead>
    <tr>
        <th colspan="2">Owner Information</th>
    </tr>
</thead>
<tbody>
    <tr>
        
        <td><strong>Owner Name : </strong> 
            @if(!empty($userInfo->name))
            <span> {{$userInfo->name}}</span>
            @else
            <span> 
            {{'NA'}}</span>
            @endif

        </td>
        <td><strong>Owner Email Id : </strong> 
        @if(!empty($userInfo->email))
            <span> {{$userInfo->email}}</span>
            @else
            <span> 
            {{'NA'}}</span>
            @endif
    
    </td>
    </tr>
    <tr>
        <td><strong>Contact No. : </strong>
        @if(!empty($userInfo->mobile))
            <span> {{$userInfo->mobile}}</span>
            @else
            <span> 
            {{'NA'}}</span>
            @endif
    
    </td>
        <td><strong>Registration Date : </strong> 
        @if(!empty($userInfo->created_at))
            <span>{{date('d M , Y',strtotime($userInfo->created_at))}}</span>
            @else
            <span> 
            {{'NA'}}</span>
            @endif
    </td>

    </tr>

 <tr>
    @if($userInfo->owner_type == 1)    
        <td><strong>Owner Type : </strong> </span>Agency</span> </td> <td><strong>Agency Name : </strong>
        <span> {{$userInfo->agency_name}}</span></td>
    @elseif($userInfo->owner_type == 2)
        <td colspan="2"><strong>Owner Type : </strong>Individual</td>
        @else
        <td colspan="2"><strong>Owner Type : </strong>NA
     </td>

    @endif

    </tr> 
</tbody>
</table>
</div>
</div>
    </div>
</div>

@endsection



