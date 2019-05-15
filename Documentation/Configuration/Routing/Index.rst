.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _routing:

Routing
^^^^^^^

For TYPO3 9.5, you will have to configure the routing of the configured pageTypes, so banners will get rendered.
This only has to be configured, if you use the PageType route enhancer in your TYPO3 routing setup::

  RouteEnhancers:
    PageTypeSuffix:
      type: PageType
      default: /
      suffix: /
      map:
        /: 0
        banners.html: 9001
        bannerclick.html: 9002

The example above shows, how typeNum 9001 and 9002 (default for the extension) are configured.