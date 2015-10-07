var bwrkOnepageNav = $('.tx-bwrk-onepage-menu');
var dataSticky = bwrkOnepageNav.attr('data-sticky');
var dataThreshold = bwrkOnepageNav.attr('data-threshold');
var dataUpdateHash = bwrkOnepageNav.attr('data-update-hash');

$(document).ready(function () {
    var scrollSpeed = 0;
    var dataScrollSpeed = bwrkOnepageNav.attr('data-scroll-speed');
    if (dataScrollSpeed) {
        scrollSpeed = parseInt(dataScrollSpeed);
    }

    var threshold = 120;
    if (dataThreshold) {
        threshold = parseInt(dataThreshold);
    }

    var updateHash = false;
    if (dataUpdateHash != undefined) {
        updateHash = true;
    }

    var offsetHeight = 0;
    //$(window).scroll(function() {
    //    if ($('.tx-bwrk-onepage-menu.sticky').length > 0) {
    //        offsetHeight = bwrkOnepageNav.outerHeight(true);
    //    }
    //});

    bwrkOnepageNav.singlePageNav({
        offset: offsetHeight,
        threshold: threshold,
        speed: scrollSpeed,
        currentClass: 'bwrk-onepage-current',
        updateHash: updateHash
    });

    console.log(offsetHeight);
});

$(window).load(function () {
    if (dataSticky != undefined) {
        getSticky(bwrkOnepageNav);
    }
});

function getSticky(obj) {
    var menu = obj;
    var stickyClass = 'sticky';
    var body = $('body');

    var menuHeight = menu.outerHeight(true);
    var menuPosition = menu.offset();

    function addStickyClass() {
        if ($(window).scrollTop() > menuPosition.top) {
            menu.addClass(stickyClass);
            body.css('margin-top', menuHeight);
        }
        else {
            menu.removeClass(stickyClass);
            body.css('margin-top', '0');
        }
    }

    addStickyClass();
    $(window).scroll(function() {
        addStickyClass();
    });
}

