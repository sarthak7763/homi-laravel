<!-- Required Jquery -->


<script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery/js/jquery.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets_admin/bower_components/popper.js/js/popper.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets_admin/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>

<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/modernizr/js/modernizr.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/modernizr/js/css-scrollbars.js')}}"></script>


<!-- Select 2 js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/select2/js/select2.full.min.js')}}"></script>
<!-- Multiselect js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js')}}">
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js">  
</script>  

<!-- Date-range picker js --> {{--

<!-- Bootstrap date-time-picker js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script> --}}
<!-- data-table js -->
<script src="{{ asset('assets_admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets_admin/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets_admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets_admin/bower_components/jquery-validation/js/jquery.validate.js')}}"></script>

<!-- Validation js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

  <!-- jquery file upload js -->
    <script src="{{ asset('assets_admin/jquery.filer/js/jquery.filer.min.js')}}"></script>
    <script src="{{ asset('assets_admin/jquery.filer/custom-filer.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets_admin/jquery.filer/jquery.fileuploads.init.js')}}" type="text/javascript"></script>

  <script type="text/javascript" src="{{ asset('assets_admin/bower_components/lightbox2/js/lightbox.min.js')}}"></script> 




   <!-- Masking js -->
    <script src="{{ asset('assets_admin/assets/form-masking\inputmask.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\jquery.inputmask.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\autoNumeric.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\form-mask.js')}}"></script>
<!-- i18next.min.js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/i18next/js/i18next.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery-i18next/js/jquery-i18next.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_admin/sweetalert.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script src="{{ asset('toastr.min.js')}}"></script>
<!-- Chart js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/chart.js/js/Chart.js')}}"></script>  


<!-- Custom js -->
<script src="{{ asset('assets_admin/assets/js/pcoded.min.js')}}"></script>
<script src="{{ asset('assets_admin/assets/js/vartical-layout.min.js')}}"></script>
  <script src="{{ asset('assets_admin/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Custom js -->
<script type="text/javascript" src="{{ asset('assets_admin/assets/js/script.js')}}"></script>
   <script type="text/javascript" src="{{ asset('assets_admin/assets/chartjs/chartjs-custom.js')}}"></script>

<script type="text/javascript">

 $(document).ready(function () {
  $(".only_number").on('keyup keydown blur', function (event) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });
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



$('.only_alpha').keyup(function () {
     this.value = this.value.replace(/[^A-Za-z ]/g, "");
 });

 
function moneyFormat(num){
  var price=parseFloat(num);
  if(num>0){
    return "$"+price.toLocaleString('en-US');
  }else if(num < 0){
    var p=Math.abs(price);
    return "-$"+p.toLocaleString('en-US');
  }else{
    return "$"+price.toLocaleString('en-US');
  }
 
}

</script>
   