@extends('admin::layouts.master')
@section('title', 'Add Property Gallery Images')
@section('content')
<form method="POST" action="{{route('admin-property-gallery-save')}}"  enctype="multipart/form-data">
    @csrf

<div class="card">
    <div class="card-header">
        <h5>File Upload</h5>
         <a href="{{route('admin-property-gallery-list')}}" class="btn btn-primary btn-md pull-right">Gallery List</a>
       <!--  <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-maximize full-card"></i></li>
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div> -->
    </div>
    <div class="card-block">
       <div class="form-group row col-md-6">
            <label class="font-weight-bold">Select Property</label>
            <select class="form-control" name="property_id" id="property_id">
                @foreach($propertyList as $sli)
                    <option value="{{$sli->id}}">{{$sli->title}}</option>
                @endforeach
            </select>
        </div>
        <input type="file" name="files[]" id="filer_input2" multiple="multiple">
    </div>
</div>

  

</form>
@endsection
@section('js')
<script>

</script>
@endsection
