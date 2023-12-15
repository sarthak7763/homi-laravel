@extends('buyer::layouts.master')
@section('content')
<div class="col-md-9">
<div class="profile-box">
    <div class="profile-box-form">
        <h1 class="mb-3">My Profile</h1>
        <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
        <form class="profile-form ">
            <div class="user-box-img">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="user-box overflow-visible position-relative">
                            <div class="user-box2-img">
                          @if($userInfo->profile_pic)
                            <img class="rounded-pill-box" src="{{url('/')}}/images/{{$userInfo->profile_pic}}">
                            @else
                            <img class="rounded-pill-box" src="{{url('/')}}/assets_front/images/user-icon.jpg">
                            @endif    
                            </div>        
                            <div class="useravtarIcon">
                                <input type="file" id="myFile" class="opacity-0 position-absolute bottom-0" name="filename">
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
                            <input type="text" class="form-control"  aria-describedby="" value="{{$userInfo->name}}" readonly>            
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-4"> 
                            <input type="email" class="form-control"  aria-describedby="" value="{{$userInfo->email}}" readonly>   
                        </div>
                    </div>
                </div>
                        <div class="row">
                        <div class="col-12">
                            <input type="integer" class="form-control " readonly  aria-describedby="" name="mobile"  value="{{$userInfo->mobile}}">   
                        </div>
                    </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Owner Type</label>
                            <input type="text" class="form-control" readonly  aria-describedby="" name="owner_type"  value="<?php if ($userInfo->owner_type == 1) echo "Agency"; else echo "Indiviuals" ; ?>">   
                        </div>
                    </div>
                    @if($userInfo->owner_type == 1)
                    
                    <div class="col-md-6"  style="display:block ;">
                        <div class="form-group" >
                            <input type="text" class="form-control" readonly  value = "{{$userInfo->agency_name}}">
                        </div>
                    </div>
                    @else
                    <div class="col-md-6"  style="display:none;">
                        @endif
                    </div>
                </div>
        </form>
        </div>
    </div>
</div>
@endsection