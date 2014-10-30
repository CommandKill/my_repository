$(function() {

    $('#slider-menu-btn').sidr({
        side: 'right'
    });

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
});