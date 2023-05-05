@extends('admin::layouts.master')
@section('title', 'Feedback Details')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Feedback Details</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-enquiry-list')}}">Feedback list</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-enquiry-detail',$enquiryInfo->id)}}">Feedback Details</a> </li>
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
                @if($errors->all())
                 <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                   {{ $error }}
                    @endforeach
                </div>
                @endif
                <div class="page-body">
                   <div class="row">
                       
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Feedback Details</h5>
                                           
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="general-info">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-xl-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-0" style="font-size: 12px">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th scope="row">Feedback No.</th>
                                                                                    <td>{{ $enquiryInfo->id}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Name</th>
                                                                                    <td>{{ $enquiryInfo->name}}</td> 
                                                                                </tr>
                                                                                 <tr>
                                                                                    <th scope="row">Mobile</th>
                                                                                    <td>{{ getMobileFormat($enquiryInfo->mobile_no)}}</td> 
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Email</th>
                                                                                    <td>{{ $enquiryInfo->email}}</td> 
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Feedback Status</th>
                                                                                    <td>
                                                                                    @if($enquiryInfo->status == 1)
                                                                                            Active
                                                                                    @else
                                                                                            Inactive
                                                                                    @endif
                                                                                    
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Feedback Date</th>
                                                                                    <td>{{ $enquiryInfo->created_at->format('M d, Y') }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Reason of Feedback</th>
                                                                                    <td>{{$enquiryInfo->getReasonType->name}}</td>
                                                                                    </tr>
                                                                                <tr>
                                                                                <th colspan="2" scope="row">Description</th>
                                                                                   
                                                                                </tr>
                                                                                <tr>
                                                                                 {{--<td colspan="2" style="white-space:pre-wrap; word-wrap:break-word"><div class="alert alert-inverse">{!! @$enquiryInfo->description !!}</div>

                                                                                 </td>--}}

                                                                                 <td colspan="4"  style="white-space:pre-wrap; word-wrap:break-word"><div style=" border: 1px inset #ccc;
                                                                                    background-color: white;
                                                                                    font: small courier, monospace black;
                                                                                    width: 100%;padding: 16px;
                                                                                  
                                                                                    height: 200px; 
                                                                                    overflow: auto;"">{!! @$enquiryInfo->description !!}
                                                                                    </div></td>
                                                                                           




                                                                                </tr>

                                                                                  <th colspan="2" scope="row">Feedback Response By Admin </th>
                                                                                   
                                                                                </tr>
                                                                                <tr>
                                                                                 <td colspan="4"  style="white-space:pre-wrap; word-wrap:break-word"><div style=" border: 1px inset #ccc;
                                                                                    background-color: white;
                                                                                    font: small courier, monospace black;
                                                                                    width: 100%;padding: 16px;
                                                                                  
                                                                                    height: 200px; 
                                                                                    overflow: auto;"">{!! @$enquiryResponse->description ? $enquiryResponse->description : "----" !!}
                                                                                    </div></td>

                                                                                 {{--<td colspan="2" style="white-space:pre-wrap; word-wrap:break-word"><div class="alert alert-inverse">{!! @$enquiryResponse->description ? $enquiryResponse->description : "----" !!}</div></td>--}}
                                                                                </tr>



                                                                              
                                                                             
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                             
                                                            </div>
                                                            <!-- end of row -->
                                                        </div>
                                                        <!-- end of general info -->
                                                    </div>
                                                    <!-- end of col-lg-12 -->
                                                </div>
                                                <!-- end of row -->
                                            </div>
                                        </div>
                                        <!-- end of card-block -->
                                    </div>
                                    <!-- contact data table card start -->
                                  
                                            <div class="card">
                                              <!--   <div class="card-header">
                                                    <h5 class="card-header-text">Write Solution</h5>
                                                </div> -->
                                                <div class="card-block contact-details">
                                                    <form method="POST" action="{{route('admin-user-complaint-respond')}}"  enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{@$enquiryInfo->id}}">
                                                         <input type="hidden" name="response_type" value="enquiry">

                                                        <input type="hidden" name="email" value="{{@$enquiryInfo->email}}">

                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label font-weight-bold">Reply to User</label>
                                                            <div class="col-sm-10">
                                                            <textarea rows="8" id="content"  required="required" cols="8" name="description" class="form-control  @error('description') is-invalid @enderror"></textarea>
                                                            @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2"></label>
                                                            <div class="col-sm-10">
                                                                <button type="submit" name="submit" value="submit" class="btn btn-primary m-b-0">Send Mail</button>
                                                                <button type="reset" onclick="clearData()" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>
                                                                 <a href="{{route('admin-user-enquiry-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        
                                        <!-- contact data table card end -->
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
    CKEDITOR.replace('content');
   function clearData(){
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
    CKEDITOR.instances[instance].setData('');
 
}
</script>
@endsection