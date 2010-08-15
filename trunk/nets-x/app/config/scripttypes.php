<?php

/**
* Here all the script types can be scripted
* Used in scripts_controller, scenarios_controller
*/

define ('ENVIRONMENT_SETUP_SCRIPT', 1); 
define ('ENVIRONMENT_CLEANUP_SCRIPT', 2); 
define ('PLAYER_SETUP_SCRIPT', 3);
define ('PLAYER_CLEANUP_SCRIPT', 4);
define ('PLAYER_EVALUATION_SCRIPT', 5);
define ('DRONE_SETUP_SCRIPT', 6);
define ('DRONE_CLEANUP_SCRIPT', 7);

define ('DRONE_SCRIPT', 'drone_script');

?>