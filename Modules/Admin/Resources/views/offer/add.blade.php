@extends('admin::layouts.master')
@section('title', 'Add property sales timer')
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
                                    <h4>Create Property Sale Timer</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-sales-list')}}">Property Sale Timer List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-sales-add')}}">Create Property Sale Timer</a> </li>
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
                              
                                <div class="card-block">
                                @if(count($propertyList)> 0)
                                    <form method="POST" action="{{route('admin-property-sales-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Select Property<span style="color:red;">*</span></label>
                                                    <select class="form-control @error('property_id') is-invalid @enderror" name="property_id" id="property_id">
                                                       <option value="">Select Property</option> 
                                                        @foreach($propertyList as $pli)
                                                    <option value="{{$pli->id}}" @if (old('property_id') == "{{$pli->id}}") {{ 'selected' }} @endif>{{$pli->title}}</option>
                                                    @endforeach 
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
                                                    <input type="text" name="date_start" id="date_start" class="form-control  @error('date_start') is-invalid @enderror " placeholder="Please Select Start Date"> 
                                                    
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
                                                    <input type="text" name="time_start" id="time_start" class="form-control @error('time_start') is-invalid @enderror " placeholder="Please Select Start Time"> 
                                                    
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
                                                  <input type="text" name="date_end" id="date_end" class="form-control datepicker-autoclose @error('date_end') is-invalid @enderror " placeholder="Please Select End Date"> 
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
                                                  <input type="text" name="time_end" id="time_end" class="form-control  @error('time_end') is-invalid @enderror " placeholder="Please Select End Time"> 
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
                                                  <textarea name="offer_details" id="offer_details" class="form-control @error('offer_details') is-invalid @enderror " placeholder="Enter Offer Detail"> </textarea>
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
                                                    <input type="radio" name="sale_status" value="1">
                                              Yes
                                                </label>
                                              <label class="ml-4">
                                                    <input type="radio" name="sale_status" value="0" checked="checked">
                                                  No
                                                </label>
                                                               
                                                   
                                                </div>
                                            </div>
                                      

                                         
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(Auth::user()->hasRole('Admin')) 
                                                    
                                                    <button type="submit"  class="btn btn-primary m-b-0">Save</button>

                                                    <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                    <a href="{{route('admin-property-sales-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            
                                                
                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-property-sales-save'))
                                                       
                                                        <button type="submit"  class="btn btn-primary m-b-0">Save</button>

                                                        <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                    @endif
                                                    @if(auth()->user()->can('admin-property-sales-list'))
                                                       <a href="{{route('admin-property-sales-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                                    @endif
                                                @endif


                                             
                                            </div>
                                        </div>
                                    </form>
                                @else
                                <div class="alert alert-danger">No Property Found to Create A Timer. Please Add A New Property.</div>    
                                @endif
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
