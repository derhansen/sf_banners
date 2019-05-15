﻿

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


What does it do?
^^^^^^^^^^^^^^^^

Banner-Management allows you to manage banners on your TYPO3 website.
It supports image, HTML and flash banners. Banner can be assigned
multiple categories which allows a flexible way of displaying them on
a TYPO3 website.

The Extension fetches the banners for the desired page
**asynchronously** by using AJAX (jQuery), so the page load time is'nt
mainly affected by the banner plugin.

Each banner contains a statistics, where the total amount of
impressions and clicks are shown. A banner can be limited to an amount
of maximum impressions and/or clicks. The clicks of Flash-banners are
counted by using a clicktag.

The extension can be used as a plugin or by TypoScript.

The extension is developed with Extbase and Fluid and the current version
support TYPO3 8.7 LTS and TYPO3 9.5 LTS

