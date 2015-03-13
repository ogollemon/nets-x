# Introduction #

This is old stuff from the wiki

## Build Etherboot image ##
To build a gpxe boot image please see http://rom-o-matic.net.
The preset is mostly fine, but add
```
DOWNLOAD_PROTO_HTTPS
```
and

Embedded Script:
```
#!gpxe
dhcp net0
chain https://nets-x.googlecode.com/svn/trunk/Installer/NetsX-gpxeScript.gpxe
```


## Configure pxe boot ##

> To configure pxe boot on your router add the following line to your DNSmasq config file.
```
dhcp-boot=pxelinux.0,www.nets-x.hs-bremen.de,194.94.26.40
```