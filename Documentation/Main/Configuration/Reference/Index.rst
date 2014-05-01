

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


Reference
^^^^^^^^^

Plugin-Settings: plugin.tx\_sfbanners.settings


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         displayMode
   
   Data type
         string
   
   Description
         The displaymode for the plugin.
         
         Valid values are
         
         - all
         
         - allRandom
         
         - random
   
   Default
         all


.. container:: table-row

   Property
         startingPoint
   
   Data type
         int
   
   Description
         The startingpoint for the plugin. This can be on single pid of a
         sysfolder or multiple PIDs seperated by a comma.
   
   Default


.. container:: table-row

   Property
         category
   
   Data type
         int
   
   Description
         One or multiple UIDs of categories. If using multiple UIDs, they must
         be seperated by a comma.
   
   Default


.. container:: table-row

   Property
         defaultFlashVars.wmode
   
   Data type
         string
   
   Description
         The default value for flash wmode. The default setting of the
         extension “opaque” is configured in constants.
   
   Default
         opaque


.. container:: table-row

   Property
         defaultFlashVars.allowScriptAccess
   
   Data type
         string
   
   Description
         The default value for flash allowScriptAccess. The default setting of
         the extension “sameDomain” is configured in constants.
   
   Default
         sameDomain


.. container:: table-row

   Property
         includeJquery
   
   Data type
         int
   
   Description
         Includes JQuery (CDN-Version) to the TYPO3 website
   
   Default
         true


.. container:: table-row

   Property
         ajaxPageTypeNum
   
   Data type
         int
   
   Description
         Page typeNum, where banners are fetched via AJAX
   
   Default
         9001


.. container:: table-row

   Property
         clickPageTypeNum
   
   Data type
         int
   
   Description
         Page typeNum for clickAction
   
   Default
         9002


.. container:: table-row

   Property
         cacheLifetime
   
   Data type
         int
   
   Description
         Lifetime of the cache for rendered banners in seconds
   
   Default
         3600


.. ###### END~OF~TABLE ######

