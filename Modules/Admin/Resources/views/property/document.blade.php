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
                    <a class="nav-link active" href="{{route('admin-property-documents-view',$propertyInfo->slug)}}" >Documents</a>
                    <div class="slide"></div>
                </li>                                                
                @elseif(Auth::user()->hasRole('sub-admin'))
                @if(auth()->user()->can('admin-upload-gallery-ajax'))
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin-property-documents-view',$propertyInfo->slug)}}" >Documents</a>
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
            <!-- Video Grid card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Upload Property Document</h5>
                </div>
                <div class="card-body">
                    <form method="POST"  action="{{route('admin-property-save-document')}}" enctype="multipart/form-data" id="saveDocForm" class="saveDocForm">
                        @csrf
                        <input type="hidden" value="{{$propertyInfo->id}}" name="property_id">
                        <input type="hidden" value="{{$propertyInfo->slug}}" name="property_slug">
                        <input type="hidden" id="counter" value="1">
                        <input type="hidden" value="Document" name="type">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control doc_title @error('doc_title') is-invalid @enderror" name="doc_title" placeholder="Enter Document Name" id="doc_title0" value="{{old('doc_title')}}">
                                @error('doc_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="file" class="form-control doc_file @error('document_file') is-invalid @enderror" name="document_file"> 
                                @error('document_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        <!--  <div class="col-md-4">
                            <button type="button" id="addRow" class="btn btn-primary clone-btn-right clone"><i class="icofont icofont-plus"></i>Add New 
                            </button>
                        </div> -->
                        </div>
                        <div id="newRow"></div>
                                                <div class="row mt-5">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary" id="upload_doc">Upload Document</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>                                    
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Property Documents</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="gallery-page documentDiv">
                                             <div class="dt-responsive table-responsive">
                                                <table id="ff" class="table table table-styling table-bordered nowrap" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Title</th>
                                                            <th>Document</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @foreach($dgalleryList as $k=>$dgli)
                                                       <tr>
                                                        <td>{{$k+1}}</td>
                                                        <td>{{$dgli->name}}</td>
                                                        <td> 
                                                            <a href="{{$dgli->attachment}}" target="_blank">
                                                                <img src="{{asset('pdf.png')}}" height="50" width="50">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if($dgli->status==1)
                                                            <label class="badge badge-success badge_status_change" id="{{$dgli->id}}" style="cursor: pointer;">Active</label>
                                                            @else
                                                            <label class="badge badge-danger badge_status_change" id="{{$dgli->id}}" style="cursor: pointer;">Inactive</label>
                                                            @endif
                                                        </td>
                                                        <td>{{ date('M d, Y g:i A', strtotime($dgli->created_at))}}</td>
                                                        <td class="btn_modify">
                                                            <a href="{{$dgli->attachment}}" target="_blank" class="btn btn-primary btn-sm" title="View Document">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <button type="button" id="remove_document" class="btn btn-danger btn-sm badge_delete_status_change" id="{{$dgli->id}}" data-id="{{$dgli->id}}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
    @endsection   
    @section('js') 

    <script type="text/javascript">
        var oTable = $('#ff').DataTable( {
            "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 2,5 ] },
            { "bSearchable": false, "aTargets": [ 2,5 ] }
            ]
        });

// // add row
// $("#addRow").click(function () {
//     var html = '';
//     html += '<div class="row inputFormRow mt-3">';
//     html += '<div class="col-md-4">';
//     html += '<input type="text" name="doc_title[]" class="form-control" placeholder="Enter Document Name">';
//     html += '</div>';
//     html += '<div class="col-md-4">';
//     html += '<input type="file" class="form-control" name="document_file[]">';
//     html += '</div>';
//     html += '<div class="col-md-4">';
//     html += '<button type="button" class="btn btn-default removeRow clone-btn-right delete"><i class="fa fa-times"></i></button>';
//     html += '</div>';
//     html += '</div>';

//     $('#newRow').append(html);
// });

// remove row



$(document).on('click', '.badge_status_change', function(e)
{
    var status_class = $(this).attr('class');
    var id = $(this).attr('id');
    var change_btn = $(this);
    
    if(status_class == "badge badge-danger badge_status_change")
    {
        var newClass = "badge badge-success badge_status_change";
        var status = 'Active';
    }else
    {
        var newClass = "badge badge-danger badge_status_change";
        var status = 'Inactive';
    }
    var title ='Are you sure to '+status+' this page ?';
    e.preventDefault();      
    swal({
      title: title,
      icon: "warning",
      buttons: [
      'No, cancel it!',
      'Yes, I am sure!'
      ],
      dangerMode: true,
  }).then(function(isConfirm) {
      if(isConfirm){
        $.ajax({
            type: "POST",
            url: "{{route('admin-property-document-status-update')}}",
            data: {_token: "{{ csrf_token() }}",id:id},
            dataType: "json",
            beforeSend: function(){
                $("#loading").show();
            },
            complete: function(){
                $("#loading").hide();
            },
            success: function (data){
                change_btn.html(status);
                change_btn.removeClass(status_class).addClass(newClass);
                toastr.success("Document status updated successfully");
            }         
        })
    } else {
        swal("Cancelled", "page is not change", "error");
    }
});         
}); 


$(document).on('click', '.badge_delete_status_change', function(e){
    e.preventDefault();
    var image_id =$(this).attr("data-id");
    swal({
      title: `Are you sure you want to delete this Document?`,
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

                }else{

                }
            },
            error: function(data){
            //alert(data.responseJSON.errors.files[0]);
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






$(document).ready( function(){
    $('#addRow').click( function(){
        add_inputs()
    });
    
    $(document).on('click', '.removeRow', function () {
        $(this).closest('.inputFormRow').remove();
    });




    function add_inputs(){
        var counter = parseInt($('#counter').val());
        
        var html = '<div class="row inputFormRow mt-3"><div class="col-md-4"><input type="text" name="doc_title[]" id="doc_title'+counter+'" class="form-control doc_title" placeholder="Enter Document Name"></div><div class="col-md-4"><input type="file" class="form-control doc_file" name="document_file[]"></div><div class="col-md-4"><button type="button" class="btn btn-default removeRow clone-btn-right delete"><i class="fa fa-times"></i></button></div></div>';
        
        $('#newRow').append(html);
        $('#counter').val( counter + 1 );
    }
});

// $('form#saveDocForm').on('submit', function(event) {
//         //Add validation rule for dynamically generated name fields
//     $('.doc_title').each(function() {
//         $(this).rules("add", 
//             {
//                 required: true,
//                 messages: {
//                     required: "Document Title is required",
//                 }
//             });
//     });
//     //Add validation rule for dynamically generated email fields
//     $('.doc_file').each(function() {
//         $(this).rules("add", 
//             {
//                 required: true,

//                 messages: {
//                     required: "Document File is required",

//                   }
//             });
//     });
// });
// $("#saveDocForm").validate();

</script>
@endsection