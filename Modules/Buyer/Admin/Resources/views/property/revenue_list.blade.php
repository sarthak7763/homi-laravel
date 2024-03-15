@extends('admin::layouts.master')
@section('title', 'Revenue')
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
                                    <h4>Revenue </h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-revenue-list')}}">Revenue</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                   
                    <button type="button" class="btn btn-primary btn-round" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Apply Filters</button>

                     
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
                     <div class="card my-1">
                        <div class="card-block collapse mt-3"  id="collapseExample">
                            <div class="row">
                                
                               
                                <div class="col-md-6">       
                                    <div class="form-group">
                                        <label><strong>Start Date <span class="text-danger"></span></strong></label>
                                        <div class="controls">
                                            <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> 
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">        
                                    <div class="form-group">
                                        <label><strong>End Date <span class="text-danger"></span></strong></label>
                                        <div class="controls">
                                            <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> 
                                            <div class="help-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                               
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Property Type</strong></label>
                                        <select id='property_type' class="form-control">
                                            <option value="">All Property Type</option>
                                            @foreach($propertyTypeList as $pli)
                                            <option value="{{$pli->id}}">{{$pli->name}}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                            <button class="resetFilter btn btn-inverse" type="button">Reset</button> 
                        </div>
                    </div>
                  
                    <div class="card">
                        <div class="card-header">
                                <span>Difference = Sold Price-Seller Price<br>
                                Total Revenue= Sum of Difference
                                </span> 
                               
                            </div> 
                       
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="propertytable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                    <thead>
                                    <tr class="table-primary">
                                        <th>S.No</th>
                                        <th>Property</th>
                                        <th>List Price </th>
                                        <th>Seller Price </th>
                                        <th>Sold Price</th>
                                        <th>Difference</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <tr>
                                    </tbody>
                                    <tfoot><tr><th colspan="6" style="text-align:right; padding-right: 50px"></th></tr></tfoot>
                                </table>
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
<script type="text/javascript">
  
    // set a common class for both id
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd'
    });

function table_ajax(){
      var i = 1;
      var table = $('#propertytable').DataTable({
        processing: true,
           serverSide: false,
            "bDestroy": true,
        ajax: {
            url: "{{ route('admin-revenue-list') }}",
            type: 'GET',
             data: function (d) {
              
                d.search = $('input[type="search"]').val(),
                d.start_date = $('#start_date').val(),
                d.end_date = $('#end_date').val(),
                d.property_type=$('#property_type').val();

            }
        },
        columns: [
          //  {data: 'DT_RowIndex', orderable: false,
                    //searchable: false},
                       {
                    "render": function() {
                        return i++;
                    }
                },

        
              {data:"title",
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
            
             {data: 'base_price'},
            {data: 'seller_price'},
            {data: 'bid_price'},
            {data: 'difference'},
           
                 
        ],
        footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
        
                    // Total over all pages
                    total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        if(total > 0){
                            total = moneyFormat(total);
                        }else if(total < 0){
                            total = moneyFormat(total);
                        }else{
                            total = moneyFormat(total);
                        }
        
                    // Update footer
                    $( api.column( 5 ).footer() ).html(
                       "Total Revenue  "+total
                    );
                },
    });

}
$(document).ready(function() {
    $(".js-example-placeholder-multiple").select2({
        placeholder: "Select"
    });
   table_ajax();
  
        
        $('#start_date, #end_date').change( function() {
           // table.draw();
            table_ajax();
        });

     
         $('#property_type').change( function() {
           // table.draw();
           table_ajax();
        });

    

$('.resetFilter').on('click', function(){
       
        $('#start_date,#end_date').val(null);
      
         $("#property_type").val("").trigger( "change" );
         
       table.draw();

    });
});


</script>
@endsection