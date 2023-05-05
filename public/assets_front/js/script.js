$(document).ready(function() {

    //Sticky Header

    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 200) {
            $("header").addClass("sticky-header");
        } else {
            $("header").removeClass("sticky-header");
        }
    });

    // Outside Click Remove Class Script
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.main-nav-left').length) {
            $('.main-nav-left').removeClass('active');
        }
    });


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

});


// Upload Profile Image Script

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profileImg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#profileImageUpload").change(function() {
    readURL(this);
});



function printName(name){
    return (
            "My name is" + name
        )
}


console.log(printName("Manish"));
