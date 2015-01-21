<?php
use Fuel\Core\Route;
return array(
	'_root_'  => 'home/index',  // The default route
	'index'  => 'home/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array( 'welcome/hello', 'name' => 'hello' ),
	
);
