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
                                   
                                     @if(Auth::user()->hasRole('Admin'))
                                      {{--<a href="{{route('admin-add-system-setting')}}" class="btn btn-primary btn-round">Add New Option</a>--}}


                                        <a href="{{route('admin-site-logo')}}"  class="btn btn-primary btn-round pull-right">
                                            Edit Logo/Favicon
                                        </a>
                            

                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                      {{--  @if(auth()->user()->can('admin-add-system-setting'))
                                          <a href="{{route('admin-add-system-setting')}}" class="btn btn-primary btn-round">Add New Option</a>
                                        @endif  --}}
                                        <a href="{{route('admin-site-logo')}}"  class="btn btn-primary btn-round">
                                            Edit Logo/Favicon
                                        </a>
                                    @endif
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
                          

                           
                                <div class="card">
                                    <div class="card-block">
                                     <strong>Email Signature</strong>

                                       {{--<form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                       
                                        @foreach($systemSettingData as $key => $value) 
                                        @if($value->setting_type == 'email_signature')
                                        @if($value->status == 1) 
                                        <a onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@0')}}">
                                            <span class="badge badge-success">Active</span>
                                        </a> 
                                        @else 
                                        <a  onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@1')}}">
                                            <span class="badge badge-danger">Deactive</span>
                                        </a> 
                                        @endif
                                        @php break; @endphp
                                        @endif 
                                        @endforeach  
                                    </form>--}}
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
                                                    @php $i=1; @endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "email_signature")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="email_signature">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                  <input type="hidden" name="option_update_name[]" value="Email Signature">
                                           
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <textarea name="value[]"   id="email_signature"  class="form-control">{{ $value->option_value }}</textarea> 
                                                    </td>
                                                </tr>

                                                @php $i++; @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                                 @if(Auth::user()->hasRole('Admin'))
                                                 <button class="btn btn-primary" type="submit">Update</button>
                                                @elseif(Auth::user()->hasRole('sub-admin'))
                                                    @if(auth()->user()->can('admin-edit-system-setting-post'))
                                                      <button class="btn btn-primary" type="submit">Update</button>
                                                    @endif
                                                @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>


                              
                               {{-- <div class="card-block">
                                    <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <strong>SMTP Details</strong>

                                        @foreach($systemSettingData as $key => $value) 
                                        @if($value->setting_type == 'smtp')
                                        @if($value->status == 1) 
                                        <a onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@0')}}">
                                            <span class="badge badge-success">Active</span>
                                        </a> 
                                        @else 
                                        <a  onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@1')}}">
                                            <span class="badge badge-danger">Deactive</span>
                                        </a> 
                                        @endif
                                        @php break; @endphp
                                        @endif 
                                        @endforeach  
                                    </form>
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
                                                @php $i=1; @endphp
                                                @php $smtp=0; @endphp
                                                @foreach($systemSettingData as $key => $value)
                                                @if($value->setting_type == "smtp")
                                            <input type="hidden" name="id[]" value="{{$value->id}}">
                                            <input type="hidden" name="setting_type[]" value="smtp">
                                            <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                             <input type="hidden" name="option_update_name[]" value="SMTP">
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$value->option_name}}</td>
                                                <td><input type="text" value="{{$value->option_value}}" name="value[]" class="form-control"></td>
                                            </tr>

                                            @php $i++; @endphp
                                            @php $smtp=1; @endphp
                                            @endif 
                                            @endforeach  
                                            </tbody>
                                        </table>
                                        <div class="card-footer">
                                        @if($smtp==1)
                                         @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                    @endif

                                           
                                        </div> 
                                    </form>
                                </div> --}}
                            
                                {{--  
                                <div class="card">
                                    <div class="card-header">
                                        <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <strong>Stripe Payment Gateway</strong>
                                            @foreach($systemSettingData as $key => $value) 
                                            @if($value->setting_type == 'stripe')
                                            @if($value->status == 1) 
                                            <a onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@0')}}">
                                                <span class="badge badge-success">Active</span>
                                            </a> 
                                            @else 
                                            <a  onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@1')}}">
                                                <span class="badge badge-danger">Deactive</span>
                                            </a> 
                                            @endif
                                            @php break; @endphp
                                            @endif 
                                            @endforeach  
                                        </form>
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
                                                    @php $i=1; @endphp
                                                     @php $stripe=0; @endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "stripe")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="stripe">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                  <input type="hidden" name="option_update_name[]" value="Stript Payment gateway">
                                           
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <?php if ($value->option_value == "Live" || $value->option_value == "Test") { ?>
                                                            <select name="value[]" class="form-control">
                                                                <option value="Live" <?php echo ($value->option_value == "Live") ? 'selected="selected"' : ""; ?>>Live</option>
                                                                <option value="Test" <?php echo ($value->option_value == "Test") ? 'selected="selected"' : ""; ?>>Test</option>
                                                            </select>
                                                        <?php } else { ?>
                                                            <input type="text" value="{{$value->option_value}}" name="value[]" class="form-control">
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                @php $i++; @endphp
                                                 @php $stripe=1; @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                            @if($stripe==1)
                                                @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                    @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Currency -->
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Default Currency</strong>
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
                                                    @php $i=1; @endphp
                                                     @php $currency=0; @endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "currency")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="currency">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <input type="hidden" name="option_update_name[]" value="Currency">
                                           
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <select name="value[]" class="form-control">
                                                            <option value="GBP" <?php echo ($value->option_value == "GBP") ? 'selected="selected"' : ""; ?>>GBP</option>
                                                            <option value="USD" <?php echo ($value->option_value == "USD") ? 'selected="selected"' : ""; ?>>USD</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                @php $i++; @endphp
                                                  @php $currency=1; @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                            @if($currency==1)
                                                @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                    @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>

                                <!-- CUSTOMER SUPPORT -->
                               <div class="card">
                                    <div class="card-header">
                                        <strong>Customer Support</strong>
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
                                                    $customersupport=0; @endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "customersupport")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="customersupport">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                  <input type="hidden" name="option_update_name[]" value="Customer Support">
                                           
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text" id="" name="value[]"   id="email_content" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>

                                                @php $i++; 
                                                $customersupport=1;
                                                @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                          
                                                @if($customersupport==1)
                                               
                                                   @if(Auth::user()->hasRole('Admin'))
                                                     <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                                          <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                     @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>

                                   <!-- HEADER CONTENT -->

                               <div class="card">
                                    <div class="card-header">
                                        <strong>Header Content</strong>
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
                                                     $header_content=0;
                                                    @endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "header_content")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="header_content">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                  <input type="hidden" name="option_update_name[]" value="Header Content">
                                           
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text" id="" name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>

                                                @php $i++; 
                                                $header_content=1;
                                                @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                            @if($header_content==1)
                                                 @if(Auth::user()->hasRole('Admin'))
                                             <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                            @elseif(Auth::user()->hasRole('sub-admin'))
                                                @if(auth()->user()->can('admin-edit-system-setting-post'))
                                                  <button class="btn btn-primary" type="submit">Update</button>
                                                @endif
                                            @endif
                                        @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>
                                --}}
                                
                                    <!-- FOOTER SOCIAL MEDIA -->
                               <div class="card">
                                   <div class="card-block">
                                       <strong>Footer Social Media</strong>
                                       
                                  {{-- <form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        @foreach($systemSettingData as $key => $value) 
                                        @if($value->setting_type == 'footersocialmedia')
                                        @if($value->status == 1) 
                                        <a onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@0')}}">
                                            <span class="badge badge-success">Active</span>
                                        </a> 
                                        @else 
                                        <a  onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@1')}}">
                                            <span class="badge badge-danger">Deactive</span>
                                        </a> 
                                        @endif
                                        @php break; @endphp
                                        @endif 
                                        @endforeach  
                                    </form>  --}}  
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
                                                <input type="hidden" name="option_update_name[]" value="Footer Social Media">
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
                                                 @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                    @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>

                                   <!-- FOOTER CONTENT -->
                                  
                               <div class="card">
                                    <div class="card-block">
                                     <strong>Footer Content</strong>

                                       {{--<form action="{{route('admin-edit-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                       
                                        @foreach($systemSettingData as $key => $value) 
                                        @if($value->setting_type == 'footer_content')
                                        @if($value->status == 1) 
                                        <a onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@0')}}">
                                            <span class="badge badge-success">Active</span>
                                        </a> 
                                        @else 
                                        <a  onclick="" class="actions float-right" href="{{route('admin-option-status', $value->setting_type.'@1')}}">
                                            <span class="badge badge-danger">Deactive</span>
                                        </a> 
                                        @endif
                                        @php break; @endphp
                                        @endif 
                                        @endforeach  
                                    </form>--}}
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
                                                    @php $i=1; @endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "footer_content")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="footer_content">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                  <input type="hidden" name="option_update_name[]" value="Footer Content">
                                           
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <textarea name="value[]" class="form-control">{{ $value->option_value }}</textarea> 
                                                    </td>
                                                </tr>

                                                @php $i++; @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                                 @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>

                                   <!-- LOGO -->
                              {{-- <div class="card">
                                    <div class="card-header">
                                        <strong>Site Logo</strong>
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
                                                    $sitelogo=0;@endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "sitelogo")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="sitelogo">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="file" id="logoBrowse" name="value[]" class="form-control"  data-max-height="1024"   data-max-width="1024"   data-images-only="true" value="{{ $value->option_value }}">
                                                    </td>
                                                    <td><img src="{{asset('storage'.$value->option_value)}}" width="50px"></td>
                                                </tr>

                                                @php $i++; 
                                                $sitelogo=1; @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                            @if($sitelogo==1)
                                                  @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                    @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>

                                   <!-- LOGO -->
                               <div class="card">
                                    <div class="card-header">
                                        <strong>Site fav Icon</strong>
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
                                                    $sitefavicon=0; @endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "sitefavicon")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="sitefavicon">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="file" id="favicon" name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                    <td><img src="{{asset('storage'.$value->option_value)}}" width="50px"></td>
                                                </tr>

                                                @php $i++; 
                                                $sitefavicon=1;@endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                            @if($sitefavicon==1)
                                                  @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                    @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>
                               
                                <!-- Google Service keys -->
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Google Service keys</strong>
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
                                                    $googleservicekeys=0;@endphp
                                                    @foreach($systemSettingData as $key => $value)
                                                    @if($value->setting_type == "googleservicekeys")
                                                <input type="hidden" name="id[]" value="{{$value->id}}">
                                                <input type="hidden" name="setting_type[]" value="googleservicekeys">
                                                <input type="hidden" name="slug[]" value="{{$value->option_slug}}">
                                                  <input type="hidden" name="option_update_name[]" value="Google API Keys">
                                           
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$value->option_name}}</td>
                                                    <td>
                                                        <input type="text" name="value[]" class="form-control" value="{{ $value->option_value }}">
                                                    </td>
                                                </tr>

                                                @php $i++; 
                                                 $googleservicekeys=1; @endphp
                                                @endif 
                                                @endforeach  
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                            @if($googleservicekeys==1)
                                                @if(Auth::user()->hasRole('Admin'))
                                     <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                    @elseif(Auth::user()->hasRole('sub-admin'))
                                        @if(auth()->user()->can('admin-edit-system-setting-post'))
                                          <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        @endif
                                    @endif
                                     @endif
                                            </div> 
                                        </form>
                                    </div>
                                </div>--}}
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