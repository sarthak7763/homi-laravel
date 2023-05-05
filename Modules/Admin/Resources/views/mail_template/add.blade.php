@extends('admin::layouts.master')
@section('title', 'Add Mail Template')
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
                                    <h4>Add Mail Template</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-mail-template-list')}}">Mail Template List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-mail-template-add')}}">Add Mail Template</a> </li>
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
                                    <form method="POST" action="{{route('admin-mail-template-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Name<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Mail Name">
                                                    @error('name')
                                                          <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                               <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Subject<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control  @error('subject') is-invalid @enderror" name="subject" id="subject" placeholder="Enter Mail Subject">
                                                    @error('subject')
                                                          <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="row">
                                           <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Mail Action<span style="color:red;">*</span></label>
                                                    <select class="form-control  @error('action') is-invalid @enderror" name="action" onchange="getParameters()" id="action" required>
                                                        <option value="">Select Actions</option>
                                                        @foreach($mail_actions as $li) 

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
                                                    <label class="font-weight-bold">Design your email template body<span style="color:red;">*</span></label>
                                                    <textarea class="ck-editor @error('body') is-invalid @enderror" name="body" id="body"></textarea>
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

                                                    <a href="{{route('admin-mail-template-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  

                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-mail-template-save'))
                                                        <button type="submit" class="btn btn-primary m-b-0">Save</button>  

                                                        <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0" onclick="clearData();">Reset</button>
                                                    @endif
                                                    @if(auth()->user()->can('admin-mail-template-list'))
                                                        
                                                        <a href="{{route('admin-mail-template-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
                                                    
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>


CKEDITOR.replace( 'body' );
function clearData(){
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
    CKEDITOR.instances[instance].setData('');
 
}



function getParameters(){
    $('#parameter').html('');
    var actionID =$("#action").val();         
    $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",action:actionID}, 
        url: "{{ route('admin-ajax-get-mail-options-list') }}",
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
}

$("#action").on("change", function() {
    CKEDITOR.instances.body.setData('');
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
    var targetEditor = CKEDITOR.instances.body;
    var range = targetEditor.createRange();
    range.moveToElementEditEnd(range.root);
    targetEditor.insertHtml(str, 'html', range);
}
</script>
@endsection
