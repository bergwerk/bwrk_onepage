/**
 * Single Page Nav Plugin
 * Copyright (c) 2014 Chris Wojcik <hello@chriswojcik.net>
 * Dual licensed under MIT and GPL.
 * @author Chris Wojcik
 * @version 1.2.0
 *
 * @contributer Marvin Hübner <mjh@bergwerk.ag>
 * @github https://github.com/marvinhuebner/single-page-nav
 */

// Utility
if (typeof Object.create !== 'function') {
    Object.create = function(obj) {
        function F() {}
        F.prototype = obj;
        return new F();
    };
}

(function($, window, document, undefined) {
    "use strict";

    var SinglePageNav = {

        init: function(options, container) {

            this.options = $.extend({}, $.fn.singlePageNav.defaults, options);

            this.container = container;
            this.$container = $(container);
            this.$links = this.$container.find('a');

            if (this.options.filter !== '') {
                this.$links = this.$links.filter(this.options.filter);
            }

            this.$window = $(window);
            this.$htmlbody = $('html, body');

            this.$links.on('click.singlePageNav', $.proxy(this.handleClick, this));

            this.didScroll = false;
            this.checkPosition();
            this.setTimer();
        },

        handleClick: function(e) {
            var self  = this,
                link  = e.currentTarget,
                $elem = $(link.hash);

            e.preventDefault();

            if ($elem.length) { // Make sure the target elem exists

                // Prevent active link from cycling during the scroll
                self.clearTimer();

                // Before scrolling starts
                if (typeof self.options.beforeStart === 'function') {
                    self.options.beforeStart();
                }

                self.setActiveLink(link.hash);

                self.scrollTo($elem, function() {

                    // Update the Hash behind the URL Path
                    var pathArray = window.location.pathname+window.location.search;

                    if (self.options.updateHash && history.pushState) {
                        history.pushState(null,null, pathArray + link.hash);
                    }

                    self.setTimer();

                    // After scrolling ends
                    if (typeof self.options.onComplete === 'function') {
                        self.options.onComplete();
                    }
                });
            }
        },

        scrollTo: function($elem, callback) {
            var self = this;
            var target = self.getCoords($elem).top;
            var called = false;

            self.$htmlbody.stop().animate(
                {scrollTop: target},
                {
                    duration: self.options.speed,
                    easing: self.options.easing,
                    complete: function() {
                        if (typeof callback === 'function' && !called) {
                            callback();
                        }
                        called = true;
                    }
                }
            );
        },

        setTimer: function() {
            var self = this;

            self.$window.on('scroll.singlePageNav', function() {
                self.didScroll = true;
            });

            self.timer = setInterval(function() {
                if (self.didScroll) {
                    self.didScroll = false;
                    self.checkPosition();
                }
            }, 250);
        },

        clearTimer: function() {
            clearInterval(this.timer);
            this.$window.off('scroll.singlePageNav');
            this.didScroll = false;
        },

        // Check the scroll position and set the active section
        checkPosition: function() {
            var scrollPos = this.$window.scrollTop();
            var currentSection = this.getCurrentSection(scrollPos);
            if(currentSection!==null) {
                this.setActiveLink(currentSection);
            }
        },

        getCoords: function($elem) {
            return {
                top: Math.round($elem.offset().top) - this.options.offset
            };
        },

        setActiveLink: function(href) {
            var $activeLink = this.$container.find("a[href$='" + href + "']");

            if (!$activeLink.hasClass(this.options.currentClass)) {
                this.$links.removeClass(this.options.currentClass);
                $activeLink.addClass(this.options.currentClass);
            }
        },

        getCurrentSection: function(scrollPos) {
            var i, hash, coords, section;

            for (i = 0; i < this.$links.length; i++) {
                hash = this.$links[i].hash;

                if ($(hash).length) {
                    coords = this.getCoords($(hash));

                    if (scrollPos >= coords.top - this.options.threshold) {
                        section = hash;
                    }
                }
            }

            // The current section or the first link if it is found
            return section || ((this.$links.length===0) ? (null) : (this.$links[0].hash));

        }
    };

    $.fn.singlePageNav = function(options) {
        return this.each(function() {
            var singlePageNav = Object.create(SinglePageNav);
            singlePageNav.init(options, this);
        });
    };

    $.fn.singlePageNav.defaults = {
        offset: 0,
        threshold: 120,
        speed: 400,
        currentClass: 'current',
        easing: 'swing',
        updateHash: false,
        filter: '',
        onComplete: false,
        beforeStart: false
    };

})(jQuery, window, document);
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Marvin Hübner <mjh@bergwerk.ag>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author    Marvin Hübner <mjh@bergwerk.ag>
 * @package    TYPO3
 * @subpackage    bwrk_onepage
 ***************************************************************/

var bwrkOnepageNav = $('.tx-bwrk-onepage-menu');

$(document).ready(function () {
    bwrkOnepageNav.each(function () {
        var self = $(this);

        var dataOffset = self.attr('data-offset');
        var dataThreshold = self.attr('data-threshold');
        var dataScrollSpeed = self.attr('data-scroll-speed');
        var dataUpdateHash = self.attr('data-update-hash');

        var offset = 0;
        if (dataOffset) {
            offset = parseInt(dataOffset);
        }

        var threshold = 120;
        if (dataThreshold) {
            threshold = parseInt(dataThreshold);
        }

        var scrollSpeed = 0;
        if (dataScrollSpeed) {
            scrollSpeed = parseInt(dataScrollSpeed);
        }

        var updateHash = false;
        if (dataUpdateHash != undefined) {
            updateHash = true;
        }

        self.singlePageNav({
            offset: offset,
            threshold: threshold,
            speed: scrollSpeed,
            currentClass: 'bwrk-onepage-current',
            updateHash: updateHash
        });
    });
});

$(window).load(function () {
    bwrkOnepageNav.each(function () {
        var self = $(this);
        var dataSticky = self.attr('data-sticky');

        if (dataSticky != undefined) {
            getSticky(self);
        }
    });
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
    $(window).scroll(function () {
        addStickyClass();
    });
}