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
 * When page is loaded, cycle through global banners array and set BannerPlacement for each item
 */
jQuery(document).ready(function() {
    if (typeof banners == "undefined")
        return;

    for (var i = 0; i < banners.length; i++) {
        new BannerPlacement(
            banners[i][0],
            banners[i][1]
        );
    }
});
