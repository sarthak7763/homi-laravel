@extends('buyer::layouts.master')
@section('content')
<div class="col-md-8 col-lg-9">  
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
       
    </div>
    <div class="ox-auto uinfo-table">
<table class="table-responsive table-striped table w-100 table-bordered">
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
</tbody>

<tbody>
<tr>
<td><strong>Owner Type : </strong> <span> <?php if ($userInfo->owner_type == 1) echo "Agency"; else echo "Indiviuals" ; ?></span></td>
<td>

              
<strong>Agency Name : </strong>

@if($userInfo->owner_type == 1)
    <span> {{$userInfo->agency_name}}</span>
    @else
    <span> 
    {{'NA'}}</span>
    @endif
</td>
</tr>
</tbody>
</table>
</div>
    </div>
</div>

@endsection
