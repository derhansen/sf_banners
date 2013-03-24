/**
 * AJAY Banner placement
 *
 * @param {int} uid
 * @param {int} typeNum
 * @param {string} startingPoint
 * @param {string} categories
 * @param {string} displayMode
 * @param {string} position
 * @constructor
 */
var BannerPlacement = function (uid, typeNum, startingPoint, categories, displayMode, position) {
    var url = 'index.php?id=' + uid;
    url += '&type=' + typeNum;
    url += '&tx_sfbanners_pi1[action]=getBanners';

    if (typeof startingPoint !== 'undefined' && startingPoint !== '') {
        url += '&tx_sfbanners_pi1[startingPoint]=' + startingPoint;
    }

    if (typeof categories !== 'undefined' && categories !== '') {
        url += '&tx_sfbanners_pi1[categories]=' + categories;
    }

    if (typeof categories !== 'undefined' && displayMode !== '') {
        url += '&tx_sfbanners_pi1[displayMode]=' + displayMode;
    }

    $.get(url, function(data) {
        $('#' + position).html(data);
    });
}
