

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


Installation
^^^^^^^^^^^^

The installation and initial configuration of the extension is as
following:

#. Install the extension with the extension manager

#. Include the static TypoScript configuration “Banner management
   (sf\_banners)” in your TypoScript template

#. Create a new sysfolder in your page tree, where you can add banners and
   categories.

#. Include the plugin “Banner-Management” on a page and select which
   displaymode you want to use. Next select the desired startingpoint
   (sysfolder created in step 3) and/or categories.

#. For TYPO3 9.5+ LTS make sure to configure the mapping for the PageType Route Enhancer properly
   (see :ref:`routing`), so the extension is able to fetch Banners and count Clicks.
