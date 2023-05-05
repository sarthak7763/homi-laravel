@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi Sign up")
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
<style type="text/css">
.phone_number_sec .intl-tel-input {
    width: 100%;
}

.phone_number_sec .form-group .form-control {
    padding-left: 80px;
}

.phone_number_sec .flag-box {
    display: inline-block;
    vertical-align: middle;
}

.phone_number_sec .country .country-name,
.phone_number_sec .country .country-dial-code {
    overflow: hidden;
    padding-left: 15px;
}
</style>
@endsection
@section('content')
<div class="row">

    <section class="signup-section pt-4 pb-4">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-12">
                    <form action="{{ route('buyer.post.register') }}" method="POST" class="signup-form p-5">
                        <h1>Welcome!</h1>
                        <strong>Signup your account</strong>
                        <div class="mb-4">
                            <input type="text" name="name" class="form-control" id=""
                                aria-describedby="emailHelp" placeholder="Enter your name here">
                        </div>
                        <div class="mb-4">
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Email ID">
                        </div>
                        <div class="mb-4 input-group">
                            <input type="password"name="password" class="form-control" id="password" placeholder="Password">
                            <span toggle="#password" class="input-group-text togglePassword" id="">
                                <svg class="eyeopen" width="20" height="14" viewBox="0 0 20 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.7498 7C12.7498 8.51883 11.5185 9.75 9.99979 9.75C8.48097 9.75 7.24976 8.51883 7.24976 7C7.24976 5.48117 8.48097 4.25 9.99979 4.25C11.5185 4.25 12.7498 5.48117 12.7498 7Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.25317 7.00001C2.42125 3.28098 5.89569 0.583344 10.0002 0.583344C14.1046 0.583344 17.5791 3.28101 18.7472 7.00001C17.5791 10.719 14.1046 13.4167 10.0002 13.4167C5.89568 13.4167 2.42124 10.719 1.25317 7.00001Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>


                                <svg class="eyeclose" width="20" height="18" viewBox="0 0 20 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path class="eyeclose"
                                        d="M11.8119 15.7471C12.0832 15.6956 12.2614 15.434 12.2099 15.1627C12.1584 14.8914 11.8968 14.7132 11.6255 14.7646L11.8119 15.7471ZM1.25342 9L0.776393 8.85018C0.74576 8.94771 0.74576 9.05229 0.776393 9.14982L1.25342 9ZM3.08504 6.5253C3.25167 6.3051 3.20825 5.99151 2.98805 5.82488C2.76786 5.65824 2.45427 5.70166 2.28763 5.92186L3.08504 6.5253ZM7.70194 6.70189C7.50667 6.89715 7.50666 7.21373 7.70192 7.409C7.89717 7.60427 8.21376 7.60428 8.40902 7.40902L7.70194 6.70189ZM11.591 10.591C11.3957 10.7862 11.3957 11.1028 11.591 11.2981C11.7863 11.4933 12.1028 11.4933 12.2981 11.2981L11.591 10.591ZM8.40903 6.7019C8.21377 6.50664 7.89719 6.50664 7.70193 6.7019C7.50666 6.89717 7.50666 7.21375 7.70193 7.40901L8.40903 6.7019ZM11.591 11.2981C11.7863 11.4933 12.1028 11.4933 12.2981 11.2981C12.4934 11.1028 12.4934 10.7862 12.2981 10.591L11.591 11.2981ZM7.70193 7.40901C7.89719 7.60427 8.21377 7.60427 8.40903 7.40901C8.60429 7.21375 8.60429 6.89717 8.40903 6.7019L7.70193 7.40901ZM5.39364 3.68651C5.19838 3.49125 4.88179 3.49125 4.68653 3.68651C4.49127 3.88177 4.49127 4.19835 4.68653 4.39362L5.39364 3.68651ZM12.2981 10.591C12.1028 10.3957 11.7863 10.3957 11.591 10.591C11.3957 10.7862 11.3957 11.1028 11.591 11.2981L12.2981 10.591ZM14.6067 14.3138C14.802 14.5091 15.1186 14.5091 15.3138 14.3138C15.5091 14.1186 15.5091 13.802 15.3138 13.6067L14.6067 14.3138ZM2.10358 0.396447C1.90831 0.201184 1.59173 0.201184 1.39647 0.396447C1.20121 0.591709 1.20121 0.908291 1.39647 1.10355L2.10358 0.396447ZM4.68653 4.39362C4.88179 4.58888 5.19838 4.58888 5.39364 4.39362C5.5889 4.19835 5.5889 3.88177 5.39364 3.68651L4.68653 4.39362ZM4.76916 3.61983C4.53707 3.76946 4.47022 4.0789 4.61985 4.31099C4.76948 4.54308 5.07892 4.60993 5.31101 4.4603L4.76916 3.61983ZM18.7474 9L19.2244 9.14982C19.2551 9.05229 19.2551 8.94771 19.2244 8.85018L18.7474 9ZM14.6894 13.54C14.4573 13.6896 14.3904 13.9991 14.54 14.2312C14.6897 14.4633 14.9991 14.5301 15.2312 14.3805L14.6894 13.54ZM15.3138 13.6067C15.1186 13.4115 14.802 13.4115 14.6067 13.6067C14.4115 13.802 14.4115 14.1186 14.6067 14.3138L15.3138 13.6067ZM17.8965 17.6036C18.0917 17.7988 18.4083 17.7988 18.6036 17.6036C18.7988 17.4083 18.7988 17.0917 18.6036 16.8964L17.8965 17.6036ZM11.6255 14.7646C11.0995 14.8644 10.5563 14.9167 10.0005 14.9167V15.9167C10.6191 15.9167 11.2247 15.8585 11.8119 15.7471L11.6255 14.7646ZM10.0005 14.9167C6.12057 14.9167 2.83494 12.3668 1.73044 8.85017L0.776393 9.14982C2.00804 13.0712 5.67129 15.9167 10.0005 15.9167V14.9167ZM1.73044 9.14982C2.03093 8.19311 2.49303 7.3076 3.08504 6.5253L2.28763 5.92186C1.62762 6.79402 1.11189 7.78198 0.776393 8.85018L1.73044 9.14982ZM8.40902 7.40902C8.81677 7.00129 9.37859 6.75 10 6.75V5.75C9.10272 5.75 8.28954 6.11432 7.70194 6.70189L8.40902 7.40902ZM10 6.75C11.2427 6.75 12.25 7.75732 12.25 9H13.25C13.25 7.20503 11.795 5.75 10 5.75V6.75ZM12.25 9C12.25 9.62142 11.9987 10.1832 11.591 10.591L12.2981 11.2981C12.8857 10.7105 13.25 9.89731 13.25 9H12.25ZM7.70193 7.40901L11.591 11.2981L12.2981 10.591L8.40903 6.7019L7.70193 7.40901ZM8.40903 6.7019L5.39364 3.68651L4.68653 4.39362L7.70193 7.40901L8.40903 6.7019ZM11.591 11.2981L14.6067 14.3138L15.3138 13.6067L12.2981 10.591L11.591 11.2981ZM1.39647 1.10355L4.68653 4.39362L5.39364 3.68651L2.10358 0.396447L1.39647 1.10355ZM5.31101 4.4603C6.66251 3.58899 8.27169 3.08333 10.0004 3.08333V2.08333C8.07379 2.08333 6.27733 2.6475 4.76916 3.61983L5.31101 4.4603ZM10.0004 3.08333C13.8803 3.08333 17.1659 5.63323 18.2704 9.14982L19.2244 8.85018C17.9928 4.92877 14.3296 2.08333 10.0004 2.08333V3.08333ZM18.2704 8.85018C17.658 10.7999 16.3743 12.4539 14.6894 13.54L15.2312 14.3805C17.109 13.17 18.5408 11.3264 19.2244 9.14982L18.2704 8.85018ZM14.6067 14.3138L17.8965 17.6036L18.6036 16.8964L15.3138 13.6067L14.6067 14.3138Z"
                                        fill="white" />
                                </svg>
                            </span>
                        </div>


                        <div class="mb-4 input-group">
                            <input type="password" name="password" class="form-control" id="confirm_password" placeholder="Password">
                            <span toggle="#confirm_password" class="input-group-text togglePassword2" id="">
                                <svg class="eyeopen" width="20" height="14" viewBox="0 0 20 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.7498 7C12.7498 8.51883 11.5185 9.75 9.99979 9.75C8.48097 9.75 7.24976 8.51883 7.24976 7C7.24976 5.48117 8.48097 4.25 9.99979 4.25C11.5185 4.25 12.7498 5.48117 12.7498 7Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.25317 7.00001C2.42125 3.28098 5.89569 0.583344 10.0002 0.583344C14.1046 0.583344 17.5791 3.28101 18.7472 7.00001C17.5791 10.719 14.1046 13.4167 10.0002 13.4167C5.89568 13.4167 2.42124 10.719 1.25317 7.00001Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>


                                <svg class="eyeclose" width="20" height="18" viewBox="0 0 20 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path class="eyeclose"
                                        d="M11.8119 15.7471C12.0832 15.6956 12.2614 15.434 12.2099 15.1627C12.1584 14.8914 11.8968 14.7132 11.6255 14.7646L11.8119 15.7471ZM1.25342 9L0.776393 8.85018C0.74576 8.94771 0.74576 9.05229 0.776393 9.14982L1.25342 9ZM3.08504 6.5253C3.25167 6.3051 3.20825 5.99151 2.98805 5.82488C2.76786 5.65824 2.45427 5.70166 2.28763 5.92186L3.08504 6.5253ZM7.70194 6.70189C7.50667 6.89715 7.50666 7.21373 7.70192 7.409C7.89717 7.60427 8.21376 7.60428 8.40902 7.40902L7.70194 6.70189ZM11.591 10.591C11.3957 10.7862 11.3957 11.1028 11.591 11.2981C11.7863 11.4933 12.1028 11.4933 12.2981 11.2981L11.591 10.591ZM8.40903 6.7019C8.21377 6.50664 7.89719 6.50664 7.70193 6.7019C7.50666 6.89717 7.50666 7.21375 7.70193 7.40901L8.40903 6.7019ZM11.591 11.2981C11.7863 11.4933 12.1028 11.4933 12.2981 11.2981C12.4934 11.1028 12.4934 10.7862 12.2981 10.591L11.591 11.2981ZM7.70193 7.40901C7.89719 7.60427 8.21377 7.60427 8.40903 7.40901C8.60429 7.21375 8.60429 6.89717 8.40903 6.7019L7.70193 7.40901ZM5.39364 3.68651C5.19838 3.49125 4.88179 3.49125 4.68653 3.68651C4.49127 3.88177 4.49127 4.19835 4.68653 4.39362L5.39364 3.68651ZM12.2981 10.591C12.1028 10.3957 11.7863 10.3957 11.591 10.591C11.3957 10.7862 11.3957 11.1028 11.591 11.2981L12.2981 10.591ZM14.6067 14.3138C14.802 14.5091 15.1186 14.5091 15.3138 14.3138C15.5091 14.1186 15.5091 13.802 15.3138 13.6067L14.6067 14.3138ZM2.10358 0.396447C1.90831 0.201184 1.59173 0.201184 1.39647 0.396447C1.20121 0.591709 1.20121 0.908291 1.39647 1.10355L2.10358 0.396447ZM4.68653 4.39362C4.88179 4.58888 5.19838 4.58888 5.39364 4.39362C5.5889 4.19835 5.5889 3.88177 5.39364 3.68651L4.68653 4.39362ZM4.76916 3.61983C4.53707 3.76946 4.47022 4.0789 4.61985 4.31099C4.76948 4.54308 5.07892 4.60993 5.31101 4.4603L4.76916 3.61983ZM18.7474 9L19.2244 9.14982C19.2551 9.05229 19.2551 8.94771 19.2244 8.85018L18.7474 9ZM14.6894 13.54C14.4573 13.6896 14.3904 13.9991 14.54 14.2312C14.6897 14.4633 14.9991 14.5301 15.2312 14.3805L14.6894 13.54ZM15.3138 13.6067C15.1186 13.4115 14.802 13.4115 14.6067 13.6067C14.4115 13.802 14.4115 14.1186 14.6067 14.3138L15.3138 13.6067ZM17.8965 17.6036C18.0917 17.7988 18.4083 17.7988 18.6036 17.6036C18.7988 17.4083 18.7988 17.0917 18.6036 16.8964L17.8965 17.6036ZM11.6255 14.7646C11.0995 14.8644 10.5563 14.9167 10.0005 14.9167V15.9167C10.6191 15.9167 11.2247 15.8585 11.8119 15.7471L11.6255 14.7646ZM10.0005 14.9167C6.12057 14.9167 2.83494 12.3668 1.73044 8.85017L0.776393 9.14982C2.00804 13.0712 5.67129 15.9167 10.0005 15.9167V14.9167ZM1.73044 9.14982C2.03093 8.19311 2.49303 7.3076 3.08504 6.5253L2.28763 5.92186C1.62762 6.79402 1.11189 7.78198 0.776393 8.85018L1.73044 9.14982ZM8.40902 7.40902C8.81677 7.00129 9.37859 6.75 10 6.75V5.75C9.10272 5.75 8.28954 6.11432 7.70194 6.70189L8.40902 7.40902ZM10 6.75C11.2427 6.75 12.25 7.75732 12.25 9H13.25C13.25 7.20503 11.795 5.75 10 5.75V6.75ZM12.25 9C12.25 9.62142 11.9987 10.1832 11.591 10.591L12.2981 11.2981C12.8857 10.7105 13.25 9.89731 13.25 9H12.25ZM7.70193 7.40901L11.591 11.2981L12.2981 10.591L8.40903 6.7019L7.70193 7.40901ZM8.40903 6.7019L5.39364 3.68651L4.68653 4.39362L7.70193 7.40901L8.40903 6.7019ZM11.591 11.2981L14.6067 14.3138L15.3138 13.6067L12.2981 10.591L11.591 11.2981ZM1.39647 1.10355L4.68653 4.39362L5.39364 3.68651L2.10358 0.396447L1.39647 1.10355ZM5.31101 4.4603C6.66251 3.58899 8.27169 3.08333 10.0004 3.08333V2.08333C8.07379 2.08333 6.27733 2.6475 4.76916 3.61983L5.31101 4.4603ZM10.0004 3.08333C13.8803 3.08333 17.1659 5.63323 18.2704 9.14982L19.2244 8.85018C17.9928 4.92877 14.3296 2.08333 10.0004 2.08333V3.08333ZM18.2704 8.85018C17.658 10.7999 16.3743 12.4539 14.6894 13.54L15.2312 14.3805C17.109 13.17 18.5408 11.3264 19.2244 9.14982L18.2704 8.85018ZM14.6067 14.3138L17.8965 17.6036L18.6036 16.8964L15.3138 13.6067L14.6067 14.3138Z"
                                        fill="white" />
                                </svg>

                            </span>
                        </div>



                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                            <label class="form-check-label" for="exampleCheck1">I Accept <a href="#">Terms and
                                    Conditions</a></label>
                        </div>
                        <button type="submit"  class="btn btn-primary">Signup</button>
                        <div class="signup-footer mt-5 text-center">
                            <p>Already have an account? <a href="{{url('/')}}/dealer/login">Sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
