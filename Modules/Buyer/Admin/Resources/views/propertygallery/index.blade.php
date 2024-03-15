@extends('admin::layouts.master')
@section('title', 'Gallery List')
@section('content')
    @if ($message = Session::get('success'))
        <div class="row">
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
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger icons-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="icofont icofont-close-line-circled"></i></button>
                    {{ $message }}
                </div>
            </div>
        </div>
    @endif
 <!-- Zero config.table start -->
 <div class="card">
        <div class="card-header">
            <h4> Gallery List
            <a href="{{route('admin-property-gallery-add')}}" class="btn btn-primary btn-md pull-right">Add Gallery Image </a>
            </h4></div>
        <div class="card-block">
        @if(isset($galleryList))
            <div class="dt-responsive table-responsive">
                <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($galleryList as $k=>$li)
                    <tr>
                    <td>{{$k+1}}</td>
                    <td> @if($li->attachment!="")
                        <img src="{{$li->attachment}}" height="50" width="50"  class="img-thumbnail"></td>
                        @endif</td>
                   
                    <td>{{ date('M d, Y g:i A', strtotime($li->created_at))}}</td>
                    <td>
                     <form method="POST" action="{{ route('admin-property-image-delete',$li->id)}}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete'><i class="fa fa-trash"></i></button>
                        </form>
                 </td>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-danger">No Gallery Found</div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection   
@section('js')
<script type="text/javascript">
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
@endsection