

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


Settings for banners
^^^^^^^^^^^^^^^^^^^^


Title
"""""

The title of the banner.


Type
""""

Image or HTML. Note, that the type :php`:html` is only available for admin users. If non-admin users should be
able to create HTML banners, the extension setting :php:`allowHtmlBannerForNonAdmins` must be enabled.

.. warning::

   HTML banners can be used to introduce XSS vulnerabity on the website. The feature is therefore disabled
   by default for non-admin users and should only be activated, if non-admin users should edit content of HTML
   banners.

Language
""""""""

The language for the banner. This setting depends on the amount of
languages configured in your TYPO3 installation.


Description
"""""""""""

A description for the banner


Assets
""""""

The asset (usually an image) which is displayed by the plugin. Please note, that the
extension is not able to resize the banner, so you must upload it with the final dimensions.


HTML
""""

The HTML Code for the banner. *Only available, when the banner type is
set to*  *“HTML”.*

Alternative text
""""""""""""""""

The alternative text of the image. *Only available, when the banner
type is set to “Image”.*


Link
""""

The link, where a click on the banner should redirect to.


Category
""""""""

One or multiple categories, which the banner belongs to.


Exclude pages
"""""""""""""

One or multiple pages, where the banner should **not** be shown.


Expand exclude pages recursive
""""""""""""""""""""""""""""""

Select if exclude pages should be expanded recursive


Hide
""""

If set to true, the banner is not displayed on the website.


Start / stop
""""""""""""

A **date- and time-field** , which controls when the banner is
automatically shown or hidden on the website.


Max impressions
"""""""""""""""

The maximum amount of impressions for the banner


Max clicks
""""""""""

The maximum amount of clicks for the banner

