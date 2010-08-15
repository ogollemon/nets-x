Name: NetS-X Builder Manual
Version: 0.4.1
Maintainer: Alexander Ott <mail@alexanderott.com>


NetS-X Package building manual
------------------------------

This file is a manual of how to generate a bleeding edge Debian package of NetS-X client and server from the SVN.
This manual is NOT FOR the INSTALLATION of a NetS-X game engine, but for bulding the installation packages!!!


1. Short version:
-----------------

!WARNING! THIS SCRIPT MIGHT DO SOME STRANGE THINGS TO YOUR SYSTEM !WARNING!
THIS SOFTWARE COMES WITH ABSOLUTELY NO WARRANTY! USE AT YOUR OWN RISK!

1.1 Requirements:
-----------------

-a Debian like system (Debian, Ubuntu, Knoppix...)
-root privileges
-internet access
-system shell

1.2 Package building:
---------------------

To use the NetS-X deb builder please cut & paste to the linux command line as root:

--snip
mkdir -p /tmp ; cd /tmp/ ; wget http://www.nets-x.hs-bremen.de/netsx_WS08/trunk/Installer/netsx_build ; chmod +x netsx_build; ./netsx_build
--snap

You will find the packages in /var/www/nets-x on your machine. 


2. Long version:
----------------

The code snippet in the "Short Version" above gets the latest NetS-X build script from the NetS-X SVN.
The triggered build script itself gets the latest version of NetS-X with all its components from the NetS-X SVN.
 Afterwards it generates three Debian packages in a repository, netsx-server, netsx-client-tools and netsx-client in the /var/www/nets-x directory.

2.1 Package Revisions:
-----------------------
The package version of the netsx-server deb is representing the SVN revision number by the time of build.

2.2 Packages:
---------------

2.2.1 netsx-client:
-----------------
To change the revision of the netsx-client please manualy change it under client/DEBIAN/control

2.2.2 netsx-client-tools
----------------------
The netsx-client-tools are a set of deploy and cleanup scripts to deploy the netsx-client through the topology.

2.2.3 netsx-server
----------------
The netsx-server Package contains the NetS-X game engine core and all components or at least dependencies to them.
The configuration of the NetS-X game engine is handled by the netsx-server controll and postinst file.
The conf file is written on the fly by the netsx_build script!
So if you want to change anything there please consult the netsx_build script.
