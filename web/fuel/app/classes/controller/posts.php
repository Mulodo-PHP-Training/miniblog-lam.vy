<?php
use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Controller_Template;
use Fuel\Core\Security;
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The User Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller_Template
 */
class Controller_Posts extends Controller_Template
{

	protected $filters = array('strip_tags', 'htmlentities');
	/**
	 * The index function, user home page
	 *
	 * @access  public
	 * @return  Response
	*/
	public function action_index()
	{
		$data = array();
		$data['title']   = "Posts - Miniblog";
		$data['content'] = "";
		$this->template->title = "Posts - Miniblog";
		$this->template->set('breadcrumbs', '<li class="active">Posts</li>
						',false);
		$this->template->content = View::forge('posts/index', $data);
	}
	
	/**
	 * The index function, user home page
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_detail()
	{
		//get id of post
		$post_id = Uri::segment(3);
		$data = array();
		$data['title']   = "Posts - Miniblog";
		
		$this->template->title = "Posts - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Posts</a></li>
								<li class="active">Detail</li>
						',false);
		//get post info
		$method = 'GET';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$post_id";
		$res = $this->init_curl(null, $method, $link);
		 
		$data['data'] = $res['data'];		
		
		$this->template->content = View::forge('posts/detail', $data);
	}
	
	/**
	 * function to init curl used to api
	 * set method, link for request
	 * get result from response
	 *
	 */
	public function init_curl($test_data, $method, $link) {
			
			
		// create a Request_Curl object
		$curl = Request::forge($link, 'curl');
			
		// this is going to be an HTTP POST
		$curl->set_method($method);
		// set some parameters
		$curl->set_params($test_data);
		// execute the request
		$curl->execute();
		// Get response object
		$result = $curl->response();
			
		// Get response body
		$res = json_decode($result->body(), true);
		// return response
		//print_r($test_data); die;
		return $res;
	}
}