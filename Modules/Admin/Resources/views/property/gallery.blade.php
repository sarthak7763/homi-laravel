@extends('admin::layouts.master')
@section('title', 'Property Details')
@section('css')
<script src="https://code.jquery.com/jquery-latest.js"></script>

<style type="text/css">
/*#channels > img{
  border:5px dotted transparent;
    transition: 0.5s;
}
#channels > img:hover{
  border:5px dotted red;
}
#channels > img:first-child{
  border:5px dotted gray;
}*/
</style>
@endsection
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
                            <a class="nav-link active"  href="{{route('admin-property-gallery-view',$propertyInfo->slug)}}" >Gallery</a>
                            <div class="slide"></div>
                        </li>                                                     
                        @elseif(Auth::user()->hasRole('sub-admin'))
                        @if(auth()->user()->can('admin-property-gallery-list') || auth()->user()->can('admin-upload-gallery-ajax'))
                        <li class="nav-item">
                            <a class="nav-link active"  href="{{route('admin-property-gallery-view',$propertyInfo->slug)}}" >Gallery</a>
                            <div class="slide"></div>
                        </li>
                        @endif     
                        @endif
                        @if(Auth::user()->hasRole('Admin'))                                     
                        <li class="nav-item">
                            <a class="nav-link"  href="{{route('admin-property-video-view',$propertyInfo->slug)}}" >Video</a>
                            <div class="slide"></div>
                        </li>                                                  
                        @elseif(Auth::user()->hasRole('sub-admin'))
                        @if(auth()->user()->can('admin-upload-video-ajax'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin-property-video-view',$propertyInfo->slug)}}" >Video</a>
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
                            <div class="card-block">
                               <form id="multi-file-upload-ajax" method="POST" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" class="form-control @error('files') is-invalid @enderror"   name="files[]" id="files" accept="image/*" multiple="multiple" onchange="preview_image()"> 
                                            <small>Image Maximum Size: 8MB, Min Dimension:100*100 Max Dimension: 8000*8000</small>
                                            <span id="files_error" class="text-danger"></span>
                                            <div id="errorDiv" class="alert alert-danger mt-2" style="display: none; max-height: 200px; overflow-y: auto;">
                                                <ul></ul>
                                            </div>
                                            <input type="hidden" value="{{$propertyInfo->id}}" name="property_id">
                                            <input type="hidden" value="{{$propertyInfo->slug}}" name="property_slug">
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary" id="submit">Upload Image</button>
                                        </div>


                                    </div>

                                </form>
                            </div>

                            <div class="gallery" id="image_preview"></div>
                            @if(@$featuredImg->count() < 5)
                            <div class="alert alert-warning">Maximum 5 images select as featured to publish property.</div>
                            @endif
                            <div class="card-block gallery-page">
                                @if(count($featuredImg) > 0)
                                <p class="font-weight-bold mx-2">Featured Images</p>

                                <div class="row users-card border-info px-3 py-3">

                                    @foreach(@$featuredImg as $k=>$fli)

                                    <div class="col-lg-6 col-xl-3 col-md-6 featuredDivimage">
                                        <div class="card rounded-card user-card">
                                            <div class="card-block">
                                                <div class="img-hover" id="channels">
                                                    <img class="img-fluid img-radius featured_images" src="{{$fli->attachment}}" alt="{{$fli->attachment}}"  data-id="{{$fli->id}}">
                                                    <div class="img-overlay img-radius">
                                                        <span class="btn_modify full">
                                                            <a href="{{$fli->attachment}}" data-lightbox="1" data-title="View Image" 
                                                                class="btn btn-sm btn-warning hvr-shrink">
                                                                <i class="icofont icofont-eye"></i>                             
                                                            </a>
                                                            @if($fli->is_featured==1 && $fli->name!="Featured Image")
                                                            <button type="button" class="btn btn-sm btn-danger remove_featured_image" title="Remove From Featured" data-id="{{$fli->id}}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    </div>
                                                    <div class="user-content">
                                                        {{-- <h4 class="">Cedric Kelly</h4>
                                                        <p class="m-b-0 text-muted">Network engineer</p>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    <hr>
                                    <div class="row users-card secondDiv">
                                     @foreach($galleryList as $gli)
                                     @if($gli->name != "Featured Image")
                                     <div class="col-lg-6 col-xl-3 col-md-6">
                                        <div class="card rounded-card user-card">
                                            <div class="card-block">
                                                <div class="img-hover">                                                        
                                                    <img class="img-fluid img-radius" src="{{$gli->attachment}}" alt="{{$gli->attachment}}">
                                                    <div class="img-overlay img-radius">
                                                        <span class="btn_modify full">

                                                            <a href="{{$gli->attachment}}" data-lightbox="1" data-title="View Image" class="btn btn-sm btn-warning hvr-shrink">
                                                                <i class="icofont icofont-eye"></i>
                                                            </a>
                                                            
                                                            @if($gli->is_featured==0)
                                                            <button type="button" class="btn btn-sm btn-primary set_as_featured" data-popup="lightbox" title="Set Featured" id="" data-id="{{$gli->id}}" data-property_id="{{$gli->property_id}}">
                                                                <i class="icofont icofont-link-alt"></i>
                                                            </button>
                                                            @endif

                                                            <button type="button" class="btn btn-sm btn-danger remove_image" title="Remove Image"  data-id="{{$gli->id}}">
                                                                <i class="icofont icofont-trash"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                    <div class="user-content">
                                                        {{-- <h4 class="">Cedric Kelly</h4>
                                                        <p class="m-b-0 text-muted">Network engineer</p>--}}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>

                                    {{--  <div class="row">
                                        @foreach($galleryList as $gli)
                                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="card prod-view">
                                                <div class="prod-item text-center">
                                                    <div class="prod-img">

                                                        <a  href="{{$gli->attachment}}" data-lightbox="1" data-title=""  class="hvr-shrink">

                                                          <img src="{{$gli->attachment}}" alt="{{$gli->attachment}}" class="img-fluid o-hidden img-thumbnail">
                                                      </a>
                                                      <div class="p-new"><a data-id="{{$gli->id}}" class="remove_featured_image"> <i class="fa fa-times"></i> </a></div>
                                                  </div>

                                              </div>
                                          </div>
                                      </div> --}}
                                      {{--<div class="col-lg-2 col-sm-3">
                                        <div class="thumbnail">
                                            <div class="thumb">
                                                <a href="{{$gli->attachment}}" data-lightbox="1" data-title="">
                                                    <img src="{{$gli->attachment}}" alt="{{$gli->attachment}}" class="img-fluid img-thumbnail" height="100" width="100">
                                                </a>
                                            </div>
                                        </div>
                                    </div>--}}
                                    {{--   @endforeach
                                </div>--}} 
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
// $(function () {
//     var $chn = $("#channels");
//     $chn.on("click","img", function(){
//       $chn.prepend( this );

//     });
// });

function get_index(list,item){
    for (l in list)
    {
        if(list[l] === item){
            return l;
        }
    }
    return -1;
}




$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



// $(document).ready(function(){
//  $(".featured_images").click(function(){   
//     let index = get_index($(".featured_images"),this);


//    var id = $(".featured_images").attr("data-id");

// var pos=parseInt(index)+1;
//     console.log(index+" "+id);
//     $.ajax({
//             type:'POST',
//             url: "{{ route('admin-set-image-position')}}",
//             data: {'id':id,'position':pos},
//             dataType: 'json',
//             success: (data) => {
//                 if(data.success){
//                      toastr.success("Image position updated successfully");

//                 }else{

//                 }
//             },
//             error: function(data){
//             }
//         });
//     });
// });


$('#multi-file-upload-ajax').submit(function(e) {
   $("#errorDiv").hide();
   $("#errorDiv").html('');

   e.preventDefault();
   var formData = new FormData(this);
        let TotalFiles = $('#files')[0].files.length; //Total files
        let files = $('#files')[0];
        for (let i = 0; i < TotalFiles; i++) {
            formData.append('files' + i, files.files[i]);
        }
        formData.append('TotalFiles', TotalFiles);
        $.ajax({
            type:'POST',
            url: "{{ route('admin-upload-gallery-ajax')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $("#loading").show();
            },
            complete: function(){
                $("#loading").hide();
            },
            success: (data) => {
                if($.isEmptyObject(data.error_str)){
                    $("#errorDiv").hide();
                    $('#image_preview').html("");
                    this.reset();
                    window.location.reload();
                    toastr.success("Image uploaded successfully");

                }else{
                    if(data.error_str!=""){
                        $("#errorDiv").show();
                        $('#image_preview').html("");

                        $("#errorDiv").find("ul").append(data.error_str);
                        $("#errorDiv").html(data.error_str);
                    }else{

                        $("#errorDiv").show();
                        $('#image_preview').html("");

                        $("#errorDiv").find("ul").append(data.error_str);
                        $("#errorDiv").html(data.error_str);
                    }


                }
            },
            error: function(data){
               $("#errorDiv").find("ul").append(data.error_other);
           }
       });
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


$(document).on('click', '.set_as_featured', function(e){
    e.preventDefault();
    var image_id =$(this).attr("data-id");
    var property_id =$(this).attr("data-property_id");
    swal({
      title: `Are you sure to set this image as featured image?`,
      text: "This image will show at front site property detail page section",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
    .then((willDelete) => {
        if (willDelete) {
         $.ajax({
            type:'POST',
            url: "{{ route('admin-set-featured-image')}}",
            data: {'image_id':image_id,'property_id':property_id},
            dataType: 'json',
            beforeSend: function(){
                $("#loading").show();
            },
            complete: function(){
                $("#loading").hide();
            },
            success: (data) => {
                if(data.status==1){
                    window.location.reload();
                    toastr.success("Image featured successfully");
                }else if(data.status==0){

                   toastr.error(data.message);

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



$(document).on('click', '.remove_featured_image', function(e){

    e.preventDefault();
    var image_id =$(this).attr("data-id");
    var t =$(this).parents('.featuredDivimage');

    swal({
      title: "Are you sure you want to remove this Image from Featured Section?",
      text: "If you remove it will not show in front site section of property gallery.",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
    .then((willDelete) => {
        if (willDelete) {
         $.ajax({
            type:'POST',
            url: "{{ route('admin-remove-featured-image')}}",
            data: {'id':image_id},
            dataType: 'json',
            context:this,
            beforeSend: function(){
                $("#loading").show();
            },
            complete: function(){
                $("#loading").hide();
            },
            success: (data) => {
                console.log(t);
                if(data.status=="success"){
                 $(this).parents('.featuredDivimage').hide();

                 toastr.success("Image removed from featured successfully");
                 window.location.reload();

             }else{
                t.remove();
                toastr.error("Error Image not removed.");

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