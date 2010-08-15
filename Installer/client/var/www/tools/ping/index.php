<?php

error_reporting(E_ALL);

echo shell_exec('./pingtest.sh | ./ansi2html.sh --bg=dark');

?>
