
@extends('buyer::layouts.master')
@section('content')
<div class="col-md-8 col-lg-9">
    <div class="profile-box">
        <div class="profile-box-form">
             <h1 class="mb-3">My Subscription Pending Plan History</h1>
                     
            <div class="table-responsive total-bookings p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            
                            <th scope="col">Plan Name</th>
                            <th scope="col">Plan Price</th>
                            <th scope="col">Plan Duration</th>
                            <th scope="col">Fund Amount</th>
                            <th scope="col">Fund Image</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    
                    
                        <tr>
                            
                            <td>{{$seller_subscription_data->name}}</td>
                            <td>{{$seller_subscription_data->plan_price}}</td>
                            <td>{{$seller_subscription_data->plan_duration}}</td>
                           
                            <td>{{$seller_subscription_data->fund_amount}}</td>
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

