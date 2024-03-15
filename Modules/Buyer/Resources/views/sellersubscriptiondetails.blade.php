@extends('buyer::layouts.master') @section('content')
<style>
    .card.box h6 {
    background: #174c6c !important;
    }
    input{border: 0;border-bottom: 1px solid #ddd;width: 100%;margin-top: 15px}
    input:focus{outline: none;}
    .invalid-feedback {
    position: absolute;
    bottom: 0;
    left: 10px;
}
</style>
<div class="col-md-12 col-lg-9">
    <div class="profile-box">
        <div class="profile-box-form">
            <h1 class="mb-3"> Seller Subscription Details</h1>

            
            <section class="section-subscription">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card box mb-3 w-100">
                            <h6 class="rounded-top border-bottom p-3 mb-0 text-white">If you want to purchase this subscription then please transfer funds to below account  number </h6>
                            <div class="p-3">
                                <div class="border-bottom py-2 d-sm-flex justify-content-between ">
                                    <strong><label> Account Number</label></strong>
                                    <p class="mb-0">{{$homi_account_number->option_value}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card box mb-3 w-100">
                            <h6 class="rounded-top border-bottom p-3 mb-0 text-white">  Also send proof of transfer to homi using one of the options given below </h6>
                            <div class="p-3">
                                <div class="border-bottom py-2 d-sm-flex justify-content-between ">
                                    <strong><label> Homi Whatsapp No</label></strong>
                                    <p class="mb-0">{{$homi_whatsapp_number->option_value}}</p>
                                </div>
                                <div class="border-bottom py-2 d-sm-flex justify-content-between ">
                                    <strong><label> Homi Email</label></strong>
                                    <p class="mb-0">{{$homi_email->option_value}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card box mb-3">
                    
                    <form method="post" action="{{route('seller.subscription-details-save')}}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-sec">
                            <h6 class="rounded-top border-bottom p-3 mb-0 text-white">If you want to take subscription then please fill below details:- </h6>
                            <div class="p-3">
                                <div class="row">
                                    <div class="pt-2 pb-4 col-sm-6 error-fix">
                                    <input type = "hidden" value="{{$subscription_plan_details->id}}" name="hidden_id">
                                    <label><strong>Fund Amount</strong></label>
                                        <input type="number" name=fund_amount value="{{$subscription_plan_details->plan_price}}" class="form-control @error('fund_amount') is-invalid @enderror" id="fund_amount" value=""> 
                                        @error('fund_amount')
                                        <div class="invalid-feedback" style="display:block;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="pt-2 pb-4 col-sm-6 fund-label error-fix position-relative">
                                        <label><strong> Fund Image</strong></label>
                                        <span class="file-input"></span>
                                        
                                        <input type="file" name=fund_image src=""  class="form-control @error('fund_image') is-invalid @enderror" id="fund_image"> 
                                        @error('fund_image')
                                        <div class="invalid-feedback" style="display:block;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                       
                                    </div>
                                    <div class="col-md-6 ml-auto mb-2 justify-content-center offset-md-6">
                                        <img id="fund_image_preview" src="#"
                                        alt="" style="max-height:150px;">
                                    </div>
                                    <div class="col-md-12 d-flex text-center py-4 gap-2 justify-content-center">
                                        <button button type="submit" class="btn btn-primary  m-0  plan-btn text-white px-3">Activate Plan</button>
                                        <a href ="{{route('buyer.subscription-plans')}}" button type="button" class="btn btn-danger cancel_btn  mx-0 mt-0 px-3">Back</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
        </section>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection

