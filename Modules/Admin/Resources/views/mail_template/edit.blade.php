@extends('admin::layouts.master')
@section('title', 'Edit Mail Template')
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
                                    <h4>Edit Mail Template</h4>
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
                                     <li class="breadcrumb-item"><a href="{{route('admin-mail-template-edit',$mailTemplate->id)}}">Add Mail Template</a> </li>
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
                                    <form method="POST" action="{{route('admin-mail-template-update')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                 <input type="hidden"  name="id" value="{{$mailTemplate->id}}">
                                                    <label class="font-weight-bold">Name<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{$mailTemplate->name}}" placeholder="Enter Mail Name">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">    
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Subject<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{$mailTemplate->subject}}" id="subject" placeholder="Enter Mail Subject">
                                                    @error('subject')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Action<span style="color:red;">*</span></label>
                                                    <select class="form-control @error('action') is-invalid @enderror" name="action" onchange="getParameters()" id="action" required>
                                                        <option value="">Select Actions</option>
                                                        @foreach($mail_actions as $li) 

                                                        <option value="{{$li->action}}" @if($li->action == $mailTemplate->action) selected @endif>{{$li->action}}</option>
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
                                                    <select class="form-control @error('parameter') is-invalid @enderror"  name="parameter" id="parameter" >
                                                        <option value="">Select Parameters</option>

                                                    </select>

                                                    @error('parameter')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                        </div>--}}
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Email Template Body<span style="color:red;">*</span></label>
                                                    <small class="text-danger">Please do not change short codes.</small>
                                                    <textarea  class="ck-editor @error('body') is-invalid @enderror" name="body" id="body" rows="10" cols="5">{{$mailTemplate->body}}</textarea>
                                                    @error('body')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="font-weight-bold">Short Codes</label>
                                                <div class="border border-light border-1 bg-light px-2 py-2">
                                                    @forelse($shortCodesArr as $li)
                                                        <li>{{$li}}</li>  
                                                    @empty
                                                    @endforelse                                          
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                @if(Auth::user()->hasRole('Admin'))
                                                    <button type="submit"  class="btn btn-primary m-b-0">Update</button>
                                                    <a href="{{route('admin-mail-template-list')}}" class="btn btn-inverse m-b-0">Go Back</a>   
                                                    
                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-mail-template-update'))
                                                       <button type="submit"  class="btn btn-primary m-b-0">Update</button>

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
                alert('error');
            }
        }
    });
}

$("#parameter").on("change", function() {
    var select = $(this);

    $("#body").val(function(i, val) {
       str=select.val();
        val=str+" ";
      // val += str;
        insertIntoCkeditor(val);
    })
});
  function insertIntoCkeditor(str){
    var targetEditor = CKEDITOR.instances.body;
var range = targetEditor.createRange();
range.moveToElementEditEnd(range.root);
targetEditor.insertHtml(str, 'html', range);
  }

</script>
@endsection
