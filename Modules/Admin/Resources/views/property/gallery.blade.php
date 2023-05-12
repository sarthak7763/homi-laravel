@extends('admin::layouts.master')
@section('title', 'Property Details')
@section('css')
<script src="https://code.jquery.com/jquery-latest.js"></script>

@endsection
@section('content')

@php 
  $property_image_error="";
  @endphp

  @if (session()->has('valid_error'))
     @php $validationmessage=session()->get('valid_error'); @endphp
      @if($validationmessage!="" && isset($validationmessage['property_gallery']))
      @php $property_image_error=$validationmessage['property_gallery']; @endphp
      @else
      @php $property_image_error=""; @endphp
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
                                    <h4>Property Gallery</h4>
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
                            <a class="nav-link active"  href="{{route('admin-property-gallery-view',$propertyInfo->slug)}}" >Gallery</a>
                            <div class="slide"></div>
                        </li>                                                
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active">
                            @if(count($galleryList) < 8)
                            <div class="card-block">
                               <form id="multi-file-upload-ajax" method="POST" action="{{ route('admin-upload-gallery-ajax')}}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="property_gallery" id="property_gallery" accept="image/*" onchange="preview_image()"> 
                                            @if($property_image_error!="")
                                            <div id="errorDiv" class="alert alert-danger mt-2" style="max-height: 200px; overflow-y: auto;">
                                                {{$property_image_error}}
                                            </div>
                                            @endif
                                            <input type="hidden" value="{{$propertyInfo->id}}" name="property_id">
                                            <input type="hidden" value="{{$propertyInfo->slug}}" name="property_slug">
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary" id="submit">Upload Image</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif

                            <div class="gallery" id="image_preview"></div>

                            @if(count($galleryList)==0)
                                <div class="alert alert-warning">Please upload at least one image to publish the property.</div>
                            @endif

                            @php 
                            $gallerycount= count($galleryList);
                            $remaingallerycount=8-$gallerycount;
                            @endphp
                            @if(count($galleryList) < 8)
                            <div class="alert alert-warning">You can add Maximum {{$remaingallerycount}} images to the property.</div>
                            @endif

                            <div class="card-block gallery-page">
                            <div class="row users-card secondDiv">
                         @foreach($galleryList as $gli)
                         <div class="col-lg-6 col-xl-3 col-md-6">
                            <div class="card rounded-card user-card">
                                <div class="card-block">
                                    <div class="img-hover">                  
                                    <img class="img-fluid img-radius" src="{{url('/')}}/images/property/gallery/{{$gli->image}}" alt="{{$gli->image}}">
                                    <div class="img-overlay img-radius">
                                        <span class="btn_modify full">

                                        <a href="{{url('/')}}/images/property/gallery/{{$gli->image}}" data-lightbox="1" data-title="View Image" class="btn btn-sm btn-warning hvr-shrink">
                                            <i class="icofont icofont-eye"></i>
                                        </a>

                                            <button type="button" class="btn btn-sm btn-danger remove_image" title="Remove Image"  data-id="{{$gli->id}}">
                                                <i class="icofont icofont-trash"></i>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
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

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.remove_image', function(e){
    e.preventDefault();
    var image_id =$(this).attr("data-id");
    swal({
      title: `Are you sure you want to delete this Image?`,
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

                 window.location.reload();
                 toastr.success("Image deleted successfully");


             }else{
                toastr.error("Something went wrong.");
             }
         },
         error: function(data){
                    toastr.error("Something went wrong.");
            }
        });
     }
 });

});


function preview_image() 
{
    
$('#image_preview').html("");
var total_file=document.getElementById("property_gallery").files.length;
for(var i=0;i<total_file;i++)
{

  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' height='150px' width='150px' class='img-fluid  mr-2'>");
 }

}

lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
})

</script>
@endsection