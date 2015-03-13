# Introduction #
This page guides through the installation process of NetS-X. NetS-X is a whole network environment. **Therefor NetS-X demands a system on it's own (either VM or physical machine).** NetS-X will use this machine completely.

There are two possible ways to install NetS-X, either via PXEboot or via Etherboot image. Further more the needed hardware is reduced one again.

PXEboot needs the configuration of a router, which supplies the client with theTFTP boot server address. The Etherboot can be initiated directly by using an image file on a booteable media.
# Needed Hardware #

  * one physical computer (CPU with virtualization extension)
  * two physical ethernet network ports
  * one DD-WRT capable router
  * one Alfa AWUS036H (500mW USB WLAN Adapter)
  * optional: one connector between Alfa and the router


# Installation topics #
The NetS-X VMserver installation is fully automatic via netboot and preseed. The Topology itself has to be setup manually.

Installation topics

  1. Router configuration or netboot preperation
  1. VMserver Installation
  1. Router Installation
  1. Identify network cards
  1. NetS-X Game Engine Installation
  1. NetS-X Clients Installation
  1. NetS-X Backtrack Clients Integration
  1. Interface Konfiguration Guests
  1. WEP Scenario Hardware Integration




## Installation NetS-X VM Server ##

  * Please download the image file burn it on a CD.

```
http://nets-x.googlecode.com/files/netsx-gpxe-1.0.1.iso
```

  1. Boot the CD you just burned.
  1. Install the NetS-X VM Server
  1. If you hit enter on "NetS-X VM Server install", give it a while (1-5min) to load. It will seem as it is crashed, but it is not.
  1. choose language and location reflecting your preferences.

  * Wait for the installation to finish.

## VMserver Password ##
The password is
```
r00tme
```

## Preperation of Nets-X VM´s ##
Open a Terminal window and switch to root with
```
sudo -s
```
switch to /root with
```
cd /root
```
and execute the script
```
./build_netsx_vms.script
```
## Backtrack Download ##
At http://www.backtrack-linux.org/downloads/ you can download the Backtrack 5, Gnome, 32bit, VMware Image.

## Convert VMware Image to KVM ##
```
qemu-img convert backtrck5.vmdk -O qcow2 backtrack5.qemu
```