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

If banners still do not get displayed and you use TYPO3 9.5 and the PageType Route Enhancer, make
sure that you configured a mapping - see :ref:`routing`

Can I use my own templates?
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Yes, this is possible since the extension is made with Extbase and
Fluid. You can configure template settings by TypoScript