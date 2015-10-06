$(window).load(function () {
    var bwrkOnepageNav = $('.tx-bwrk-onepage-menu');

    function getSticky(obj) {
        var menu = obj;
        var stickyClass = 'sticky';
        var body = $('body');

        var menuHeight = menu.outerHeight(true);
        var menuPosition = menu.offset();

        console.log(menuPosition.top);

        $(window).bind('scroll', function(){
           if ($(window).scrollTop() > menuPosition.top) {
               menu.addClass(stickyClass);
               body.css('margin-top', menuHeight);
           }
            else {
               menu.removeClass(stickyClass);
               body.css('margin-top', '0');
           }
        });
    }

    //function updateHash(obj) {
    //    var dataUpdateHash = obj.attr('data-update-hash');
    //
    //    if (dataUpdateHash != undefined) {
    //        return true;
    //    }
    //    else {
    //        return false;
    //    }
    //}

    bwrkOnepageNav.each(function(){
        var self = $(this);

        var dataSticky = self.attr('data-sticky');

        if (dataSticky != undefined) {
            getSticky(self);
        }


    });

    bwrkOnepageNav.singlePageNav({
        offset: 0,
        threshold: 120,
        speed: 400,
        currentClass: 'current',
        easing: 'swing',
        updateHash: true,
        filter: '',
        onComplete: false,
        beforeStart: false
    });
});

// Some code for Saving
//var scrollMenuAnimation = self.attr('data-scroll-animation');
//
//if (scrollMenuAnimation) {
//    var scrollSpeed = scrollMenuAnimation;
//}
//else {
//    var scrollSpeed = 0;
//}
