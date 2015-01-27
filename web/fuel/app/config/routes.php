<?php
use Fuel\Core\Route;
return array(
	'_root_'  => 'home/index',  // The default route
	'index'  => 'home/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array( 'welcome/hello', 'name' => 'hello' ),
	'posts/:num/unpublish' => array( 'posts/unpublish', 'name' => 'unpublish' ),
	'posts/:num/publish' => array( 'posts/publish', 'name' => 'publish' ),
	'users/:num/posts' => array( 'posts/get_all_user_posts/', 'name' => 'user_post' ),
	'users/:num/comments' => array( 'comments/get_all_user_comments/', 'name' => 'user_comment' ),		
);
