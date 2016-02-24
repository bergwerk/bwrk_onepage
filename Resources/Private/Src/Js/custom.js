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
            updateHash: updateHash,
            filter: ':not(.bwrk-onepage-external)'
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