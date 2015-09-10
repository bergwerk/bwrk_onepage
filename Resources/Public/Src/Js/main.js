/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Georg Dümmler <gd@bergwerk.ag>
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
 * @author	Georg Dümmler <gd@bergwerk.ag>
 * @package	TYPO3
 * @subpackage	bwrk_onepage
 ***************************************************************/

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