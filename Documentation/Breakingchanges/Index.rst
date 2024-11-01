

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

Version 8.0.0
~~~~~~~~~~~~~

This version contains several breaking changes. Make sure to read the changelog, which also contains
important information about those changes: https://github.com/derhansen/sf_banners/releases/tag/8.0.0


Version 7.1.0
~~~~~~~~~~~~~

This version contain one breaking change. Make sure to read the changelog, which also contains
important information about those changes: https://github.com/derhansen/sf_banners/releases/tag/7.1.0


Version 7.0.0
~~~~~~~~~~~~~

This version contains several breaking changes. Make sure to read the changelog, which also contains
important information about those changes: https://github.com/derhansen/sf_banners/releases/tag/7.0.0


Version 6.0.0
~~~~~~~~~~~~~

This version contains several breaking changes. Make sure to read the changelog, which also contains
important information about those changes: https://github.com/derhansen/sf_banners/releases/tag/6.0.0


Version 5.0.0
~~~~~~~~~~~~~

This version contains several breaking changes. Make sure to read the changelog, which also contains
important information about those changes: https://github.com/derhansen/sf_banners/releases/tag/5.0.0

Version 4.0.0
~~~~~~~~~~~~~

The removal of the local category system requires the execution of a migration script, so existing
categories will get migrated to sys_category entries. Please use the update script in the extension
manager to process the migration as shown below.

.. figure:: ../Images/ext-update-category.png
   :align: left
   :width: 147px
   :alt: Extension Update Icon

Please click on the update-icon to start the category migration.

Version 3.0.0
~~~~~~~~~~~~~

The extension now has the default setting ``falMedia = 1`` in the extension settings. Make sure,
that you manually migrate images and flash files for image- and flash-banners manually.

If you still want to use non-FAL files for banners, you can switch off the falMedia setting in
the extension settings. Note, that this option will be removed in the next major version of the
extension!

Version 1.0.0
~~~~~~~~~~~~~

The inclusion of JavaScript libraries has moved to the page footer by using ``page.includeJSFooter``.
Due to this change, you may have to update your JavaScript includes in TypoScript. This only applies,
if you have overwritten the original ``page.includeJS`` inclusions.
