

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

jQuery inclusion
^^^^^^^^^^^^^^^^

This extension requires jQuery on your website. You have to make sure, that you always have only one
version of jQuery included and that the jQuery include is located **before** the inclusion of the
JavaScript libs that come from the extension.

To avoid any problems/conflicts, I recommend to include jQuery as shown below::

   page.includeJSFooter {
     bannerJQuery = //ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js
     bannerJQuery.external = 1
     bannerJQuery.forceOnTop = 1
   }

The forceOnTop option makes sure, that jQuery is always included on top of all other JavaScript includes.