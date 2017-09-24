$(function(){

    /////   back-to-top   /////////////////////////////////////////////////////

    $('#back-to-top').tooltip('hide');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 1000) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('#back-to-top').tooltip('show');

    /////   for empty breadcrumb   ////////////////////////////////////////////

    if ($('.breadcrumb li').length == 0) {
        $('ul.breadcrumb').remove();
    }

    /////



});