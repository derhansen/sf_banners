

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


Breaking changes
----------------

Version 1.0.0
~~~~~~~~~~~~~

The inclusion of JavaScript libraries has moved to the page footer by using ``page.includeJSFooter``.
Due to this change, you may have to update your JavaScript includes in TypoScript. This only applies,
if you have overwritten the original ``page.includeJS`` inclusions.
