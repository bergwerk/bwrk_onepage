$(window).load(function () {
    var bwrkOnepageNav = $('.tx-bwrk-onepage-menu');

    function getSticky(obj) {
        var menu = obj;
        var stickyClass = 'sticky';
        var body = $('body');

        var menuHeight = menu.outerHeight(true);
        var menuPosition = menu.offset();

        $(window).bind('scroll', function () {
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

    bwrkOnepageNav.each(function () {
        var self = $(this);

        var dataSticky = self.attr('data-sticky');

        var offsetHeight = 0;
        if (dataSticky != undefined) {
            getSticky(self);
            offsetHeight = parseInt(self.outerHeight());
        }

        var scrollSpeed = 0;
        var dataScrollSpeed = self.attr('data-scroll-speed');
        if (dataScrollSpeed) {
            scrollSpeed = parseInt(dataScrollSpeed);
        }

        var threshold = 120;
        var dataThreshold = self.attr('data-threshold');
        if (dataThreshold) {
            threshold = parseInt(dataThreshold);
        }

        var updateHash = false;
        var dataUpdateHash = self.attr('data-update-hash');
        if (dataUpdateHash != undefined) {
            updateHash = true;
        }

        bwrkOnepageNav.singlePageNav({
            offset: 60,
            threshold: threshold,
            speed: scrollSpeed,
            currentClass: 'bwrk-onepage-current',
            updateHash: updateHash
        });
    });

});

