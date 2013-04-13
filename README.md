TYPO3 extension sf_banner: Banner-Management
===========================================

## What is it?

**Banner-Management** is a banner management extension for TYPO3. It is based of Extbase and Fluid and supports TYPO3
Version 4.5.x to 6.0.x. Banners are loaded asynchronously so the page load time is affected as less as possible.

## What does it do?

**Banner-Management** allows you to manage banners on your TYPO3 website. The following banner types are supported

* Image
* HTML
* Flash

Banner can be assigned multiple categories which allows a flexible way of displaying them on a TYPO3 website.
Each banner contains a statistic, where the total amount of impressions and clicks are shown. A banner can be limited
to an amount of maximum impressions and/or clicks. The clicks of Flash-banners are counted by using the [clickTag](http://www.flashclicktag.com/)

Banners are loaded asynchronously, so their loading does not affect the page load time. To do so, the extension
uses JQuery (AJAX) to load all banners and postscribe.js to place the banners content to the webpage.

## External libraries requirements

The extension requires the following external JS libraries, which automatically are included during installation
of the extension.

* postscribe.js (http://krux.github.io/postscribe/)
* JQuery (http://jquery.com/)

The automatic inclusion of JQuery can be disabled in TypoScript

## Support and updates

The extension is hosted on Github. Please report feedback, bugs and changerequest directly at https://github.com/derhansen/sf_banners

