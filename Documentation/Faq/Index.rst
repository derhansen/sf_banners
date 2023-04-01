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


FAQ
---

I installed the extension but no banners are shown
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Make sure, that you included the TypoScript files from the extension. They
include the 2 required JavaScript files:

* EXT:sf_banners/Resources/Public/Js/Postscribe.js
* EXT:sf_banners/Resources/Public/Js/SfBanners.js

If banners still do not get displayed and you use TYPO3 >= 9.5 and the PageType
Route Enhancer, make sure that you configured a mapping - see :ref:`routing`

Can I use my own templates?
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Yes, this is possible since the extension is made with Extbase and
Fluid. You can configure template settings by TypoScript

How to prevent banner links to get indexed by search engines
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Since version 5.0.1 the extension instructs search engines to not index the "getBanners" action. This is done
by sending a `X-Robots-Tag: noindex, nofollow` HTTP header in the "getBanners" action.

Additionally you should ensure, that banner links contain `rel="nofollow"` in your template.

You should also instruct search engines to not index links containing arguments of the extension. This can be done
by adding the following to your `robots.txt`::

  Disallow: /*tx_sfbanners_pi1    # no banners