@section('js')
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

$(document).on("click", "#btnSignup", function() {

    $('form[name=signupBuyerForm]').validate({
        rules: {
            name: {
                required: true,
                maxlength: 30
            },

            email: {
                required: true,
                email: true,
                remote: {
                    url: "{{route('buyer-sign-up-email-check')}}",

                    type: "POST",

                    data: {

                        email: function() {
                            return $('#buyerSignupForm :input[name="email"]').val();
                        },

                    }
                }
            },
            mobile_no: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 13,
                remote: {
                    url: "{{route('buyer-sign-up-mobile-check')}}",
                    type: "post",
                    data: {

                        mobile_no: function() {
                            return $('#buyerSignupForm :input[name="mobile_no"]').val();

                        }

                    }
                }
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                minlength: 5,
                equalTo: "#password"
            },
            'city[]': {
                required: true,
            },

        },
        messages: {
            // first_name: {
            //     required: "Please specify your first name",
            //     maxlength:"Name length should be maximum 30 characters long"
            // },
            name: {
                required: "Please specify your name",
                maxlength: "Name length should be maximum 30 characters long"
            },
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote: "Email already exist"
            },
            mobile_no: {
                required: "We need your mobile number to contact you",
                digits: "Your mobile number must be in digits",
                minlength: "Your mobile number have minimum 6 digits",
                maxlength: "Your mobile number have maximum 13 digits",
                remote: "Mobile number already exist"
            },
            password: {
                required: "Password field is required",
                minlength: "Password must be atleast 5 characters long"

            },
            password_confirmation: {
                required: "Confirm password field is required",
                equalTo: "Confirm password must be same as password",

            },
            'city[]': {
                required: "Select at least one city",

            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
@endsection