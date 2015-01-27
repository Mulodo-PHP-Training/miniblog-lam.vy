<?php
use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Controller_Template;
use Fuel\Core\Security;
use Model\V1\Post;
use Fuel\Core\Response;
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
		return Response::redirect('/');
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
	 * The function use create a post
	 * 
	 * @access public
	 * @return Template view create Post, message create success
	 *  
	 */
	public function action_create() {
		//check session user is loggin
		if (Session::get('token')) {
			$data = array();
			$this->template->title = "Create post - Miniblog";
			$this->template->set('breadcrumbs', '<li><a href="#">Posts</a></li>
								<li class="active">Create</li>
						',false);
			
			//submit for save
			if (isset($_POST['save'])) {
				
				$post['title'] = Security::clean(Input::post('title'), $this->filters);
				$post['content'] = Security::clean(Input::post('content'), $this->filters);
				$post['token'] = Session::get('token');
				//call api
				$method = 'POST';
				$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/posts';
				$rs = $this->init_curl($post, $method, $link);
				
				if ($rs['meta']['code'] == 200) {
					$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> Create post success
		        				</div>';
				} else {
					//error
					if (is_array($rs['meta']['messages'])) {
						//json return is array message output
						$message = implode($rs['meta']['messages'][0]);
						//var_dump($res['meta']);die;
					} else {
							
						$message = $rs['meta']['messages'];
					}
					//set the error message alert
					$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> '.$message.'
		        				</div>';
				}
			}
			
			//submit for preview
			if (isset($_POST['preview'])) {
				//data post
				$post['title'] = Security::clean(Input::post('title'), $this->filters);
				$post['content'] = Security::clean(Input::post('content'), $this->filters);
				$post['time'] = time();
				$data['post'] = $post;
			}
			$this->template->content = View::forge('posts/create', $data);
		} else {
			//return access denied
			return Response::redirect('users/login');
		}
	}
	
	/**
	 * The function use manage post of user
	 *
	 * @access public
	 * @return all posts of user
	 *
	 */
	
	public function action_manage() {
		$data = array();
		$this->template->title = "Manage post - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Posts</a></li>
								<li class="active">Manage</li>
						',false);		
		//check permission
		if (Session::get('token')) {
			//first is get all list post of user
			$user_id = Session::get('user_id');
			$method = 'GET';
			$user['token'] = Session::get('token');
			$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/users/$user_id/posts/manage";
			
			$rs = $this->init_curl($user, $method, $link);
			//check result return
			if ($rs['meta']['code'] == 200) {
				$data['data'] = $rs['data'];
				$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> You have '.$rs['meta']['result'].' posts in list .
		        				</div>';
			} else {
				$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong>Not have any your post.
		        				</div>';
			}
			$this->template->content = View::forge('posts/manage', $data);
		} else {
			
			//response access
			return Response::redirect('users/access_denied');
		}
	}
	
	/**
	 * The function use update post of user
	 *
	 * @access public
	 * @return all posts of user
	 *
	 */
	public function action_update() {
		$data=array();
		$data['post_id'] = Uri::segment(3);
		$this->template->title = "Post update - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Posts</a></li>
								<li class="active">Update</li>
						',false);
		//check user logged
		if (Session::get('token')) {
			//get info of post want to update
			$method = 'GET';
			$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]";
	
		    $rs = $this->init_curl(null, $method, $link);
			if ($rs['meta']['code'] == 200) {
				$data['post'] = $rs['data'];
			} else {
				$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong>'.$rs['meta']['messages'].'
		        				</div>';
			}
			
			//check submit to save data updated
			if (isset($_POST['save'])) {
				//set data to update
				$post['title'] = Input::post('title');
				$post['content'] = Input::post('content');
				$post['token'] = Session::get('token');
				$post['post_id'] = $data['post_id'];
				//set data in view to show data updated in form
				$data['post'] = $post ;
				//set method
				$method = 'PUT';
				$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/'.$data['post_id'];
				//call api
				$result = $this->init_curl($post, $method, $link);
				if ($result['meta']['code'] == 200) {
					$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong>Update success.
		        				</div>';
				} else {
					$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong>'.$result['meta']['messages'].'. Access is denied.
		        				</div>';
				}
				
			} elseif (isset($_POST['preview'])) {
				//preview
				$post['title'] = Input::post('title');
				$post['content'] = Input::post('content');
				$post['created_at'] = time();
				$post['modified_at'] = time();
				$data['post'] = $post;			
				
			}
			
			$this->template->content = View::forge('posts/update', $data);
		} else {
			return Response::redirect('users/access_denied');
		}
		
		
	}
	/**
	 * The function use to delete a post
	 * 
	 * @access public
	 * @return 
	 */
	public function action_delete() {
		$data = array();
		$this->template->title ="Post delete - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Posts</a></li>
								<li class="active">Delete</li>
						',false);
		$post['post_id'] = Uri::segment(3);
		//add token
		$post['token'] = Session::get('token');
		//link call api
		$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/'.$post['post_id'];
		$method = 'DELETE';
		$rs = $this->init_curl($post, $method, $link);
		//delete success
		if ($rs['meta']['code'] == 200) {
			return Response::redirect('posts/manage');
		} else {
			$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong>'.$rs['meta']['messages'].' Access is denied.
		        				</div>';
			$this->template->content = View::forge('posts/error', $data);
		}
		
	}
	/**
	 * The functio  use to update status of post unactive
	 * 
	 * @access public
	 * @return status
	 */
	public function action_unpublish() {
		$data = array();
		//set title
		$this->template->title = "Post error - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Posts</a></li>
								<li class="active">Un publish</li>
						',false);
		$post['post_id'] = Uri::segment(2);
		$post['token'] = Session::get('token');
		//set method and link
		$method = 'PUT';
		$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/'.$post['post_id'].'/inactive';
		$rs = $this->init_curl($post, $method, $link);
		if ($rs['meta']['code'] == 200) {
			return Response::redirect('posts/manage');
		} else {
			$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong>'.$rs['meta']['messages'].' Access is denied.
		        				</div>';
			$this->template->content = View::forge('posts/error', $data);
		}
		
	}
	
	/**
	 * The functio  use to update status of post active
	 *
	 * @access public
	 * @return status
	 */
	public function action_publish() {
	
		$data = array();
		//set title
		$this->template->title = "Post error - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Posts</a></li>
								<li class="active">Publish</li>
						',false);
		
		$post['post_id'] = Uri::segment(2);
		$post['token'] = Session::get('token');
		//set method and link
		$method = 'PUT';
		$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/'.$post['post_id'].'/active';
		$rs = $this->init_curl($post, $method, $link);
		if ($rs['meta']['code'] == 200) {
			return Response::redirect('posts/manage');
		} else {
			$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong>'.$rs['meta']['messages'].' Access is denied.
		        				</div>';
			$this->template->content = View::forge('posts/error', $data);
		}
	
	}
	
	/**
	 * The function  use to get all post of user
	 * @param user_id
	 * just get post have status publish
	 * @access public
	 * @return status
	 */
	public function action_get_all_user_posts() {
		$data = array();
		$this->template->title = "User posts - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Users</a></li>
								<li class="active">Posts</li>
						',false);
		//create data and call api
		$user_id = Uri::segment(2);
		
		$method = 'GET';
		$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/users/'.$user_id.'/posts';
		$rs = $this->init_curl(null, $method, $link);
		//check result
		//create data var to contain result
		
		$data['data'] = array();
		if ($rs['meta']['code'] == 200) {
			$data['data'] = $rs['data'];
			
			$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> Have '.$rs['meta']['result'].' posts in list .
		        				</div>';
		} else {
			
			$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> '.$rs['meta']['messages'].' 
		        				</div>';
		}
		//return the content of template
		$this->template->content = View::forge('posts/user_posts', $data);
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