/**
 * When page is loaded, collect all banner configs and POST data to backend to fetch banners
 */
document.addEventListener('DOMContentLoaded', () => {
  let url = ''
  let formData = new FormData();

  [...document.querySelectorAll('[id^="banner-"]')].forEach(banner => {
    url = banner.dataset.fetchurl
    formData.append('tx_sfbanners_pi1[bannerConfigs][]', banner.dataset.config)
  });

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
})