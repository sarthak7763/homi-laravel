@extends('admin::layouts.master')
@section('title', 'Add FAQ')
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
                                    <h4>Add FAQ</h4>
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
                                     <li class="breadcrumb-item"><a href="{{route('admin-faq-add')}}">Add FAQ</a> </li>
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
                                       <form method="POST" action="{{route('admin-faq-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Question<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" id="question" required="required" value="{{old('question')}}">
                                                    @error('question')
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
                                                    <label class="font-weight-bold">Answer<span style="color:red;">*</span></label>
                                                    <textarea type="text" rows="10" cols="10" class="form-control @error('answer') is-invalid @enderror" name="answer" id="answer" required="required">{{old('answer')}}</textarea>
                                                    @error('answer')
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
                                                    <label class="font-weight-bold">Status</label>
                                                    <select class="form-control" name="status">
                                                        <option value="1" {{ old('status') == "1" ? 'selected' : '' }}>Enable</option>
                                                        <option value="0" {{ old('status') == "0" ? 'selected' : '' }}>Disable</option>
                                                    </select>
                                                    @error('status')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(Auth::user()->hasRole('Admin')) 
                                                    
                                                    <button type="submit"  class="btn btn-success">Save</button>
                                         
                                                    <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                    <a href="{{route('admin-faq-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
                                                
                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-faq-save'))
                                                       
                                                        <button type="submit" class="btn btn-success">Save</button>
                                         
                                                        <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                    @endif
                                                    @if(auth()->user()->can('admin-faq-list'))
                                                         <a href="{{route('admin-faq-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
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
<script>
 //CKEDITOR.replace( 'answer' );
 CKEDITOR.replace( 'answer', {
    toolbar: [
   // { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
  //  { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
  //  { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
  //  { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
    '/',
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
//    { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
   // '/',
    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
   // { name: 'others', items: [ '-' ] },
   // { name: 'about', items: [ 'About' ] }
]
});

</script>
@endsection
