#!/bin/bash

### Bildschirm löschen
#clear


### Konstanten definieren für Farben und Default-Werte
ROT='[31m'
GRUEN='[32m'
GELB='[33m'
DUNKELBLAU='[34m'
LILA='[35m'
HELLBLAU='[36m'
RESET='[m(B'
#RESET=$(tput sgr0)
PINGZAHLDEFAULT=2
PINGZEITDEFAULT=1


### Befehlssyntax ausgeben
echo "${LILA}Befehlssyntax${RESET}:           ./pingtest [pinganzahl] [pingzeit]"


### Falls vorhanden, übergebene Parameter einlesen
#if [ $# -gt 0 ]
#then
# PINGZAHL=$1
#else
# PINGZAHL=1
#fi
#
#if [ $# -gt 1 ]
#then
# PINGZEIT=$2
#else
# PINGZEIT=2
#fi

PINGZAHL=${1:-$PINGZAHLDEFAULT}
PINGZEIT=${2:-$PINGZEITDEFAULT}
ONLINEZAHL=0
OFFLINEZAHL=0

### Ausgabe der Pingzeit, der Pinganzahl und deren Standardwerte
echo "${HELLBLAU}Wartezeit bis offline${RESET}:   $PINGZEIT Sekunde(n)  (Default: ${PINGZEITDEFAULT} Sekunde)"
echo "${HELLBLAU}Anzahl gesendeter Pings${RESET}: $PINGZAHL Ping(s)     (Default: ${PINGZAHLDEFAULT} Pings)"


### Funktion zum Pingen anhand der Parameter und zur Ausgabe des Ergebnisses
checkit ()
{
 ERRORZAHL=0
 for i in $(seq $PINGZAHL)
 do
  ping -c 1 -w $PINGZEIT $TARGETIP  1> /dev/null
  let "ERRORZAHL += $?"
 done

 if [ "$PINGZAHL" -gt "$ERRORZAHL" ]
 then
  let "ONLINEZAHL += 1"
  if [ "$ERRORZAHL" -gt 0 ]
  then
   echo -e "${GELB}${TARGETIP}\tonline${RESET}\t(${GELB}${ERRORZAHL}${RESET} von ${GRUEN}${PINGZAHL}${RESET} fehlgeschlagen)\t PC: ${TARGETNAME}"
  else
   echo -e "${GRUEN}${TARGETIP}\tonline${RESET}\t(${ERRORZAHL} von ${GRUEN}${PINGZAHL}${RESET} fehlgeschlagen)\t PC: ${TARGETNAME}"
  fi
 else
  let "OFFLINEZAHL += 1"
  echo -e "${ROT}${TARGETIP}\toffline${RESET}\t(${ROT}${ERRORZAHL}${RESET} von ${GRUEN}${PINGZAHL}${RESET} fehlgeschlagen)\t PC: ${TARGETNAME}"
 fi
}


### Schleife, die die eigentliche Funktion für jede IP aufruft
HOSTANZAHL=`wc -l pingtest_hosts.txt | cut -d ' ' -f1`

for i in $(seq ${HOSTANZAHL})
do
 TARGETIP=`eval sed -n '${i}p' pingtest_hosts.txt | cut -d ':' -f1`
 TARGETNAME=`eval sed -n '${i}p' pingtest_hosts.txt | cut -d ':' -f2`
 checkit
done

echo -e "\r\n${GRUEN}${ONLINEZAHL} online${RESET}\t${ROT}${OFFLINEZAHL} offline${RESET}\t\r\nTopologie unter http://www.netzlabor.hs-bremen.de/mediawiki/index.php/Topology_map${RESET}"

### Das wars
