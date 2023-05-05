 @extends('admin::layouts.master')
@section('title', 'Property Timer')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-4">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Property Timer</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-list')}}">Property List</a> </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-details',$property->slug)}}">Property Details</a> </li>
                                      <li class="breadcrumb-item"><a href="{{route('admin-property-timer',$property->slug)}}"> Property Timer</a> </li>
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
        <!-- Row start -->
        <div class="row">
            <div class="col-lg-12 col-xl-12">
             <!-- Nav tabs -->
             <ul class="nav nav-tabs md-tabs">
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('admin-property-details',$property->slug)}}" role="tab">About</a>
                    <div class="slide"></div>
                </li>
                @if(Auth::user()->hasRole('Admin'))                                     
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('admin-property-gallery-view',$property->slug)}}" >Gallery</a>
                    <div class="slide"></div>
                </li>                                                     
                @elseif(Auth::user()->hasRole('sub-admin'))
                @if(auth()->user()->can('admin-property-gallery-list') || auth()->user()->can('admin-upload-gallery-ajax'))
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('admin-property-gallery-view',$property->slug)}}" >Gallery</a>
                    <div class="slide"></div>
                </li>
                @endif     
                @endif
                @if(Auth::user()->hasRole('Admin'))                                     
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('admin-property-video-view',$property->slug)}}" >Video</a>
                    <div class="slide"></div>
                </li>                                                  
                @elseif(Auth::user()->hasRole('sub-admin'))
                @if(auth()->user()->can('admin-upload-video-ajax'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin-property-video-view',$property->slug)}}" >Video</a>
                    <div class="slide"></div>
                </li>
                @endif     
                @endif
                @if(Auth::user()->hasRole('Admin'))                                     
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin-property-documents-view',$property->slug)}}" >Documents</a>
                    <div class="slide"></div>
                </li>                                                
                @elseif(Auth::user()->hasRole('sub-admin'))
                @if(auth()->user()->can('admin-upload-gallery-ajax'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin-property-documents-view',$property->slug)}}" >Documents</a>
                    <div class="slide"></div>
                </li>
                @endif     
                @endif      
                                          
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin-property-timer',$property->slug)}}" >Timer</a>
                    <div class="slide"></div>
                </li>                                                
                
                                                                              
            </ul>
            <!-- Tab panes -->
            <!-- Video Grid card start -->
            <div class="card">
                <!-- <div class="card-header">
                    <h5> Property Timer</h5>
                </div> -->
                <div class="card-body">
                    
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
                                                <label class="font-weight-bold">Publish this Property Timer</label>
                                                  
                                                                       
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
                                                    
                                                    <button type="submit"   class="btn btn-primary m-b-0">Save</button>

                                                    <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                    <a href="{{route('admin-property-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            
                                                
                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-property-sales-save'))
                                                       
                                                        <button type="submit"  class="btn btn-primary m-b-0">Save</button>

                                                        <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                    @endif
                                                    @if(auth()->user()->can('admin-property-list'))
                                                       <a href="{{route('admin-property-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                                    @endif
                                                @endif


                                             
                                            </div>
                                        </div>
                                    </form>
                                        </div>
                                    </div>                                    
                                   
                        </div>
                        <!-- Row end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection   
    @section('js') 

    <script type="text/javascript">
   

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









