$(document).ready(function() {
    $('a[data-bwrkonepage-id]').click(function () {
        var anchor = '#' + $(this).attr('data-bwrkonepage-id');
        var section = $('section' + anchor);
        if (section.length > 0) {
            $('html, body').animate({
                'scrollTop': section.position().top
            }, 1500);
            return false;
        } else {
            return true;
        }
    });
});