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
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    /////   for empty breadcrumb   ////////////////////////////////////////////

    if ($('.breadcrumb li').length == 0) {
        $('ul.breadcrumb').remove();
    }

    /////   for left bar vertical menu   //////////////////////////////////////

    if ($(document).width() < 768) {
        $('ul.menu_vert').removeClass('menu_vert').addClass('topnav');
        $('div.admin-breadcrumb').removeClass('pull-right').addClass('pull-left');;
        $('#left-aside').append('<br><br>');
    } else {
        $('.menu_vert').liMenuVert({
            delayShow:300,		//Задержка перед появлением выпадающего меню (ms)
            delayHide:300	    //Задержка перед исчезанием выпадающего меню (ms)
        });
    }

    /////  In order did not work parent element a  ////////////////////////////

    $('ul.menu_vert li a').on('click', function(){
        if ($(this).parent('li').has('ul').length != 0) {
            return false;
        }
    });

    /////  menu accordion   ///////////////////////////////////////////////////

    if ($(".topnav").length > 0) {
        $(".topnav").accordion({
            accordion:true,
            speed: 300,
            closedSign: '<span class="caret"></span>',
            openedSign: '<span class="dropup"><span class="caret"></span></span>'
        });
    }

    /////  In order don't work link witch has children   //////////////////////

    $('ul.topnav li a').on('click', function(){
        if ($(this).parent('li').has('ul').length != 0) {
            return false;
        }
    });

    /////   For register form   ///////////////////////////////////////////////

    if ($(document).width() > 768) {
        $('#form-register div.col-sm-3').addClass('text-right');

        $('#form-register .app-captcha img').addClass('col-sm-6');
        $('#form-register .app-captcha input[type="text"]').addClass('col-s-6');
        $('.captcha-box').addClass('row');
    } else {
        $('#form-register .app-captcha img').css('marginBottom', '10px');
    }

    $('#form-register .app-captcha input[type="text"]').addClass('form-control')
                                                       .attr('id', 'captcha')
                                                       .css('width', 'auto');

    /////

});