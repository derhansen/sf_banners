/**
 * Fetches the given banner and appends it with postscribe to the website
 *
 * @param uid
 * @param lang
 * @param typeNum
 * @param startingPoint
 * @param categories
 * @param displayMode
 * @param position
 * @param hmac
 * @param absRefPrefix
 * @param imgCrop
 * @param imgWidth
 * @param imgHeight
 * @constructor
 */
var BannerPlacement = function (uid, lang, typeNum, startingPoint, categories, displayMode, position, hmac, absRefPrefix, imgCrop, imgWidth, imgHeight) {
    var url = absRefPrefix + 'index.php?id=' + uid;
    url += '&L=' + lang;
    url += '&type=' + typeNum;
    url += '&tx_sfbanners_pi1[action]=getBanners';
    url += '&tx_sfbanners_pi1[currentPageUid]=' + uid;
    url += '&tx_sfbanners_pi1[hmac]=' + hmac;

    if (typeof startingPoint !== 'undefined' && startingPoint !== '') {
        url += '&tx_sfbanners_pi1[startingPoint]=' + startingPoint;
    }

    if (typeof categories !== 'undefined' && categories !== '') {
        url += '&tx_sfbanners_pi1[categories]=' + categories;
    }

    if (typeof displayMode !== 'undefined' && displayMode !== '') {
        url += '&tx_sfbanners_pi1[displayMode]=' + displayMode;
    }

    if (typeof imgCrop !== 'undefined') {
        // assigning default values
        if (typeof imgWidth === 'undefined') imgWidth="";
        if (typeof imgHeight === 'undefined') imgHeight="";

        url += '&tx_sfbanners_pi1[imgCrop]=' + imgCrop;
        url += '&tx_sfbanners_pi1[imgWidth]=' + imgWidth;
        url += '&tx_sfbanners_pi1[imgHeight]=' + imgHeight;
    }

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
            banners[i][1],
            banners[i][2],
            banners[i][3],
            banners[i][4],
            banners[i][5],
            banners[i][6],
            banners[i][7],
            banners[i][8],
            banners[i][9],
            banners[i][10],
            banners[i][11]
        );
    }
});
