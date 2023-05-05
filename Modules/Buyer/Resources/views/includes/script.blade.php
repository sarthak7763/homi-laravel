
 {{-- <script type="text/javascript" src="{{ asset('assets_front/js/jquery-3.6.0.min.js')}}"></script>--}}
  
    <script src="{{ asset('assets_front/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/intlTelInput.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/script.js')}}"></script>
    <script src="{{ asset('assets_front/timer/jquery.plugin.js')}}"></script>
    <script src="{{ asset('assets_front/timer/jquery.countdown.js')}}"></script>

 <!-- Masking js -->
    <script src="{{ asset('assets_admin/assets/form-masking\inputmask.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\jquery.inputmask.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\autoNumeric.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\form-mask.js')}}"></script>


<script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<!-- Select 2 js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/select2/js/select2.full.min.js')}}"></script>
<!-- Multiselect js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js')}}">

   </script> 
  <script>

$('.logoutBtnA').on('click',function(){
  localStorage.setItem('interested_city_status',"kk");
});

function moneyFormat(num){
  var price=parseFloat(num);
  return price.toLocaleString('en-US');
}
  function sendMarkRequest(id = null) {
        return $.ajax("{{ route('buyer.markBuyerNotification') }}", {
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id:id
            }
        });
    }

    $(function() {
        var counter=$('.count_noifi_badge').html();

        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));
            counter=parseInt(counter) - 1;
            $('.count_noifi_badge').html(counter);

            request.done(() => {
                $(this).parents('li').remove();
                

            });
        });
      

        $('#mark-all').click(function() {
            let request = sendMarkRequest();

            request.done(() => {
                $('div.alert').remove();
            })
        });
    });


    $(document).ready(function(){

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "20",
  "hideDuration": "20",
  "timeOut": "1000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
} 
       $("#loaderDiv").fadeOut("slow");
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select"
        });
    });

  $(".only_number").on('keyup keydown blur', function (event) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });

// Ensures that it is a number and stops the key press
$('.only_number').keydown(function(event) {
    if (!(!event.shiftKey //Disallow: any Shift+digit combination
            && !(event.keyCode < 48 || event.keyCode > 57) //Disallow: everything but digits
            || !(event.keyCode < 96 || event.keyCode > 105) //Allow: numeric pad digits
            || event.keyCode == 46 // Allow: delete
            || event.keyCode == 8  // Allow: backspace
            || event.keyCode == 9  // Allow: tab
            || event.keyCode == 27 // Allow: escape
            || (event.keyCode == 65 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+A
            || (event.keyCode == 67 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+C
            //Uncommenting the next line allows Ctrl+V usage, but requires additional code from you to disallow pasting non-numeric symbols
            //|| (event.keyCode == 86 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+Vpasting 
            || (event.keyCode >= 35 && event.keyCode <= 39) // Allow: Home, End
            )) {
        event.preventDefault();
    }
});

   
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();



</script>
   