<?php
use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Controller_Template;
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
 * @extends  Controller
 */
class Controller_Users extends Controller_Template
{

	
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$data = array();
		$data['title']   = "Users - Miniblog";
		$data['content'] = "";
		$this->template->title = "Users - Miniblog";
		$this->template->set('breadcrumbs', '<li class="active">Users</li>
						',false);
		$this->template->content = View::forge('users/index', $data);
	}
	
	/**
	 * The function register new account
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_register()
	{
		$data = array();
		$data['title']   = "Register - Miniblog";
		$data['content'] = "";
		$this->template->title = "Register - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Users</a></li>
											 <li class="active">Register</li>
											
						',false);
		//if exist data in form, show them
			
		if (Input::post()) {
			
			//set data to call api
			$user['username'] = Input::post('username');
			$user['password'] = Input::post('password');
			$user['lastname'] = Input::post('lastname');
			$user['firstname'] = Input::post('firstname');
			$user['email'] = Input::post('email');
			//call api
			//set method, link, use curl to call
			$method = 'POST';
			$link = 'http://localhost/_blog/blog/src/v1/users/';
			
			$res =  $this->init_curl($user, $method, $link);
			//create success , return code 200
			
			if ($res['meta']['code'] == 200) {
				//set session
				
				Session::set('token', $res['data']['token']);
				Session::set('user_id', $res['data']['id']);
				Session::set('username', $res['data']['username']);
				
				$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> '.$res['meta']['message'].'
		        				</div>';
			} else {
				//alert error message
				
				if (is_array($res['meta']['message'])) {
					//json return is array message output
					$message = implode($res['meta']['message'][0]);			
					//var_dump($res['meta']);die;
				} else {
					
					$message = $res['meta']['message'];
				}
				$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> '.$message.'
		        				</div>';
			}
			//$view->result = $res;
			
		} else {
			//set empty if not click button submit
			$user['username'] = '';
			$user['password'] = '';
			$user['lastname'] = '';
			$user['firstname'] = '';
			$user['email'] = '';
		}
		//set data to view register
		$data['data'] = $user;
		//return the template content
		$this->template->content = View::forge('users/register', $data);
		//return $view;
	}
	
	/**
	 * The function register new account
	 *
	 * @access  public
	 * @return  Response
	 */
	
	public function action_logout() {
		
		Session::destroy();
		return Response::redirect('/index');
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
