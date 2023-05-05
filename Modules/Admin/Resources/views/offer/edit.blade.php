@extends('admin::layouts.master')
@section('title', 'Edit Property Sale Timer')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit Property Sale Timer</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-sales-list')}}">Offers List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-sales-edit',$propertyInfo->id)}}">Edit Property Sale Timer</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                @if ($message = Session::get('success'))
                    <div class="row">
                        <div class="col-md-12">
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                             <label  class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                              </label>
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @endif
                @if($message = Session::get('error'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                             <label type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 19px;margin-top: -1px;">&times;</span>
                              </label>
                                
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <!-- <div class="card-header">
                                    <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div>
                                </div> -->
                                <div class="card-block">
                                    <form method="POST" action="{{route('admin-property-sales-update',$propertyInfo->id)}}"  enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$propertyInfo->id}}" name="id">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold"> Property<span style="color:red;">*</span></label>
                                                    <select class="form-control @error('property_id') is-invalid @enderror" name="property_id" id="property_id" >
                                                     
                                                       
                                                    <option value="{{$propertyInfo->property_id}}" @if($propertyInfo->property_id == @$propertyInfo->OfferPropertyInfo->id) {{ 'selected' }} @endif>{{@$propertyInfo->OfferPropertyInfo->title}}</option>
                                                   
                                                    </select>
                                                    @error('property_id')
                                                         <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Start Date<span style="color:red;">*</span></label>
                                                    <input type="text" name="date_start" id="date_start" class="form-control datepicker-autoclose @error('date_start') is-invalid @enderror " placeholder="Please Select Start Date" value="@php echo date('M-d-Y',strtotime($propertyInfo->date_start)); @endphp"> 
                                                    
                                                    @error('date_start')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Start Time<span style="color:red;">*</span></label>
                                                    <input type="text" name="time_start" id="time_start" class="form-control @error('time_start') is-invalid @enderror " placeholder="Please Select Start Time" value="{{@$propertyInfo->time_start ? date('h:i A', strtotime($propertyInfo->time_start)) :''}}"> 
                                                    
                                                    @error('time_start')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">End Date<span style="color:red;">*</span></label>
                                                  <input type="text" name="date_end" id="date_end" class="form-control datepicker-autoclose @error('date_end') is-invalid @enderror " placeholder="Please Select End Date" value="@php echo date('M-d-Y',strtotime($propertyInfo->date_end)); @endphp"> 
                                                    @error('date_end')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                             
                                
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">End Time<span style="color:red;">*</span></label>
                                                  <input type="text" name="time_end" id="time_end" class="form-control @error('time_end') is-invalid @enderror " placeholder="Please Select End Time" value="{{@$propertyInfo->time_end ? date('h:i A', strtotime($propertyInfo->time_end)) :''}}"> 
                                                    @error('time_end')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                          
                                  
                                      

                                           <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Offer Detail</label>
                                                  <textarea name="offer_details" id="offer_details" class="form-control datepicker-autoclose @error('offer_details') is-invalid @enderror " placeholder="Enter Offer Detail">{{$propertyInfo->offer_details}} </textarea>
                                                  <small>This is for internal purpose only</small>
                                                    @error('offer_details')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                       

                                         <div class="col-md-12">
                                            <label class="font-weight-bold">Publish this Sale</label>
                                              
                                                                   
                                            <label class="ml-4">
                                                <input type="radio" name="sale_status" value="1"  @if($propertyInfo->sale_status==1) checked @endif>
                                          Yes
                                            </label>
                                          <label class="ml-4">
                                                <input type="radio" name="sale_status" value="0" @if($propertyInfo->sale_status==0) checked @endif>
                                              No
                                            </label>
                                                           
                                                @error('offer_details')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                     
                                          </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(Auth::user()->hasRole('Admin')) 
                                                    
                                                    <button type="submit"  class="btn btn-primary m-b-0">Update</button>

                                              
                                                    <a href="{{route('admin-property-sales-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                                
                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-property-sales-update'))
                                                       
                                                         <button type="submit"  class="btn btn-primary m-b-0">Update</button>

                                                    @endif
                                                    @if(auth()->user()->can('admin-property-sales-list'))
                                                      <a href="{{route('admin-property-sales-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                                    @endif
                                                @endif



                                              
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection
@section('js')
<script>

$(document).ready(function () {

        $("#date_start").datepicker({
            dateFormat: "M-dd-yy",
            minDate: 0,
            onSelect: function (date) {
                var date_end = $('#date_end');
                var startDate = $(this).datepicker('getDate');
                var minDate = $(this).datepicker('getDate');
                var newDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate()+1);
                if(date_end<startDate){
                      date_end.datepicker('setDate', newDate);
                }
              
                //startDate.setDate(newDate.getDate() + 30);
                //sets dt2 maxDate to the last day of 30 days window
               //date_end.datepicker('option', 'maxDate', startDate);
                date_end.datepicker('option', 'minDate', newDate);
               //$(this).datepicker('option', 'minDate', minDate);
            }
        });
        $('#date_end').datepicker({

            dateFormat: "M-dd-yy"
        });
    });

$('#time_start').timepicker  
(  
    {  
    timeFormat: 'h:mm p',  
     interval: 5, 
   // minTime: '10',  
   // maxTime: '6:00pm',  
   // defaultTime: '11',  
  //  startTime: '10:00',  
    dynamic: false,  
    dropdown: true,  
    scrollbar: true  
    }  
);  


$('#time_end').timepicker  
(  
    {  
    timeFormat: 'h:mm p',  
     interval: 5, 
   //  minTime:5,
   // maxTime: '6:00pm',  
   // defaultTime: '11',  
  //  startTime: '10:00',  
    dynamic: false,  
    dropdown: true,  
    scrollbar: true  
    }  
);  
</script>
@endsection