@extends('admin::layouts.master')
@section('title', 'Property Details')
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
                                    <h4>Property Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-list')}}">Property List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-details',$propertyInfo->slug)}}">Property Details</a> </li>
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
                    <div class="card">
                        <div class="card-block">
                            <!-- Row start -->
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                   <!-- Nav tabs -->
                                    <ul class="nav nav-tabs md-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link"  href="{{route('admin-property-details',$propertyInfo->slug)}}" role="tab">About</a>
                                            <div class="slide"></div>
                                        </li>
                                        @if(Auth::user()->hasRole('Admin'))                                     
                                            <li class="nav-item">
                                                <a class="nav-link"  href="{{route('admin-property-gallery-view',$propertyInfo->slug)}}" >Gallery</a>
                                                <div class="slide"></div>
                                            </li>                                                     
                                        @elseif(Auth::user()->hasRole('sub-admin'))
                                            @if(auth()->user()->can('admin-property-gallery-list') || auth()->user()->can('admin-upload-gallery-ajax'))
                                            <li class="nav-item">
                                                <a class="nav-link"  href="{{route('admin-property-gallery-view',$propertyInfo->slug)}}" >Gallery</a>
                                                <div class="slide"></div>
                                            </li>
                                            @endif     
                                        @endif
                                        @if(Auth::user()->hasRole('Admin'))                                     
                                            <li class="nav-item">
                                                <a class="nav-link active"  href="{{route('admin-property-video-view',$propertyInfo->slug)}}" >Video</a>
                                                <div class="slide"></div>
                                            </li>                                                  
                                        @elseif(Auth::user()->hasRole('sub-admin'))
                                            @if(auth()->user()->can('admin-upload-video-ajax'))
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{route('admin-property-video-view',$propertyInfo->slug)}}" >Video</a>
                                                <div class="slide"></div>
                                            </li>
                                            @endif     
                                        @endif
                                        @if(Auth::user()->hasRole('Admin'))                                     
                                           <li class="nav-item">
                                                <a class="nav-link" href="{{route('admin-property-documents-view',$propertyInfo->slug)}}" >Documents</a>
                                                <div class="slide"></div>
                                            </li>                                                
                                        @elseif(Auth::user()->hasRole('sub-admin'))
                                            @if(auth()->user()->can('admin-upload-gallery-ajax'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('admin-property-documents-view',$propertyInfo->slug)}}" >Documents</a>
                                                <div class="slide"></div>
                                            </li>
                                            @endif     
                                        @endif  

                                          <li class="nav-item">
                                            <a class="nav-link" href="{{route('admin-property-timer',$propertyInfo->slug)}}" >Timer</a>
                                            <div class="slide"></div>
                                        </li>                                             

                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                       
                                        
                                        <div class="tab-pane active">
                                           
                                            <!-- Video Grid card start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Video</h5>

                                                </div>
                                                <div class="card-block">
                                               
                                                    <form method="POST" id="vfileUploadForm"  action="{{route('admin-property-gallery-save')}}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="file" class="form-control @error('upload_file') is-invalid @enderror"   name="upload_file" id="upload_filev" required="required"> 
                                                                 <span id="upload_file_error" class="text-danger"></span>
                                                                @error('upload_file')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                               
                                                             
                                                                <input type="hidden" value="{{$propertyInfo->id}}" name="vproperty_id">
                                                                <input type="hidden" value="{{$propertyInfo->slug}}" name="vproperty_slug">
                                                                <input type="hidden" value="Video" name="type">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="submit" class="btn btn-primary" id="multi-video-upload-ajax">Upload Video</button>
                                                            </div>
                                                           
                                                           
                                                        </div>
                                                        
                                                   </form>
                                                </div>
                                          
                                                <div class="gallery" id="preview_video"></div>
                                                <div class="card-block video-gallery">
                                                    <div class="row">
                                                     @foreach($vgalleryList as $vgli)
                                                      <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12">
                                                    <div class="card prod-view">
                                                        <div class="prod-item text-center">
                                                            <div class="prod-img">
                                                            <!-- <div class="col-lg-4 col-sm-6">
                                                            <div class="thumbnail">
                                                                <div class="thumb"> -->
                                                                    <a target="_blank" href="{{$vgli->attachment}}"><img src="{{$vgli->thumbnail}}" height="150px"></a>
                                                                  <!--   <div class="embed-responsive embed-responsive-4by3">
                                                                        <iframe allowfullscreen="" src=""></iframe>
                                                                    </div> -->
                                                                      <div class="p-new"><a id="remove_video" data-id="{{$vgli->id}}"> <i class="fa fa-times"></i> </a></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                       @endforeach  
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Video Grid card end -->
                                        </div>
                                        
                                       
                                    </div>
                                </div>
                                <!-- Row end -->
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
    $(document).on('click', '#remove_video', function(e){
        e.preventDefault();
        var image_id =$(this).attr("data-id");
        swal({
              title: `Are you sure you want to delete this Video?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
               $.ajax({
            type:'POST',
            url: "{{ route('admin-property-image-delete')}}",
            data: {'image_id':image_id},
            dataType: 'json',
             beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
            success: (data) => {
                if(data.success){
                    $('.video-gallery').load(document.URL +  ' .video-gallery');
                    
                }else{
                    
                }
          
            
            },
            error: function(data){
           // alert(data.responseJSON.errors.files[0]);
            console.log(data.responseJSON.errors);
            $.each(data.error, function (key, val) {
                      $("#" + key + "_error").text(val);
                  });
                       // if( data.status === 422 ) {
                            // var errors = $.parseJSON(data.responseJSON.errors.files);
                            // $.each(errors, function (key, val) {
                            //     $("#" + key + "_error").text(val);
                            // });
                      //  }
                    
            }

        });
            }
          });
    });



function preview_image() 
{
     $('#image_preview').html("");
 var total_file=document.getElementById("files").files.length;
 for(var i=0;i<total_file;i++)
 {

  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' height='50px' width='50px' class='img-fluid img-thumbnail mr-2'>");


 }
}



lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
})

    </script>
@endsection