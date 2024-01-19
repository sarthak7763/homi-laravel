@extends('buyer::layouts.master')
@section('content')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-lg-9">
    <div class="profile-box">
        <div class="profile-box-form">
            <div>
                    @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
            <div class="row align-items-center mb-3 group-property-row">
                
                <div class="col-md">
                    <h1 class="mb-3">Property</h1>
                </div>
                <div class="col-md-auto">
                    <form action = "{{route('buyer.property-search')}}" method="post" id="searchform" autocomplete="off">
                        @csrf
                        <div class="search-input-group input-group-property">
                            <div class="form-outline">
                                <input type="text" id="title_search" class="form-control" name = "title_search" placeholder="Search data" value ="{{$search_title}}" />
                                <select name="status_search">
                                  <option value ="" >select status</option> 
                                  <option value ="1" {{ $search_status == 1 ? 'selected' : '' }}>Active</option>
                                  <option value ="2" {{ $search_status ==                                                                                                                                                                            2 ? 'selected' : '' }}>Suspend</option>
                                  <option value ="0">Pending</option>
                                 </select>                                
                                </div>
                            <button type="submit" class="btn-search">
                            Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div>
            <a href="{{route('buyer.add-property')}}" class="btn btn-info" button type="submit">Add Property</a>
        </div>
        @if(!empty($propertyData))
        <div class="manage-total-bookings">
            <ul class="manage-list">
                @foreach($propertyData as $property)
                <li class="manage-item">
                    <div class="row">
                        <div class="col-12 col-md colbox-img">
                            <div class="manage-list-img">
                                @if($property['property_image'])
                                <img src="{{url('/')}}/images/property/thumbnail/{{$property['property_image']}}">
                                @else
                                <img src="{{url('/')}}/assets_front/images/rent-image-01.jpg">
                                @endif
                            </div>
                        </div>
                        <input type ="hidden" name = "property_id" id = "{{$property['id']}}">
                        <input type ="hidden" name = "property_status" id = "{{$property['property_status']}}">
                        <div class="col-12 col-md">
                            <div class="manage-list-text">
                                <h2>
                                    <a href="#">{{$property['title']}}</a>
                                </h2>
                                <p>
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7141 11.8808C11.9335 12.6613 10.3013 14.2934 9.17818 15.4166C8.52726 16.0675 7.47309 16.0678 6.82218 15.4169C5.71863 14.3133 4.118 12.7128 3.28597 11.8808C0.682468 9.27725 0.682468 5.05612 3.28597 2.45262C5.88946 -0.150875 10.1106 -0.150875 12.7141 2.45262C15.3175 5.05612 15.3175 9.27725 12.7141 11.8808Z" stroke="#828282" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 7.1665C10.5 8.54725 9.38075 9.6665 8 9.6665C6.61925 9.6665 5.5 8.54725 5.5 7.1665C5.5 5.7858 6.61925 4.6665 8 4.6665C9.38075 4.6665 10.5 5.7858 10.5 7.1665Z" stroke="#828282" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    {{$property['property_address']}}    | 
                                    @if($property['property_status'] == 1)
                                    {{'Active'}}
                                    @else
                                    {{'Suspend'}}
                                    @endif |    Listed on:  {{$property['created_at']}}
                                </p>
                                <p>
                                @if($property['property_type'] == 1)
                                    {{'Renting'}}
                                    @else
                                    {{'Buying'}}
                                    @endif |  {{$property['category_name']}}
                                </p>
                                <div class="manage-btn-group">
                                    <a href="{{route('buyer.view-property',($property['id']))}}" class="btn btn-view">View</a>
                                    <a href="{{route('buyer.edit-property',($property['id']))}}" class="btn btn-edit">Edit</a>
                                    <button type="button" class="btn btn-primary status_change" data-toggle="modal" data-target="#myModal" data-id="{{$property['id']}}" data-status="{{$property['property_status']}}">Change Status</button>
                                </div>
                            </div>
                        </div>
                </li>
                @endforeach
            </ul>
            </div> 
            
        </div>
        @else
        <div class ="no-data-box">
            <center>
    <h2>{{'No Data Found '}}</h2>
</center>
</div>
@endif
        <form action = "{{route('buyer.status-update-property')}}" method ="Post" enctype = "multipart/form-data" >
            @csrf
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Your form or content for status change goes here -->
                            <p>Are you sure you want to change the status?</p>
                            <input type= "hidden" name = "property_id" id="property_hidden_id">
                            <input type= "hidden" name = "property_status" id="property_hidden_status"> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="update_data" >Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
@endsection