[![Build Status](https://travis-ci.org/derhansen/sf_banners.png)](https://travis-ci.org/derhansen/sf_banners)
[![StyleCI](https://styleci.io/repos/7384456/shield?branch=master)](https://styleci.io/repos/7384456)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/derhansen/sf_banners/badges/quality-score.png?s=683c44ed4732bbe6364975b18e93250715f9ed47)](https://scrutinizer-ci.com/g/derhansen/sf_banners/)
[![Code Coverage](https://scrutinizer-ci.com/g/derhansen/sf_banners/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/derhansen/sf_banners/?branch=master)
[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

TYPO3 extension sf_banner: Banner-Management
===========================================

## What is it?

**Banner-Management** is a banner management extension for TYPO3. It is based of Extbase and Fluid and supports TYPO3
Version 8.7 LTS and TYPO3 9.5 LTS. Banners are loaded asynchronously so the page load time is affected as less as possible.

## What does it do?

**Banner-Management** allows you to manage banners on your TYPO3 website. The following banner types are supported

* Image
* HTML
* Flash

Banner can be assigned multiple categories which allows a flexible way of displaying them on a TYPO3 website.
Each banner contains a statistic, where the total amount of impressions and clicks are shown. A banner can be limited
to an amount of maximum impressions and/or clicks. 

Banners are loaded asynchronously, so their loading does not affect the page load time. To do so, the extension
uses jQuery (AJAX) to load all banners and postscribe.js to place the banners content to the webpage.

## External libraries requirements

The extension requires the following external JS libraries, which automatically are included during installation
of the extension.

* postscribe.js (http://krux.github.io/postscribe/)
* jQuery (http://jquery.com/)

The automatic inclusion of jQuery can be disabled in TypoScript

## Support and updates

The extension is hosted on Github. Please report feedback, bugs and change-requests directly at https://github.com/derhansen/sf_banners
