/**
 * AJAX Banner placement
 *
 * @param {int} uid
 * @param {int} lang
 * @param {int} typeNum
 * @param {string} startingPoint
 * @param {string} categories
 * @param {string} displayMode
 * @param {string} position
 * @param {string} hmac
 * @constructor
 */
var BannerPlacement = function (uid, lang, typeNum, startingPoint, categories, displayMode, position, hmac, absRefPrefix) {
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

    jQuery.get(url, function(data) {
        postscribe('#' + position, data);
    });
}
