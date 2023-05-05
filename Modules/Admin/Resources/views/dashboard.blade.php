@extends('admin::layouts.master')
@section('title', 'Dashboard')
@section('css')
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">  
<style>
    span.month {
        padding-right: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 14px;
    }
    span.year {
        padding-right: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 14px;
    }
    .datepicker table tr td span {
        display: block;
        width: 30%;
        height: 45px;
        line-height: 44px;
        float: left;
        margin: 1%;
        cursor: pointer;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
</style>
@endsection
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
             <div class="page-wrapper">
                <div class="page-body">  
                <div class="row">
                 
                  <!-- user card  start -->
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card user-widget-card bg-c-blue">
                                                    <div class="card-block">
                                                        <i class="fa fa-users bg-simple-c-blue card1-icon"></i>
                                                        <h4>{{@$total_users}}</h4>
                                                        <p>Total Buyers</p>
                                                        <a href="{{route('admin-user-list')}}" class="more-info">More Info</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card user-widget-card bg-c-green">
                                                    <div class="card-block">
                                                        <i class="fa fa-building-o bg-simple-c-green card1-icon"></i>
                                                        <h4>{{@$total_property}}</h4>
                                                        <p>Total Property </p>
                                                        <a href="{{route('admin-property-list')}}" class="more-info">More Info</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card user-widget-card bg-c-pink">
                                                    <div class="card-block">
                                                        <i class="fa fa-home bg-simple-c-pink card1-icon"></i>
                                                        <h4>{{@$pending_property}}</h4>
                                                        <p>Pending Property</p>
                                                        <a href="{{route('admin-pending-property-list')}}" class="more-info">More Info</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card user-widget-card bg-c-yellow">
                                                    <div class="card-block">
                                                        <i class="fa fa-gavel bg-simple-c-yellow card1-icon"></i>
                                                        <h4>{{@$bids}}</h4>
                                                        <p>Total Bids</p>
                                                        <a href="{{route('admin-bid-list')}}" class="more-info">More Info</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- user card  end -->

                </div>

                    <div class="row nw_theme">
                      
                       {{--<div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green text-white nw-ablock">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Sold Property</p>
                                            <h4 class="m-b-0">{{@$sold_property}}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                           <i class="fa fa-building-o f-50 text-c-green"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-c-green text-white nw-bblock">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Property Offer</p>
                                            <h4 class="m-b-0">{{@$property_offer}}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <a href="{{route('admin-property-sales-list')}}"><i class="fa fa-building-o f-50 text-c-green"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-xl-4 col-md-6">
                            <div class="card bg-c-yellow text-white nw_dblock">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Active Property</p>
                                            <h4 class="m-b-0">{{@$active_property}}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <a href="{{route('admin-active-property-list')}}"><i class="fa fa-building-o f-50 text-c-yellow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-c-blue text-white nw_cblock">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Feedback</p>
                                            <h4 class="m-b-0">{{@$enquiry}}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <a href="{{route('admin-user-enquiry-list')}}"><i class="fa fa-comments f-50 text-c-blue"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<div class="col-xl-4 col-md-6">
                            <div class="card bg-c-yellow text-white nw_dblock">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Complaints</p>
                                            <h4 class="m-b-0">{{@$complaints}}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <a href="{{route('admin-user-complaint-list')}}"><i class="fa fa-exclamation-triangle f-50 text-c-yellow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                      
                    </div> 
                    <div class="row">
                        <div class="col-md-4 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4><b>Buyers</b></h4>
                                    <span></span>

                                </div>
                       
                        
                                <div class="card-block">
                                    <canvas id="pieChart" width="400" height="320"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4><b>Total Revenue</b></h4>
                                    <span></span>

                                </div>

                                <div class="card-block">

                            <div class="actionlign-items-center">
                                <form class="form-horizontal" id="RevenueGraph" action="{{route('admin-revenue-graph-post')}}" enctype="multipart/form-data">
                               @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                     <div class="form-wrap">
                                     <!--    <label for="graph_filters">Choose Type:</label> -->
                                        <select name="graph_filters" class="form-control"  id="graph_filters">                                           
                                            <option value="current">Current Year</option>
                                            <option value="yearly">Yearly </option>
                                            <option value="monthly">Monthly </option>
                                            <option value="weekly">Weekly </option>
                                        </select> 
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                     <input type="text"  autocomplete="off" placeholder = "enter your range" class="form-control" name="daterangepicker" id="daterangepicker" value="{{@$request->daterangepicker}}" onkeydown="return false"/>
                                    </div>
                                    <div class="col-md-3">
                                       <input type="text" autocomplete="off" placeholder="enter your range" class="form-control" name="daterangepicker1" id="daterangepicker1" value="{{@$request->daterangepicker1}}" onkeydown="return false"/>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="submit" class="btn btn-primary" onclick="searchProjectsRep()">Apply</button>
                                    </div>
                                    
                                </div>
                                </form> 
                            </div>
                                    <canvas id="barChart" width="600" height="200"></canvas>
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
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>

//----------------------------------------------------------
var myBarChart;
function searchProjectsRep() {
   // TRIGGERING THIS FUNCTION IN THE ONSUBMIT EVENT OF THE FORM
   var datos = $('#RevenueGraph').serialize();
   var uri = $('#RevenueGraph').attr('action');
    $.ajax({
        url: uri,
        data: datos,
        type: 'POST',
        success: function(resp) {
            var graphData = {
                labels: resp.result.month,
                datasets: [{
                    label: "Total Revenue",
                    backgroundColor: [
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)'
                    ],
                    data: resp.result.total,
                 }]
            };
            //Create GRAPH
            graph(graphData);
        }
    });
}

function graph(datas){
    var bar = document.getElementById("barChart").getContext('2d');
    if(myBarChart) {
        myBarChart.destroy();
    }
    
    myBarChart = new Chart(bar, {
        type: 'bar',
        data: datas,
        options: {
            barValueSpacing: 20
        }
    });  
}

$( document ).ready(function() {
    var result = JSON.parse(`<?php echo $sales_data; ?>`);
    var data2 = {
                labels: result.month,
                datasets: [{
                    label: "Total Revenue",
                    backgroundColor: [
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)',
                        'rgba(95, 190, 170, 0.99)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)',
                        'rgba(26, 188, 156, 0.88)'
                    ],
                    data: result.total,
                 }]
            };
    graph(data2);
});

$(document).ready(function () {
    $("select").change(function () {
        $(this).find("option:selected")
               .each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 'current') {
                $("#daterangepicker,#daterangepicker1,#submit").hide();
            } 
        });
    }).change();
});

   
$('select').on('change', function() {
    var value = this.value;
    $("#daterangepicker,#daterangepicker1").val('');
    $("#daterangepicker,#daterangepicker1").datepicker("remove");
    $("#daterangepicker,#daterangepicker1").val('');
    var first = $('#daterangepicker');
    var second = $('#daterangepicker1');
    if (value == 'current') {
        $("#daterangepicker,#daterangepicker1").prop('disabled', true);
        $("#submit").prop('disabled', true);
        $("#daterangepicker,#daterangepicker1,#submit").hide();
    }
    if (value == 'yearly') {
        $("#daterangepicker,#daterangepicker1,#submit").prop('disabled', false);
        $("#daterangepicker,#daterangepicker1,#submit").show();
        first.attr('placeholder','choose start year');
        second.attr('placeholder','choose end year');
        $('#daterangepicker,#daterangepicker1').datepicker(
        {
            format: "yyyy",
            startView: "years", 
            minViewMode: "years"
            
        });
    }
    if (value == 'monthly') {
        $("#daterangepicker,#daterangepicker1,#submit").prop('disabled', false);
        $("#daterangepicker,#daterangepicker1,#submit").show();
        first.attr('placeholder','choose start month');
        second.attr('placeholder','choose end month');
        $('#daterangepicker,#daterangepicker1').datepicker(
        {
            format: "mm-yyyy",
            startView: "months", 
            minViewMode: "months"
            
        });
    }
    if (value == 'weekly') {
        $("#daterangepicker,#submit").prop('disabled', false);
        $("#daterangepicker,#submit").show();
        //$("#daterangepicker1").prop('disabled', true);
        first.attr('placeholder','choose start date');
        $('#daterangepicker').datepicker(
        {
            format: "yyyy-mm-dd",
            startView: "dates", 
            minViewMode: "dates"
        });
        $("#daterangepicker1").click(function(){
            var startDateVal =  $("#daterangepicker").val();
            var myDate = new Date(startDateVal);
            var myDate1 = new Date(myDate.getTime()+(6*24*60*60*1000));
            var aa =   $("#daterangepicker1").val($.datepicker.formatDate('yy-mm-dd', myDate1));
            $("#daterangepicker1").prop('disabled', true);
        });
    }
});
    
/*Pie chart*/
var pieElem = document.getElementById("pieChart");
var data4 = {
    labels: [
        "Active User",
        "Inactive User",
       // "Sea Green"
    ],
    datasets: [{
        data: [{{$active_user }},{{$inactive_user}} ],
        backgroundColor: [
            "#25A6F7",
            "#FB9A7D",
           // "#01C0C8"
        ],
        hoverBackgroundColor: [
            "#6cc4fb",
            "#ffb59f",
           // "#0dedf7"
        ]
    }]
};

var myPieChart = new Chart(pieElem, {
    type: 'pie',
    data: data4
});
</script>
@endsection