@extends('buyer::layouts.master')
@section('content')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-8 col-lg-9">
   <div class="profile-box">
      <div class="profile-box-form">
         <h1 class="mb-3">Edit Profile</h1>
        
    <div>
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
         <form class="profile-form " method = "Post" enctype = "multipart/form-data" action = "{{route('buyer.update-profile')}}">
            @csrf 
            <div class="user-box-img">
               <div class="row">
                  <div class="col-12 text-center">
                     <div class="user-box overflow-visible position-relative mb-1">    
                        <div class="useravtaricon">
                           <div class=" user-box2-img">
                           @if($userInfo->profile_pic)
                           <img id="profile_pic_preview" class="rounded-pill-box" src="{{url('/')}}/images/user/{{$userInfo->profile_pic}}">
                           @else
                           <img id="profile_pic_preview" class="rounded-pill-box" src="{{url('/')}}/images/user-img.png">
                           @endif    
                            </div>
                           <input type="file"  class="opacity-0 position-absolute bottom-0" name="profile_pic" id="profile_pic">
                           <label for="my-profile_pic" class="avtar_user d-flex align-items-center justify-content-center rounded-pill position-absolute bottom-0 bg-white">                            
                              <svg width="18" height="16" viewBox="0 0 18 16" fill="none" >
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 5.25002C0.75 4.2375 1.57081 3.41669 2.58333 3.41669H3.43549C4.04848 3.41669 4.6209 3.11034 4.96092 2.6003L5.70575 1.48307C6.04577 0.973037 6.61819 0.666687 7.2312 0.666687H10.7688C11.3818 0.666687 11.9542 0.973037 12.2942 1.48307L13.0391 2.6003C13.3791 3.11034 13.9516 3.41669 14.5645 3.41669H15.4167C16.4292 3.41669 17.25 4.2375 17.25 5.25002V13.5C17.25 14.5126 16.4292 15.3334 15.4167 15.3334H2.58333C1.57081 15.3334 0.75 14.5126 0.75 13.5V5.25002Z" stroke="#4A5568" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M11.75 8.91669C11.75 10.4355 10.5188 11.6667 9 11.6667C7.48117 11.6667 6.25 10.4355 6.25 8.91669C6.25 7.39786 7.48117 6.16669 9 6.16669C10.5188 6.16669 11.75 7.39786 11.75 8.91669Z" stroke="#4A5568" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                            </label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                  <label class="mt-3 font-weight-bold mb-2">Owner Name</label>
                  </div>
                  <div class="col-12 col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror"  aria-describedby="" name="name"   value="{{$userInfo->name}}" placeholder="Please Enter Owner Name">
                        @if($errors->has('name'))
                        <div class="invalid-feedback">
                           {{$errors->first('name')}}
                        </div>
                        @endif
                     </div>
                  </div>
                 <div class="col-12 col-sm-6">
                     <div class="mb-4"> 
                        <input type="text" class="form-control @error('email') is-invalid @enderror"  aria-describedby="" name="email" readonly  value="{{$userInfo->email}}" placeholder="Please Enter Email">   
                     </div>
                     @if($errors->has('email'))
                     <div class="invalid-feedback">
                        {{$errors->first('email')}}
                     </div>
                     @endif
                  </div>
             
                  <div class="col-12" >
                     <input type="text" class="form-control @error('mobile') is-invalid @enderror"  aria-describedby="" name="mobile"  value="{{$userInfo->mobile}}" placeholder="Please Enter Mobile No">   
                  </div>
                  @error('mobile')
                  <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror
                  <div class="col-sm-12 pt-2">
                     <label class="mt-3 font-weight-bold mb-2">Owner Type</label>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group mb-4">                        
                       <select class="form-select form-control @error('owner_type') is-invalid @enderror" name ="owner_type"   aria-label="Default select example" id="owner_type" >

                        @php 
                          $ownertypeindselected="";
                          $ownertypeagencyselected=""; 
                        @endphp

                          @if($userInfo->owner_type == 1 && old('owner_type') == 1 )
                            @php 
                              $ownertypeagencyselected="selected"; 
                              $ownertypeindselected=""; 
                            @endphp 
                            @elseif($userInfo->owner_type == 1 && old('owner_type') == 2 )
                            @php 
                              $ownertypeindselected="selected"; 
                              $ownertypeagencyselected=""; 
                            @endphp 
                            @elseif($userInfo->owner_type == 1 && old('owner_type')=="")
                            @php 
                              $ownertypeagencyselected="selected"; 
                              $ownertypeindselected=""; 
                            @endphp  
                          @endif

                          @if($userInfo->owner_type == 2 && old('owner_type') == 2 )
                            @php 
                              $ownertypeindselected="selected"; 
                              $ownertypeagencyselected="";
                            @endphp 
                          @elseif($userInfo->owner_type == 2 && old('owner_type') == 1 )
                            @php 
                              $ownertypeagencyselected="selected"; 
                              $ownertypeindselected="";
                            @endphp 
                          @elseif($userInfo->owner_type == 2 && old('owner_type')=="")
                            @php 
                              $ownertypeindselected="selected";
                              $ownertypeagencyselected=""; 
                            @endphp 
                          @endif
                           <option value=""> Select owner type</option>
                            <option value="1" {{$ownertypeagencyselected}}>Agency</option>
                           <option value="2" {{$ownertypeindselected}}>Indiviuals</option>   
                        </select>
                         @if($errors->has('owner_type'))
                        <div class="invalid-feedback">
                           {{$errors->first('owner_type')}}
                        </div>
                        @endif           
                     </div>
                  </div>
                  @if($userInfo->owner_type == 1 || old('owner_type') == 1 )
                  <div class="col-sm-6" id="showagencydiv" style="display:block;">
                     <div class="form-group mb-4" >
                     <input type="text" class="form-control @error('agency_name') is-invalid @enderror" placeholder="Agency Name" id="agency_name" name="agency_name" id="agency_name" value="{{$userInfo->agency_name}}">
                     @if($errors->has('agency_name'))
                     <div class="invalid-feedback">
                        {{$errors->first('agency_name')}}
                     </div>
                     @endif
                  </div>
                  </div>
                  @else
                  <div class="col-sm-6" id="showagencydiv" style="display:none;">
                     <div class="form-group mb-4">
                        <input type="text" class="form-control @error('agency_name') is-invalid @enderror" name="agency_name" id="agency_name" value = "{{$userInfo->agency_name}}">
                        @if($errors->has('agency_name'))
                     <div class="invalid-feedback">
                        {{$errors->first('agency_name')}}
                     </div>
                     @endif
                     </div>
                     </div>
                  @endif
               </div>
               <div class="d-flex align-items-center gap-3 justify-content-center pb-4">
               <button type="submit"  class="mt-3 btn btn-primary mx-0" data-toggle="modal" data-target="#exampleModal">Update</button>
            </div>
         </form>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</main> 
@endsection




