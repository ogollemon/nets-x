:: README ::
You want to do some flash remoting while still having the option for an HTML front end? Well, these files allow you to do that by combining the two best open source options, AMFPHP for remoting and CakePHP for everything else. 

The CakeAMFPHP_0.5.0 package was created by gwoo (gwoo@rd11.com). This package utilizes AMFPHP located at http://amfphp.org and maintained by the AMFPHP team. Some Cake specific files have been added to the amf-core to allow for easier integration.

Version 0.5.0 differs from previous versions by including all the amf-core files in the package. Therefore, as of now its GPL cause AMFPHP is. The Package is laid out as follows:

-CakeAMFPHP.0.5.0
--vendors
---cakeamfphp
--views
---helpers
----swfobject.php
----ufo.php
--webroot
---cakegateway.php
---debuggateway.php
---amfbrowser

You should be able to follow this directory structure when adding CakeAMFPHP to your app. An alternate distribution (CakeAMPHP_App_0.5.0) is also available. The alternate distribution includes the full app directory. You can use the alternate package if you are starting a new project. Otherwise, use this package if you want to add remoting to an existing app.


Installation is easy.
1) match the CakeAMFPHP directories and files with your /app directory
2) point the NetConnection to cake_gateway.php

Access the service browser through
http://localhost/cake_install/amfbrowser/

if you have any problems stop by #cakephp and #cakeamfphp at irc.freenode.net
or submit a bug to CakeAMFPHP project on CakeForge

VERSION 0.5.0