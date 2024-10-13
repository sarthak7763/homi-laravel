@extends('admin::layouts.master')
@section('title', 'Edit FAQ')
@section('content')

<style type="text/css">
    label.error {
    color: red;
    font-size: 13px;
}
</style>

@php 
  $question_error="";
  $answer_error="";
  $status_error="";
  @endphp

  @if (session()->has('valid_error'))
     @php $validationmessage=session()->get('valid_error'); @endphp
      @if($validationmessage!="" && isset($validationmessage['question']))
      @php $question_error=$validationmessage['question']; @endphp
      @else
      @php $question_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['answer']))
      @php $answer_error=$validationmessage['answer']; @endphp
      @else
      @php $answer_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['status']))
      @php $status_error=$validationmessage['status']; @endphp
      @else
      @php $status_error=""; @endphp
      @endif

  @endif

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
                                    <h4>Edit FAQ</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-faq-list')}}">FAQ List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-faq-edit',@$faqInfo->id)}}">Edit FAQ</a> </li>
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
                       <form method="POST" action="{{route('admin-faq-update')}}"  enctype="multipart/form-data" id="saveFaqForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Question<span style="color:red;">*</span></label>
                                    <input type="hidden" value="{{@$faqInfo->id}}" name="id">
                                    <input type="text" class="form-control" name="question" id="question" required="required" value="{{@$faqInfo->question}}">
                                    @if($question_error!="")
                                    @php $style="display:block;"; @endphp
                                    @else
                                    @php $style="display:none;"; @endphp
                                    @endif
                                    <span class="invalid-feedback" style="{{$style}}" role="alert">
                                        <strong>{{ $question_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Answer<span style="color:red;">*</span></label>
                                    <textarea type="text" rows="10" cols="10" class="form-control" name="answer" id="answer" required="required">{{$faqInfo->answer}}</textarea>
                                    @if($answer_error!="")
                                    @php $style="display:block;"; @endphp
                                    @else
                                    @php $style="display:none;"; @endphp
                                    @endif
                                    <span class="invalid-feedback" style="{{$style}}" role="alert">
                                        <strong>{{ $answer_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{ $faqInfo->status == "1" ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $faqInfo->status == "0" ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                   @if($status_error!="")
                                    @php $style="display:block;"; @endphp
                                    @else
                                    @php $style="display:none;"; @endphp
                                    @endif
                                    <span class="invalid-feedback" style="{{$style}}" role="alert">
                                        <strong>{{ $status_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"> 
                                    
                                    <button type="submit" id="submitdata" class="btn btn-success">Save</button>
                         
                                    <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                    <a href="{{route('admin-faq-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
                                
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
$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


   $("#saveFaqForm").validate({  
        rules: {
            question:{
                required:true
            }, 
            answer:{
                required:true
            }, 
            status: {
                required: true,
            },
        },
        messages: {
            question: {
                required: "Please enter question",
            },
            answer: {
                required: "Please enter answer",
            },
            status: {
                required: "Please select status",
            },
        },
        submitHandler: function(form) 
            {
                 
                $("#loading").show();
                $("#submitdata").hide();
                 form.submit();
            },
             invalidHandler: function(){
                  $("#submitdata").show();
                  $("#loading").hide();
        }
    });

   $("#submitdata").on('click',function(){
        $("#saveFaqForm").submit();
        return false;
    });

</script>
@endsection
