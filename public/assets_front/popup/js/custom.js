// Write Your Custom JS Here
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("main").style.marginright = "250px";
      document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft= "0";
      document.body.style.backgroundColor = "white";
    }

    //password toggle 

    $(document).ready(function(){
    $(".show-pass-toggle").click(function(e){
        e.preventDefault();
        let input = $(this).parent().find('input.form-control');
        let openEye = $(this).children(".eye-open");
        let closeEye = $(this).children(".eye-closed");

        if(input.attr("type") == "password"){
            input.attr("type", "text");
            openEye.css("display", "none");
            closeEye.css("display", "inline-block");
        }
        
        else{
            input.attr("type", "password")
            openEye.css("display", "inline-block");
            closeEye.css("display", "none");
        }

    })

  // OTP Digit
    $('.digit-group').find('input').each(function() {

        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());

            if (e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));

                if (prev.length) {
                    $(prev).select();
                }
            } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));

                if (next.length) {
                    $(next).select();
                } else {
                    if (parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });

    // gallery slider
       



  
})

	