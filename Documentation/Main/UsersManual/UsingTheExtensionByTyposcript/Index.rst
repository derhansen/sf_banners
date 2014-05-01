

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


Using the extension by TypoScript
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

It is also possible to use the extension by TypoScript. It offers a
widget, which easily can be included and configured.

::

   lib.someplace < plugin.tx_sfbanners.widgets.bannerWidget

The widget has some default settings, which can be overridden by
TypoScript. If ou for example would like to change the displaymode of
the inserted widget, you can do it like shown below.

::

   lib.mybanner < plugin.tx_sfbanners.widgets.bannerWidget
   lib.mybanner.settings.displayMode = allRandom

All possible TypoScript configuration settings can be found in the
configuration section of this manual.

