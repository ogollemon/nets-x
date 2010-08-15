<?php
/*
 * json gateway for cake controllers
 * Created By Wouter Verweirder
 * Based on the work of Patrick Mineault (amfphp), gwoo (cakephp) & Aral Balkan (swx)
 */

require_once('cake_gateway_init.php');

vendor('cakeswx'.DS.'php'.DS.'core'.DS.'json'.DS.'app'.DS.'CakeGateway');
App::import('Controller', 'App');

$gateway = new CakeGateway();

$gateway->setBaseClassPath(CONTROLLERS);

$gateway->service();
?>