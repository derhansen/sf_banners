/**
 * When page is loaded, collect all banner configs and POST data to backend to fetch banners
 */
jQuery(document).ready(function() {
    var $banners = $('[id^=banner-]')
    var url = ''
    var bannerConfigs = []

    $banners.each(function() {
      url = $(this).data('fetchurl')
      bannerConfigs.push($(this).data('config'))
    })

    if (url !== '') {
      $.ajax({
        url: url,
        type: 'POST',
        data: {
          'tx_sfbanners_pi1[bannerConfigs]': bannerConfigs
        },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            postscribe('#banner-' + data[i]['uniqueId'], data[i]['html']);
          }
        }
      })
    }
  }
);
