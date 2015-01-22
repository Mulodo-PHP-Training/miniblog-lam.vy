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
class Controller_Users extends Controller_Template
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
			$user['username'] = Security::clean(Input::post('username'), $this->filters);
			$user['password'] = Security::clean(Input::post('password'), $this->filters);
			$user['lastname'] = Security::clean(Input::post('lastname'), $this->filters);
			$user['firstname'] = Security::clean(Input::post('firstname'), $this->filters);
			$user['email'] = Security::clean(Input::post('email'), $this->filters);
			//call api
			//set method, link, use curl to call
			$method = 'POST';
			$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/users';
			
			$res =  $this->init_curl($user, $method, $link);
			//create success , return code 200
			
			if ($res['meta']['code'] == 200) {
				//set session
				
				Session::set('token', $res['data']['token']);
				Session::set('user_id', $res['data']['id']);
				Session::set('username', $res['data']['username']);
				//set the success message alert
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
				//set the error message alert
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
	 * @return  Template view
	 */
	
	public function action_logout() {
		
		Session::destroy();
		return Response::redirect('/index');
	}
	
	/**
	 * The function login 
	 *
	 * @access  public
	 * @return  Template view
	 */
	
	public function action_login() {
	
		$data = array();
		$this->template->title = "Login - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Users</a></li>
				<li class="active">Login</li>', false);
		//check submit for login
		if (Input::post()) {
			//get username and password
			$user['username'] = Security::clean(Input::post('username'), $this->filters);
			$user['password'] = Security::clean(Input::post('password'), $this->filters);
			//call api
			$method = 'POST';
			$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/users/login';
			$res = $this->init_curl($user, $method, $link);
			//check result code return is 200
			if ($res['meta']['code'] == 200) {
				Session::set('token', $res['data']['token']);
				Session::set('user_id', $res['data']['id']);
				Session::set('username', $res['data']['username']);
				//set the success message alert
				$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> '.$res['meta']['messages'].'
		        				</div>';
			} else {
				//alert error
				if (is_array($res['meta']['message'])) {
					//json return is array message output
					$message = implode($res['meta']['message'][0]);
					//var_dump($res['meta']);die;
				} else {
						
					$message = $res['meta']['message'];
				}
				//set the error message alert
				$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> '.$message.'
		        				</div>';
			}
			
			
		} 
		$this->template->content = View::forge('users/login', $data);
		
	}
	
	/**
	 * The function update info user 
	 *
	 * @access  public
	 * @return  Template view
	 */
	
	public function action_update() {
		$data = array();
		$this->template->title = "Update user - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Users</a></li>
				<li class="active">Update</li>', false);
		//check user logged
		if (Session::get('token')) {
			
			//check if submit
			if (Input::post()) {
				//call api to update
				$token = Session::get('token');
		
				$user = array (
							'token' => $token ,
							'firstname' => Security::clean(Input::post('firstname'), $this->filters),
							'lastname' => Security::clean(Input::post('lastname'), $this->filters) ,
							'email' => Security::clean(Input::post('email'), $this->filters),
    
						);
				$method = 'PUT';
				$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/users';
				//run
				$result = $this->init_curl($user, $method, $link);
				//sucess
				if ($result['meta']['code'] == '200') {
					$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> Your profile was updated.
		        				</div>';
				} else {
					//alert error
					if (is_array($result['meta']['message'])) {
						//json return is array message output
						$message = implode($result['meta']['message'][0]);
						//var_dump($res['meta']);die;
					} else {
					
						$message = $result['meta']['message'];
					}
					//set the error message alert
					$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> '.$message.'
		        				</div>';
				}
			}
			//get info of user want to update fill in the form
			$user_id = Session::get('user_id');
			$method = "GET";
			$link = 'http://localhost/_blog/blog/src/v1/users/'.$user_id;
			$info = $this->init_curl(null, $method, $link);
			//fill data user info
			$data['data'] = $info['data'];
			
			$this->template->content = View::forge('users/update', $data);
		} else {
			return Response::redirect('users/access_denied');
		}
	}
	
	/**
	 * The function use change user password
	 * 
	 * @access public
	 * @return Template view
	 */
	public function action_password() {
		$data = array();
		$this->template->title = "Change password - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Users</a></li>
				<li class="active">Change password</li>', false);
		if (Session::get('token')) {
			//check submit
			if (Input::post()) {
				//token
				$info['token'] = Session::get('token');
				$info['old_password'] = Security::clean(Input::post('oldpassword'), $this->filters);
				$info['password'] = Security::clean(Input::post('newpassword'), $this->filters);
				$info['re'] = Security::clean(Input::post('retype'), $this->filters);
				//check input value
				
				//set method
				$method = 'PUT';
				//add the user id into the link
				$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/users/password';
				$result = $this->init_curl($info, $method, $link);
				//check the result return
				if ($result['meta']['code'] == 200) {
					$data['result'] = '<div class="alert alert-success" role="alert">
								<strong>Success!</strong> Your password was changed.
	        				</div>';
				} else {
					//alert error
					if (is_array($result['meta']['message'])) {
						//json return is array message output
						$message = implode($result['meta']['message'][0]);
						//var_dump($res['meta']);die;
					} else {
							
						$message = $result['meta']['message'];
					}
					//set the error message alert
					$data['result'] = '<div class="alert alert-warning" role="alert">
								<strong>Sorry!</strong> '.$message.'
	        				</div>';
				
				}
			}
			
			//template and view change pass
			$this->template->content = View::forge('users/password', $data);
		} else {
			//response access is denied
			return Response::redirect('users/access_denied');
		}
	}	
	/**
	 * The function show error message
	 * access is denied.
	 *
	 * @access  public
	 * @return  Template view
	 */
	public function action_access_denied() {
		
		$data = array();
		$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> Access is denied.
		        				</div>';
		$this->template->title = "Access denied - Miniblog";
		$this->template->set('breadcrumbs','<li class="active">Error</li>', false);
		$this->template->content = View::forge('users/access_denied', $data);
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
	
	/**
	 * The function use search user by name
	 * 
	 * @access  public
	 * @return  Template view
	 */
	public function action_search() {
		$data = array();
		$this->template->title = "Search - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Users</a></li>
				<li class="active">Search</li>', false);
		//check name for search
		$name = Input::get('name');
		if (!empty($name)) {
			$info['name'] = $name;
			//call api to count result have
			$method = 'GET';
			//add the user id into the link
			$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/users/search';
			$rs = $this->init_curl($info, $method, $link);
			if ($rs['meta']['code'] == 200) {
				//config //config page
				$config = array(
						'name' => 'bootstrap3',
						'pagination_url' => Uri::base(false).'users/search?name='.$name,
						'total_items'    => $rs['meta']['result'],
						'per_page'       => 6, // have 6 item per page
						'uri_segment'    => 5, //maximum 5 page showed
						'uri_segment'    => 'page',
						'show_first' => true,
						'show_last' => true,
						'first-marker' => "First",
						'last-marker' => "Last",
						'next-marker' => "Next",
						'previous-marker' => "Previous",
				);
				$pagination = Pagination::forge('paginate', $config);
					
				$info['start'] = $pagination->offset;
				$info['row'] = $pagination->per_page;
					
				$data['data'] = $this->search_user_page($info);
				$data['pagination'] = $pagination;
					
				$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> Having '.$rs['meta']['result'].' results for key word.
		        				</div>';
			} else {
				
				$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> Not have any result.
		        				</div>';
				$data['data'] = null;
			}
			
			
		} else {
			$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> The keyword for search is empty.
		        				</div>';
			$data['data'] = null;
		}
		$this->template->content = View::forge('users/search', $data);
	}
	/**
	 * The method use to search user on page
	 * @access public
	 * @return info user of this page
	 */
	public function search_user_page($data) {
		$method = "GET";
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/users/search/";
		$rs = $this->init_curl($data, $method, $link);
		
		return $rs['data'];
	}
}
