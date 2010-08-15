<?php
/*
 * Here we can define custom constants for reuse in php scripts.
 *
 *
 */

define('PACKAGES', APP.'packages'.DS); // Path for installation packages for scenarios

//Networking settings used in Settings controller:
define('MANAGEMENT_INTERFACE', 1); // must be identical to the id in settings-table of DB
define('PLAYER_INTERFACE', 2); // must be identical to the id in settings-table of DB
define('OPENVPN_INTERFACE', 3); // must be identical to the id in settings-table of DB

// for shell scripts:
define('CAKEUSER', 'CAKEUSER');
define('CAKEPASS', 'CAKEPASS');
define('SCRIPTHOST', 'SCRIPTHOST');
define('SHELL_PARAM', 'CAKE');
define('SCRIPTAUTHOR', 'SCRIPTAUTHOR');
define('SCRIPTDATE', 'SCRIPTDATE');
define('SCRIPTVERSION', 'SCRIPTVERSION');
define('SCRIPTNAME', 'SCRIPTNAME');

define('SSH_CONFIG', '/var/www/nets-x/app/shellscripts/ssh_config');
define('START_PORT', 5000); // this port + the id of the host in DB will be opened in the firewall
define('WWW_START_PORT', 7000); // this port is needed for non ssh scenarios
define('WWW_RAMSES_PORT', 9000); // this port is needed for the SNORT scenario

// this is used for Evaluation:
define('SCRIPT_SUCCESS', 0);
define('EVAL_ERROR', 1);
define('EVAL_SUCCESS', 2);
define('EVAL_FAILURE', 3);


// here we define the scenario types by id in the Database:
define('SHELL_BASED', 1);
define('COMPARISON_BASED', 2);

// here we define roles for the game
// the app_controller functions "__requireAdmin" and "__requireTutor" check
// if the rights defined here are greater than the number defined here to allow access:
define('ROLE_PLAYER', 0);
define('ROLE_AUTHOR', 100);
define('ROLE_TUTOR', 200);

// definitions for scenario authoring steps:
// they are added and stored in scenarios table 'complete'
define('SCENARIO_BASICS', 1);			// general info complete
define('SCENARIO_REQUIREMENTS', 2);	// skills complete
define('SCENARIO_SCRIPTS', 4);			// scripts entered
define('SCENARIO_PARAMETERS', 8);		// all script parameters entered
define('SCENARIO_PARAMETERSETS', 16);		// all parameter sets entered
define('SCENARIO_PARAMETERVALUES', 32);		// all parameter values entered
define('SCENARIO_RESOURCES', 64);       // all script resources entered  

define('COMPLETION_STATUS_OK', '');       // error message string is empty if everything went ok
define('COMPLETION_STATUS_ERROR', 'ERROR');       // error message string is empty if something went wrong

define('PARAMETERSET_LOGIN', 'system login data');
?>
