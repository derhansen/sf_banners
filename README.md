[![Latest Stable Version](http://poser.pugx.org/derhansen/sf_banners/v)](https://packagist.org/packages/derhansen/sf_banners)
![CI](https://github.com/derhansen/sf_banners/workflows/CI/badge.svg)
[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)
[![Monthly Downloads](http://poser.pugx.org/derhansen/sf_banners/d/monthly)](https://packagist.org/packages/derhansen/sf_banners)

TYPO3 extension sf_banner: Banner-Management
===========================================

## What is it?

**Banner-Management** is a banner management extension for TYPO3. It is based of Extbase and Fluid and supports TYPO3
12.4 LTS. Banners are loaded asynchronously so the page load time is affected as less as possible.

## What does it do?

**Banner-Management** allows you to manage banners on your TYPO3 website. The following banner types are supported

* Image
* HTML

Banner can be assigned multiple categories which allows a flexible way of displaying them on a TYPO3 website.
Each banner contains a statistic, where the total amount of impressions and clicks are shown. A banner can be limited
to an amount of maximum impressions and/or clicks.

Banners are loaded asynchronously, so their loading does not affect the page load time. To do so, the extension
uses JavaScript (AJAX) to load all banners and postscribe.js to place the banners content to the webpage.

## Versions

| Version | TYPO3      | PHP       | Support/Development                  |
|---------|------------|-----------|--------------------------------------|
| 7.x     | 12.3       | >= 8.1    | Features, Bugfixes, Security Updates |
| 6.x     | 11.5       | 7.4 - 8.1 | Features, Bugfixes, Security Updates |
| 5.x     | 9.5 - 10.4 | 7.2 - 7.4 | Security Updates                     |
| 4.x     | 8.7 - 9.5  | 7.0 - 7.4 | Not supported any more               |
| 3.x     | 7.5 - 9.5  | 5.6 - 7.2 | Not supported any more               |
| 2.x     | 7.5 - 9.5  | 5.6 - 7.2 | Not supported any more               |
| 1.x     | 6.2 - 9.5  | 5.4 - 5.6 | Not supported any more               |

## Support and updates

The extension is hosted on GitHub. Please report feedback, bugs and change-requests directly at https://github.com/derhansen/sf_banners
