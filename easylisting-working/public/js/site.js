function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

$(function() {

    // -------------------------------------------------------
    // Navigation
    // -------------------------------------------------------
    $('#nav-main').affix({
        offset: 45 // height of sub nav
    }).on('affix.bs.affix', function() {
        $(this).removeClass('active').addClass('active');
    }).on('affix-top.bs.affix', function() {
        $('#nav-main').fadeIn("slow", function() {
            $(this).removeClass('active');
        });
    });

    // -------------------------------------------------------
    // Scroll to top
    // -------------------------------------------------------
    var offset = 200;
    var duration = 500;
    $(window).scroll(function() {
        // console.log($(this).scrollTop(), $(this).height() - 800);
        if ($(this).scrollTop() > offset) {
            $('.scroll-to-top').fadeIn(duration);
        } else {
            $('.scroll-to-top').fadeOut(duration);
        }
    });

    $('.scroll-to-top').click(function(event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, duration);
        return false;
    });

    $('.tool-tip').tooltip();
    $('#btn-information').tooltip();
    
    $('#btn-subscription').click(function(){
      var $form = $('#subscribe-newsletter-form');
      var data = $form.serialize();

      if (!$form[0].checkValidity())
      {
        //console.log('no pass');
      } else {
        // cancels the form submission
        event.preventDefault();
        // console.log('pass');
        $.post( "/newsletter-subscribe", data)
        .done(function( data ) {
            $('#modal-subscribe-form .thankyou-page').show();
            setTimeout("$('#modal-subscribe-form').modal('hide');",2000);
        },"json");
      }
    });

});