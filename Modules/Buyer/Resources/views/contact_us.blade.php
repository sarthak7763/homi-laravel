@extends('buyer::layouts.master')
@section('title','Offercity-Contact Us')
@section('content')
<style>
    
label.error {   
    color: red; 
    font-size: 13px;    
}

label.radio {
    cursor: pointer;
    width: 100%;
    text-align: center;
    margin-right: 5px
}

label.radio input {
    position: absolute;
    top: 0;
    left: 0;
    visibility: hidden;
    pointer-events: none
}

label.radio span {
    padding: 12px 20px;
    border: 2px solid #0d6efd;
    display: inline-block;
    color: #0d6efd;
    border-radius: 3px;
    text-transform: uppercase;
    width: 100%
}

label.radio input:checked+span {
    border-color: #0d6efd;
    background-color: #0d6efd;
    color: #fff
}

    
.form-control { 
    border: none;   
    font-size: 20px;    
    padding-left: 0;    
    padding-right: 0;   
}
</style>

 
<div class="profileBox mt-4 pt-2">
  <div class="container">
      <div class="row pt-4">
          <div class="col-md-12">
            <h1 class="text-white">Contact Us</h1>
          </div>
      </div>
  </div>
</div>

<div class="container mb-5 formGroup">
  
     @if ($message = Session::get('success'))
        <div class="row mt-5">
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
        <div class="row mt-5">
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
    <div class="text-center mt-5">
       <form>           
        <div class="row">
           
            <div class="col">
                <label class="radio"> 
                    <input type="radio" id="reason_type" name="d1" value="enquiry" class="reasonTypeCheckBox" checked>  
                    <span>Feedback </span> 
                </label> 
            </div>
             {{--<div class="col">
                <label class="radio"> 
                    <input type="radio" id="reason_type" name="d1" value="complaint" class="reasonTypeCheckBox" > 
                    <span>Complaint <i class="fa fa-phone"></i> </span> 
                </label> 
            </div>--}}
        </div>
      </form>

        {{--<div class="ComplaintFormDiv" style="display: none">
         	<form name="contactFormComplaint" id="contactFormComplaint" action="{{route('buyer-contact-us-submit')}}" method="POST" enctype="multipart/form-data">
            	@csrf     
                <input type="hidden" name="reason_type" value="complaint"> --}}
                {{--<div class="row">
        	        	<div class="form-group fname col-md-6">
        	            	<input type="text" class="form-control" placeholder="First Name" name="first_name" autofocus  id="focusField">
        	      		</div>
        	        	<div class="form-group lname col-md-6">
        	            	<input type="text" class="form-control" placeholder="Last Name" name="last_name" >
        	        	</div>
        	     	</div>
        	        <div class="row">
        		        <div class="form-group email col-md-6">
        		           	<input type="email" class="form-control" placeholder="Email" name="email">
        		        </div>
        		           
        		        <div class="phone_number_sec col-md-6">
        		            <div class="form-group phone_number">
        		                <input type="tel" class="form-control only_number" id="phone_number" minlength="4" maxlength="14" name="mobile_no" placeholder="Phone Number">
        		                @error('mobile_no')
        			                <span class="invalid-feedback" role="alert">
        			                    <strong>{{ $message }}</strong>
        			                </span>
        		                @enderror
        		                <input type="hidden" class="contact_code" id="contact_code" name="contact_code">
        		                <input type="hidden" class="country_name" name="country_name">
        		                <input type="hidden" class="country_code" name="country_code">
        		        	</div>
        		        </div>
        	    	</div>--}}
        	       {{--
        		    @if(isset($reasonList) && !empty($reasonList))
        		        <div class="row divComplaint">
        		            <div class="col-md-12">  
        			             <div class="form-group mt-4 text-left"> 
        			            
        			             	<select class="form-control  @error('select_a_reason_complaint') is-invalid @enderror" name="select_a_reason_complaint" id="selectaReasonComplaint">
        			             		<option value="">Select a Complaint Reason</option>
        			             		@foreach($reasonList as $li)
        			             		@if($li->type == "Complaint")
        			             			<option value="{{$li->id}}">{{$li->name}}</option>
        			             		@endif
        			             		@endforeach
        			             	</select>
        			             	@error('select_a_reason_complaint')
        			                    <span class="invalid-feedback" role="alert">
        			                        <strong>{{ $message }}</strong>
        			                    </span>
        		                	@enderror
        			            </div>
        		           </div>
        		        </div>
        	        @endif
        		  
        	        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group subject subjectDiv text-left">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" placeholder="Complaint Title" name="subject"  id="subject" value="{{old('subject')}}">
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        				
        	            <div class="col-md-12"> 
        		            <div class="form-group">
        		        		<textarea rows="5" cols="3" id="description" name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Message">{{old('description')}}</textarea>
        			        	@error('description')
        	                        <span class="invalid-feedback" role="alert">
        	                            <strong>{{ $message }}</strong>
        	                        </span>
        	                    @enderror
                            </div> 
        	            </div>
        	        </div>

                     <div class="row divAttachments">
                        <div class="col-md-12">  
                            <div class="form-group">
                                <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror" title="Attachments">
                                @error('attachment')
                                    <span class="invalid-feedback text-left" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

        	   <div class="row button-group">
                <div class="col">
        	        <input type="submit" value="Submit" class="btn btn-primary link bluebg w-100" id="submitComplaintBtn">
                </div>
                     <div class="col">  
                    <button type="reset" class="btn btn-default w-100">Reset</button>
                </div>
            </div>
        	       
        	    
        	</form>    
        </div>--}}

        <div class="EnquiryFormDiv">
            <form name="contactFormEnquiry" id="contactFormEnquiry" action="{{route('buyer-contact-us-submit')}}" method="POST" enctype="multipart/form-data">
                @csrf     
              
                  <input type="hidden" name="reason_type" value="enquiry"> 
                  
                    @if(isset($reasonList) && !empty($reasonList))
                        <div class="row divEnquiry">
                            <div class="col-md-12">  
                                <div class="form-group mt-4 text-left"> 
                                    <select class="form-control @error('select_a_reason_enquiry') is-invalid @enderror" name="select_a_reason_enquiry" id="selectaReasonEnquiry">
                                        <option value="">Select A Reason</option>
                                        @foreach($reasonList as $li)
                                        @if($li->type == "Enquiry")
                                            <option value="{{$li->id}}">{{$li->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('select_a_reason_enquiry')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                           </div>
                        </div>
                    @endif

                    <div class="row">
                        

                        <div class="col-md-12"> 
                             <div class="form-group text-left">
                                <textarea rows="5" cols="3" name="description" class="form-control @error('description') is-invalid @enderror" id="description_enquiry" placeholder="Message">{{old('description')}}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>
                    </div>
                <div class="row button-group">
                    <div class="col">  
                        <input type="submit" value="Submit" class="btn btn-primary link bluebg w-100" id="submitEnquiryBtn">
                     </div>
                     <div class="col">   
                        <button type="reset" class="btn btn-default w-100">Reset</button>
                    </div>
                </div>
                   
              
            </form>  
        </div>
    </div>
</div>
@endsection
@section('js')

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">

$(document).on("click", ".reasonTypeCheckBox", function () {
    var type = $(this).val();

    if(type=="enquiry"){
        $(".EnquiryFormDiv").show();

    	$("#submitEnquiryBtn").show();
    	$("#submitComplaintBtn").hide();
         $(".ComplaintFormDiv").hide();
    	
    	$("#selectaReasonComplaint").val('').trigger('change');
    	$("#selectaReasonComplaint").removeClass('error');
    	$("#selectaReasonComplaint").siblings('label').remove();
    	
    	$("#selectaReasonEnquiry").val('').trigger('change');
    	$("#selectaReasonEnquiry").removeClass('error');
    	$("#selectaReasonEnquiry").siblings('label').remove();

    	$(".divEnquiry").show();
    	$(".divComplaint").hide();
    	$(".divAttachments").hide();
    	$(".subjectDiv").hide();
    	
        $("#subject").val("");
        $("#description").val("");
    	$("#subject").removeClass('error');
    	$("#subject").siblings('label').remove();
    	$("#description").removeClass('error');
    	$("#description").siblings('label').remove();
        $("#description_enquiry").val("");
        $("#description_enquiry").removeClass('error');
        $("#description_enquiry").siblings('label').remove();

    }else{
        $(".ComplaintFormDiv").show();
         $(".EnquiryFormDiv").hide();
    	$("#submitEnquiryBtn").hide();
    	$("#submitComplaintBtn").show();

    	$("#selectaReasonComplaint").val('').trigger('change');
    	$("#selectaReasonComplaint").removeClass('error');
    	$("#selectaReasonComplaint").siblings('label').remove();
    	
    	$("#selectaReasonEnquiry").val('').trigger('change');
    	$("#selectaReasonEnquiry").removeClass('error');
    	$("#selectaReasonEnquiry").siblings('label').remove();
    	
		$(".divComplaint").show();
    	$(".divEnquiry").hide();
    	$(".divAttachments").show();
    	$(".subjectDiv").show();

        $("#subject").val("");
        $("#description").val("");


    	$("#subject").removeClass('error');
    	$("#subject").siblings('label').remove();
    	$("#description").removeClass('error');
    	$("#description").siblings('label').remove();

        $("#description_enquiry").val("");
        $("#description_enquiry").removeClass('error');
        $("#description_enquiry").siblings('label').remove();

        
    }
});

$(document).on("click", "#submitComplaintBtn", function () {
  $('form[name=contactFormComplaint]').validate({            
        rules: {
            description:{
                required:true,
                minlength:4
            }, 
            subject:{
            	required:true,
            	minlength:30
            }
            ,
            select_a_reason_complaint: {
              required: true
            }
            // attachment:{
            //     //required: true,
            //     accept:"jpg,jpeg,docx,doc,pdf",
            // }  
        },
        messages: {
            description: {
                required: "Message is required",
            	minlength:"Message length should be minimum 4 characters long"
            },
            subject: {
                required: "Complaint Title is required",
            	minlength:"Complaint Title length should be minimum 30 characters long"
            },
            select_a_reason_complaint: {
              required: "Select Reason of Complaint"
              
            } 
        },
        submitHandler: function(form) 
        {
            $("#loading").show();
            $("#submitMail").hide();
            form.submit();
        },
        invalidHandler: function(){
            $("#submitMail").show();
            $("#loading").hide();
        }
	});
});

$(document).on("click", "#submitEnquiryBtn", function () {
   	//var types = $("input[name='reason_type']:checked").val();
	$('form[name=contactFormEnquiry]').validate({            
    	rules: {
        	description:{
            	required:true,
            	minlength:4
        	}, 
        	select_a_reason_enquiry: {
          		required: true
        	}
        },
    	messages: {
        	description: {
            	required: "Message is required",
            	minlength:"Message length should be minimum 4 characters long"
        	},
        	select_a_reason_enquiry: {
          		required: "Select A Reason"
          	}
        },
    	submitHandler: function(form) {
        	$("#loading").show();
        	$("#submitMail").hide();
        	form.submit();
    	},
    	invalidHandler: function(){
        	$("#submitMail").show();
        	$("#loading").hide();
    	}
	}); 
});

</script>
@endsection