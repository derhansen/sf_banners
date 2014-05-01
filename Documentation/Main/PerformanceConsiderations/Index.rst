

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


Performance considerations
--------------------------

The extension fetches banners asynchronously from the webserver where
the TYPO3 installation resides. Since the plugin has to count the
impressions for each banner on every page-impression, the plugin runs
uncached. I've implemented the TYPO3 Caching Framework to face this
problem, so the HTML output for the banners do not have to be rendered
on every page request.

To keep the performance of the extension at a reliable level, you must
keep in mind, that using the plugin multiple times on a page will
result in multiple asynchronous requests to the uncached plugin. This
will reduce website performance on high traffic sites.


