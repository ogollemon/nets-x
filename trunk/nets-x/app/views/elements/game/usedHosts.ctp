<?php
print '<fieldset><legend>Used Hosts in this scenario</legend>';
print '<p>For this scenario you can open an SSH session to the NetS-X Game Server:</p>';
foreach ($usedHosts as $port=>$host) {
   print '&raquo; SSH to '.$host.' via GameEngine port <strong>'.$port.'</strong><br />';
}
print '</fieldset>';
?>