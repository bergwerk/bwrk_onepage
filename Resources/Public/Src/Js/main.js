$(document).ready(function () {
    $(".tx-bwrk-onepage-menu.scrollable li a").click(function () {
        var speed = parseInt($(this).parents('.scrollable').attr('data-scroll-speed'));
        var href = $(this).attr('href');
        var anchor = href.split('#');
        anchor = anchor[anchor.length - 1];

        if(speed == 0) speed = 2000;

        $('html, body').animate({
            scrollTop: $('#' + anchor).offset().top
        }, speed);

        return false;
    });
});