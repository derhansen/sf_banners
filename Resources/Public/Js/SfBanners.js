/**
 * Fetches the given banner and appends it with postscribe to the website
 *
 * @param position
 * @param url
 * @constructor
 */
var BannerPlacement = function (position, url) {
    jQuery.get(url, function(data) {
        postscribe('#' + position, data);
    });
};

/**
 * When window is scrolled or resized and on page load: 
 * check if there are banner places in view and load the banners
 */
jQuery(document).ready(function() {
    window.onscroll = function() {
        checkBanners();
    }
    window.onresize = function() {
        checkBanners();
    }
    window.setTimeout(checkBanners, 200);
    
    function checkBanners() {
        $('.tx-sf-banners .banners-container:not(.loaded)').each(function() {
            var pageTop = $(window).scrollTop();
            var pageBottom = pageTop + $(window).height();
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).height();

            if ((elementTop <= pageBottom) && (elementBottom >= pageTop)) {
                new BannerPlacement($(this).attr('id'), $(this).data('url'));
                $(this).addClass('loaded');
            }
        });
    }
});
