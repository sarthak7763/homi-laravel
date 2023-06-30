<script type="text/javascript" src="{{asset('assets_front/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets_front/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets_front/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets_front/js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets_front/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets_front/js/intlTelInput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets_front/js/script.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets_front/js/jquery.validate.js')}}"></script>

   </script> 

<script>
  $("body").on('click', '.togglePassword', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  $("body").on('click', '.togglePassword2', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#confirm_password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>

