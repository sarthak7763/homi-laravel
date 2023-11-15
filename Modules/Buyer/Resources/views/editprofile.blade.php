@extends('buyer::layouts.master')
@section('content')

    <div class="col-md-9">
      <div class="profile-box">          
        <div class="profile-box-form">
          <h1 class="mb-3">Edit Profile</h1>
          <form class="profile-form " method = "Post" enctype = "multipart/form-data" action = "{{route('buyer.update-profile')}}">
            @csrf 
            <div class="user-box-img">
              <div class="row">
               <div class="col-12 text-center">
                <div class="user-box overflow-visible position-relative">


                @if($userInfo->profile_pic)
                <img class="rounded-pill" src="{{url('/')}}/images/{{$userInfo->profile_pic}}">
                  @else
                  <img class="rounded-pill" src="{{url('/')}}/images/user-image-01.jpg">
                  @endif    
                  
                  <div class="useravtarIcon">
                    <input type="file" id="myFile" class="opacity-0 position-absolute bottom-0" name="profile_pic">
                    <span class="avtar_user d-inline-block rounded-pill position-absolute bottom-0 bg-white">
                      <svg width="18" height="16" viewBox="0 0 18 16" fill="none" class="mt-1">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 5.25002C0.75 4.2375 1.57081 3.41669 2.58333 3.41669H3.43549C4.04848 3.41669 4.6209 3.11034 4.96092 2.6003L5.70575 1.48307C6.04577 0.973037 6.61819 0.666687 7.2312 0.666687H10.7688C11.3818 0.666687 11.9542 0.973037 12.2942 1.48307L13.0391 2.6003C13.3791 3.11034 13.9516 3.41669 14.5645 3.41669H15.4167C16.4292 3.41669 17.25 4.2375 17.25 5.25002V13.5C17.25 14.5126 16.4292 15.3334 15.4167 15.3334H2.58333C1.57081 15.3334 0.75 14.5126 0.75 13.5V5.25002Z" stroke="#4A5568" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.75 8.91669C11.75 10.4355 10.5188 11.6667 9 11.6667C7.48117 11.6667 6.25 10.4355 6.25 8.91669C6.25 7.39786 7.48117 6.16669 9 6.16669C10.5188 6.16669 11.75 7.39786 11.75 8.91669Z" stroke="#4A5568" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </div>
                </div> 
              </div> 
            </div>           
            <div class="row">
              <div class="col-12">
                <strong>Owner Type</strong>
              </div>
              <div class="col-6">
               <div class="mb-4">            
                <input type="text" class="form-control @error('name') is-invalid @enderror"  aria-describedby="" name="name"   value="{{$userInfo->name}}">
                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('name')}}
                                    </div>
                                    @endif
            
              </div>
              
            </div>
            <div class="col-6">
              <div class="mb-4"> 
                <input type="text" class="form-control @error('email') is-invalid @enderror"  aria-describedby="" name="email" readonly  value="{{$userInfo->email}}">   
                
              </div>
              @if($errors->has('email'))
              <div class="invalid-feedback">
                                        {{$errors->first('email')}}
                                    </div>
                                    @endif
            </div>

          </div>
          <div class="row">
            <div class="col-12">
             <input type="integer" class="form-control @error('mobile') is-invalid @enderror"  aria-describedby="" name="mobile"  value="{{$userInfo->mobile}}">   
           </div>
           @if($errors->has('mobile'))
           <div class="invalid-feedback">
                                        {{$errors->first('mobile')}}
                                    </div>
                                    @endif

         </div>

         <br>
         <br>
         <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Owner Type</label>
                              <select name="owner_type" id="owner_type"  class="form-control owner_type">
                                  <option value="">Select Owner Type</option>
                            <option value="1" {{ $userInfo->owner_type == 1 ? 'selected' : '' }}>Agency</option>
                            <option value="2" {{ $userInfo->owner_type == 2 ? 'selected' : '' }}>Indiviuals</option>
                               </select>
                               </div>
                        </div>

                        @if($userInfo->owner_type == 1)
                        <div class="col-md-6" id="showagencydiv" style="display:block;">
                            <div class="form-group" >
                              <input type="text" class="form-control"  name="agency_name" id = "agency_name" value = "{{$userInfo->agency_name}}">
                                </div>
                            </div>
                            @else
                            <div class="col-md-6" id="showagencydiv" style="display:none;">
                            <div class="form-group" >
                              <input type="text" class="form-control"  name="agency_name" id = "agency_name" value = "{{$userInfo->agency_name}}">
                                </div>
                            </div>
                            @endif
                          </div>
        

         <!-- <a href="{{route('buyer.update-profile')}}" class="btn btn-primary">Update 
            </a> -->
         <button type="submit"  class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">Update</button>
       </form>

     </div>
   </div>
 </div>
</div>
</div>
</div>
</main>

<!-- Modal -->
<div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close rounded-circle" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="form-change-password">      
             
          <div class="mb-4">            
            <input type="password" class="form-control" id="" placeholder="Old Password">            
          </div>
          <div class="mb-4">
            <input type="password" class="form-control" id="" placeholder="New Password">
          </div>


          <div class="mb-4">
            <input type="password" class="form-control" id="" placeholder="Confirm Password">       
          </div>     
       <button type="submit" class="btn btn-secondary">Update</button>      
        </form>
      </div>
   
    </div>
  </div>
</div>
@endsection
