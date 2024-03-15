
@extends('buyer::layouts.master')
@section('content')
<div class="col-md-8 col-lg-9">
    <div class="profile-box">
        <div class="profile-box-form">
             <h1 class="mb-3">My Pending Subscription Plan</h1>
                     
            <div class="table-responsive total-bookings p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Plan Name</th>
                            <th scope="col">Plan Price</th>
                            <th scope="col">Request Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                          <tr>
                            <td>{{$seller_subscrption_data->name}}</td>
                            <td>{{$seller_subscrption_data->plan_price}}</td>
                            <td>{{date('M d, Y',strtotime($seller_subscrption_data->created_at))}}</td>
                            <td>Pending</td>  
                        
                        </tr>
                            
                    </tbody>
                </table>
                
            </div>
            
        </div>
      
    </div>
</div>
</div>
</main>
@endsection

