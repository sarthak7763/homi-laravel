@extends('admin::layouts.master')
@section('title', 'Add Sms Template')
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
                                    <h4>Add Sms Template</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-sms-template-list')}}">Sms Template List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-sms-template-add')}}">Add Sms Template</a> </li>
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
                                    <form method="POST" action="{{route('admin-sms-template-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Name<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Sms Name">
                                                    @error('name')
                                                          <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                               
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="radio" class="radio_sms_type" id="checkbox_sms" value="sms" name="sms_type" checked>
                                                <label for="checkbox_sms">SMS </label>
                                                &nbsp;
                                                <input type="radio" class="radio_sms_type"  id="checkbox_admin_sms" name="sms_type" value="admin_sms"> <label for="checkbox_admin_sms">  Admin SMS </label>
                                            </div>
                                        </div>
                                      
                                        <div class="row">
                                           <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Sms Action<span style="color:red;">*</span></label>
                                                    <select class="form-control  @error('action') is-invalid @enderror" name="action" id="action" required>
                                                        <option value="">Select Actions</option>
                                                        @foreach($sms_actions as $li) 

                                                        <option value="{{$li->action}}">{{$li->action}}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('action')
                                                          <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Options/Parameters<span style="color:red;">*</span></label>
                                                    <select class="form-control @error('parameter') is-invalid @enderror"  name="parameter" id="parameter" required>
                                                        <option value="">Select Parameters</option>
                                                    </select>

                                                    @error('parameter')
                                                          <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                        </div>


                                     
                                        <div class="row">
                                            <div class="col-md-12">
                                               <button type="button" id="add_params" class="btn btn-success pull-right">Add Options in Editor</button>
                                                <div class="form-group mt-3">
                                                    <label class="font-weight-bold">Design your sms template body<span style="color:red;">*</span></label>
                                                    <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body"></textarea>
                                                    @error('body')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                @if(Auth::user()->hasRole('Admin'))
                                                    <button type="submit"  class="btn btn-primary m-b-0">Save</button>  

                                                    <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0" onclick="clearData();">Reset</button>

                                                    <a href="{{route('admin-sms-template-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  

                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-sms-template-save'))
                                                        <button type="submit"  class="btn btn-primary m-b-0">Save</button>  

                                                        <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0" onclick="clearData();">Reset</button>
                                                    @endif

                                                    @if(auth()->user()->can('admin-sms-template-list'))
                                                        <a href="{{route('admin-sms-template-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
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
<!-- Ckeditor js -->
<script>



$(".radio_sms_type").on('change', function(e){ 
    $('#action').html("");
    var sms_type = $(this).val();
        
    $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",sms_type:sms_type}, 
        url: "{{ route('admin-get-ajax-sms-action-list') }}",
        beforeSend: function(){
            $("#loading").show();
        },
        complete: function(){
            $("#loading").hide();
        },
        success:function(result){
            if(result) {
                $('#action').html(result);
            }
            else {
              //  alert('error');
            }
        }
    });
});


//function getParameters(){
    $("#action").on('change', function(e){ 
    $('#parameter').html('');
    var actionID =$("#action option:selected").val();  
    var sms_type =$("input[name='sms_type']:checked").val();

  //  alert(actionID);

  // alert(sms_type);
    $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",action:actionID,sms_type:sms_type}, 
        url: "{{ route('admin-ajax-get-sms-options-list') }}",
        beforeSend: function(){
            $("#loading").show();
        },
        complete: function(){
            $("#loading").hide();
        },
        success:function(result){
            if(result) {
                $('#parameter').html(result);
            }
            else {
               // alert('error');
            }
        }
    });
     });
//}

$("#action").on("change", function() {
     $('#body').val("");
});

$("#add_params").on("click", function() {
    var select =  $('#parameter option:selected');

    if(select.val() != ""){
          $("#body").val(function(i, val) {
       str=select.val();
        val="##"+str+"##";
      // val += str;
        insertIntoCkeditor(" "+val);
    })
    }
});

function insertIntoCkeditor(str){
   
   
    $('#body').append(str);
}
</script>
@endsection