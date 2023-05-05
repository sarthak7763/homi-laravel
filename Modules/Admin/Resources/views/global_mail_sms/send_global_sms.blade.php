@extends('admin::layouts.master')
@section('title', 'Send SMS')
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
                                    <h4>Send SMS</h4>
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
                                 
                                     <li class="breadcrumb-item"><a href="{{route('admin-city-add')}}">Send SMS</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                               <!--  <div class="card-header">
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
                                <div class="card-block">
                                       <form method="POST" action="{{route('admin-global-sms-send-post')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                         <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Select Users</label>
                                                    <span class="pull-right">
                                                    
                                                    <input type="checkbox" id="checkbox">
                                                    <label for="checkbox">Select All Users</label>
                                                    </span>  
                                                    <select id="e1" class="form-control js-example-placeholder-multiple @error('user_id') is-invalid @enderror" name="user_id[]" multiple="multiple" required>
                                                        @foreach($userList as $li)
                                                            <option value="{{$li->id}}">{{$li->name}} ({{$li->email}})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id.*')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{--<div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Use Template<span style="color:red;">*</span></label>

                                                    <select  class="form-control @error('template') is-invalid @enderror" name="template" id="template" required="required">
                                                    <option>Select Template</option>
                                                        @foreach(@$templateList as $li)
                                                        @if(!empty($li))
                                                            <option value="{{@$li->id}}">{{@$li->name}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    @error('template')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">SMS</label>
                                                    <textarea required="required"  rows="10" cols="5" class="form-control @error('message') is-invalid @enderror" name="message" id="message" required="required"></textarea>  
                                                    @error('message')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        {{--<div class="row">
                                         <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Property<span style="color:red;">*</span></label>
                                                    <select  class="form-control js-example-placeholder-multiple @error('property_id') is-invalid @enderror" name="property_id" multiple="multiple" id="property_id" required="required">
                                                        @foreach($propertyList as $li)
                                                            <option value="{{$li->id}}">{{$li->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('property_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                       
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Use Template<span style="color:red;">*</span></label>
                                                    <select  class="form-control @error('template') is-invalid @enderror" name="template" id="template" required="required">
                                                        @foreach($templateList as $li)
                                                            <option value="{{$li->id}}">{{$li->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('template')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                                <div class="col-md-12">
                                                <button class="btn btn-primary">Send SMS</button>
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
<script type="text/javascript">
 


$(document).ready(function(){
    $(".js-example-placeholder-multiple").select2({
        placeholder: "Select Users"
    });
});

$("#checkbox").click(function(){
    if($("#checkbox").is(':checked') ){
          $("#e1").find('option').prop("selected",true);
        //$("#e1 > option").prop("selected","selected");
        $("#e1").trigger("change");
    }else{
          $("#e1").find('option').prop("selected",false);
       // $("#e1 > option").removeAttr("selected","selected");
         $("#e1").trigger("change");
         // Unselect all
        //$('#e1').select2('destroy').find('option').prop('selected', false).end().select2();
     }
});

$("#template").on("change", function() {
    var select =  $('#template option:selected').val();
    if(select!=""){
      $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",sms_template_id:select}, 
        url: "{{ route('admin-get-ajax-sms-template') }}",
        beforeSend: function(){
            $("#loading").show();
        },
        complete: function(){
            $("#loading").hide();
        },
        success:function(response){
            if(response.status=="success") {
                  $('#message').val(response.result.body);
                
            }
            else {
               $('#message').val("");
                
            }
        }
    });   

    }else{
 $('#message').val("");               
    }
    
});

</script>>
@endsection
