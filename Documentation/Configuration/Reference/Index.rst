.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Reference
^^^^^^^^^

Plugin-Settings: plugin.tx\_sfbanners.settings


.. t3-field-list-table::
 :header-rows: 1

 - :Property:
       Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:

 - :Property:
         displayMode

   :Data type:
         string

   :Description:
         The displaymode for the plugin.

         Valid values are

         * all
         * allRandom
         * random

   :Default:
         all

 - :Property:
         startingPoint

   :Data type:
         int

   :Description:
         The startingpoint for the plugin. This can be on single pid of a
         sysfolder or multiple PIDs seperated by a comma.

   :Default:

 - :Property:
         category

   :Data type:
         int

   :Description:
         One or multiple UIDs of categories. If using multiple UIDs, they must
         be seperated by a comma.

   :Default:

 - :Property:
         maxResults

   :Data type:
         int

   :Description:
         If set to a value greater than 0, the given amount of banners are returned

   :Default:

 - :Property:
         ajaxPageTypeNum

   :Data type:
         int

   :Description:
         Page typeNum, where banners are fetched via AJAX

   :Default:
         9001

 - :Property:
         clickPageTypeNum

   :Data type:
         int

   :Description:
         Page typeNum for clickAction

   :Default:
         9002

 - :Property:
         cacheLifetime

   :Data type:
         int

   :Description:
         Lifetime of the cache for rendered banners in seconds

   :Default:
         3600

