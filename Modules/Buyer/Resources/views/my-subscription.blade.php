
@extends('buyer::layouts.master')
@section('content')
<div class="col-md-8 col-lg-9">
    <div class="profile-box">
        <div class="profile-box-form">
             <h1 class="mb-3">My Subscription Plan History</h1>
             @if(!empty($user_subscription_plan_array))         
            <div class="table-responsive total-bookings p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Sr.no</th>
                            <th scope="col">Plan Name</th>
                            <th scope="col">Plan Price</th>
                            
                            <th scope="col">Staring Date</th>
                            <th scope="col">Expire Date</th>
                            <th scope="col">Plan Status</th>
                          </tr>
                    </thead>
                    <tbody>
                    
                        @foreach($user_subscription_plan_array as $user_subscription)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$user_subscription->name}}</td>
                            <td>{{$user_subscription->plan_price}}</td>
                            <td>
                            {{date('M d, Y',strtotime($user_subscription->starting_date))}}
                            </td>
                            <td>{{date('M d, Y',strtotime($user_subscription->ending_date))}}</td>
                            
                            <td>
                              @if($user_subscription->subscription_status==0)
                              {{'Deactivated'}}
                              @else
                              {{'Activated'}}
                              @endif
                            </td>
                          </tr>
                        @endforeach    
                    </tbody>
                </table>
                
            </div>
            @else
            <div class ="no-data-box">
                <center>
                    <h2>{{'No Data Found '}}</h2>
                </center>
            </div>
            @endif
        </div>
      
    </div>
</div>
</div>
</main>
@endsection

