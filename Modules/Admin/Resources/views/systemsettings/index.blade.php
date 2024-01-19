@extends('admin::layouts.master')
@section('title', 'System Setting')
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
                                <div class="d-inline mt-4">
                                    <h4 class="mb-1">System Setting</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-system-settings')}}">System Setting</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if ($message = Session::get('success'))
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="alert alert-success icons-alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="icofont icofont-close-line-circled"></i></button>
                                        {{ $message }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($message = Session::get('error'))
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="alert alert-danger icons-alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="icofont icofont-close-line-circled"></i></button>
                                        {{ $message }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- FOOTER SOCIAL MEDIA -->
                            <div class="card">
                                <div class="card-block">
                                    <strong>Footer Social Media</strong> 
                                </div>
                                <div class="card-body">
                                    <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <table id="" class="table table-responsive-lg table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Option Name</th>
                                                    <th>Option Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1;
                                                $footersocialmedia=0; @endphp
                                                @foreach($systemSettingData as $key => $value)
                                                @if($value->setting_type == "footersocialmedia")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="footersocialmedia">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text"  name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>
                                                @php $i++;
                                                $footersocialmedia=1; @endphp
                                                @endif 
                                                @endforeach  
                                            </tbody>
                                        </table>
                                        <div class="card-footer">
                                            @if($footersocialmedia==1)
                                            <button class="btn btn-primary" type="submit">Update</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Booking and Data Settings -->
                            <div class="card">
                                <div class="card-block">
                                    <strong>Booking and Data Settings</strong> 
                                </div>
                                <div class="card-body">
                                    <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <table id="" class="table table-responsive-lg table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Option Name</th>
                                                    <th>Option Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1;
                                                $siteappsettings=0; @endphp
                                                @foreach($systemSettingData as $key => $value)
                                                @if($value->setting_type == "siteappsettings")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="siteappsettings">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text"  name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>
                                                @php $i++;
                                                $siteappsettings=1; @endphp
                                                @endif 
                                                @endforeach  
                                            </tbody>
                                        </table>
                                        <div class="card-footer">
                                            @if($siteappsettings==1)
                                            <button class="btn btn-primary" type="submit">Update</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Homi contact Information -->
                            <div class="card">
                                <div class="card-block">
                                    <strong>Homi Contact Information (Invoice)</strong> 
                                </div>
                                <div class="card-body">
                                    <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <table id="" class="table table-responsive-lg table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Option Name</th>
                                                    <th>Option Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1;
                                                $homicontactinfo=0; @endphp
                                                @foreach($systemSettingData as $key => $value)
                                                @if($value->setting_type == "homicontactinfo")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="homicontactinfo">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text"  name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>
                                                @php $i++;
                                                $homicontactinfo=1; @endphp
                                                @endif 
                                                @endforeach  
                                            </tbody>
                                        </table>
                                        <div class="card-footer">
                                            @if($homicontactinfo==1)
                                            <button class="btn btn-primary" type="submit">Update</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Homi Personal details -->
                            <div class="card">
                                <div class="card-block">
                                    <strong>Homi Personal details</strong> 
                                </div>
                                <div class="card-body">
                                    <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <table id="" class="table table-responsive-lg table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Option Name</th>
                                                    <th>Option Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1;
                                                $personalinfo=0; @endphp
                                                @foreach($systemSettingData as $key => $value)
                                                @if($value->setting_type == "personalInfo")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="personalinfo">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text"  name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>
                                                @php $i++;
                                                $personalinfo=1; @endphp
                                                @endif 
                                                @endforeach  
                                            </tbody>
                                        </table>
                                        <div class="card-footer">
                                            @if($personalinfo==1)
                                            <button class="btn btn-primary" type="submit">Update</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- bank account details -->
                            <!-- Homi contact Information -->
                            <div class="card">
                                <div class="card-block">
                                    <strong>Homi Contact Information (Enquiry)</strong> 
                                </div>
                                <div class="card-body">
                                    <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <table id="" class="table table-responsive-lg table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Option Name</th>
                                                    <th>Option Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1;
                                                $contactusinfo=0; @endphp
                                                @foreach($systemSettingData as $key => $value)
                                                @if($value->setting_type == "contactusinfo")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="contactusinfo">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text"  name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>
                                                @php $i++;
                                                $contactusinfo=1; @endphp
                                                @endif 
                                                @endforeach  
                                            </tbody>
                                        </table>
                                        <div class="card-footer">
                                            @if($contactusinfo==1)
                                            <button class="btn btn-primary" type="submit">Update</button>
                                            @endif
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
</div>
@endsection
@section('js')
<script>
    CKEDITOR.replace('email_content');
    
    CKEDITOR.replace( 'email_signature' );
    
    
    $(document).ready(function() {       
    $('#logoBrowse').bind('change', function() {
        var a=(this.files[0].size);
        alert(a);
        if(a > 2000000) {
            alert('large');
        };
    });
    });
    
    function maxDimensions(width, height) {
    return function(fileInfo) {
    var imageInfo = fileInfo.originalImageInfo
    
    if (imageInfo === null) {
      return
    }
    var heightExceeded = height && imageInfo.height > height
    
    if (width && imageInfo.width > width) {
      if (heightExceeded) {
        throw new Error('maxDimensions')
      }
      else {
        throw new Error('maxWidth')
      }
    }
    if (heightExceeded) {
      throw new Error('maxHeight')
    }
    }
    }
    
    $(function() {
    $('[role=uploadcare-uploader]').each(function() {
    var input = $(this)
    
    if (!input.data('maxWidth') && !input.data('maxHeight')) {
      return
    }
    var widget = uploadcare.Widget(input)
    
    widget.validators.push(maxDimensions(input.data('maxWidth'), input.data('maxHeight')))
    })
    })
    
    UPLOADCARE_LOCALE_TRANSLATIONS = {
    // messages for widget
    errors: {
    maxDimensions: 'This image exceeds max dimensions.',
    maxWidth: 'This image exceeds max width.',
    maxHeight: 'This image exceeds max height.',
    },
    // messages for dialog’s error page
    dialog: {
    tabs: {
      preview: {
        error: {
          maxDimensions: {
            title: 'Title.',
            text: 'Text.',
            back: 'Back',
          },
          maxWidth: {
            title: 'Title.',
            text: 'Text.',
            back: 'Back',
          },
          maxHeight: {
            title: 'Title.',
            text: 'Text.',
            back: 'Back',
          },
        },
      },
    },
    },
    }
    
</script>
@endsection