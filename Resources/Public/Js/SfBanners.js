/**
 * When page is loaded, collect all banner configs and POST data to backend to fetch banners
 */
document.addEventListener('DOMContentLoaded', () => {
  let url = ''
  let formData = new FormData();
  let hasBanners = false;

  [...document.querySelectorAll('[id^="banner-"]')].forEach(banner => {
    url = banner.dataset.fetchurl
    hasBanners = true;
    formData.append('tx_sfbanners_pi1[bannerConfigs][]', banner.dataset.config)
  });

  if (hasBanners) {
    fetch(url, { body: formData, method: 'POST' })
      .then((resp) => resp.json())
      .then(function (data) {
        for (let i = 0; i < data.length; i++) {
          postscribe('#banner-' + data[i]['uniqueId'], data[i]['html'])
        }
      })
      .catch(function (error) {
        console.log(error)
      });
  }
})
