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

Make sure, that you included jQuery to your website and also make sure, that jQuery is included
at the top of all other JavaScript libraries.

How to implement click tracking for Flash-banners?
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The extension makes use the clicktag, which can be implemented in
flash-banners. More information about how to create a flash-banner
with a clicktag can be found at `http://www.flashclicktag.com/
<http://www.flashclicktag.com/>`_

Can I use my own templates?
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Yes, this is possible since the extension is made with Extbase and
Fluid. You can configure template settings by TypoScript