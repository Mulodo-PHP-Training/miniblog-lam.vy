<?php
use Fuel\Core\Input;
use Fuel\Core\Security;
class Controller_Comments extends Controller_Template {
	
	protected $filters = array('strip_tags', 'htmlentities');
	
	
	/**
	 * The index function, comment page
	 *
	 * @access  public
	 * @return  Response
	 */
	
	public function action_index() {
		$data = array();
		$data['title']   = "Example Page";
		$data['content'] = "Don't show me in the template";
		$this->template->title = 'Example Page';
		$this->template->set('breadcrumbs', '<li class="active">Comments</li>', false);
		$this->template->content = View::forge('comments/index', $data);
	}
	
	/**
	 * The create comment function
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_create() {
		$rs = array();
		//check if call by ajax
		if (Input::is_ajax()) {
			//check permission for create comt
			if (Session::get('token')) {
				//create data
				$data['content'] = Security::clean(Input::post('content'), $this->filters);
				$data['token'] = Session::get('token');
				$data['post_id'] = Input::post('post_id');
				//call api to create comment
				$method = 'POST';
				$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments";
				$result = $this->init_curl($data, $method, $link);
				$rs = array();
				//check result return if success
				if ($result['meta']['code'] == 200) {
					//alert success mesg
					$rs['result'] = '<div class="alert alert-success" role="alert">
							<strong>Success!</strong> Your comment was posted.
				   	   </div>';
					
				} else {
					//alert error mesg
					$rs['result'] = '<div class="alert alert-warning" role="alert">
							<strong>Sorry!</strong> '.$result['meta']['message'].'
				   	   </div>';
				}
				
			} else {
				//alert error must be login to write a comment
				$rs['result'] = '<div class="alert alert-warning" role="alert">
							<strong>Sorry!</strong> You must logged for write comment.
				   	   </div>';
			}
			
			
		}
		return $rs['result'];
	}
	
	
	/**
	 * The get all comment of post function
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_get_all_post_comment() {
		$rs = array();
		if (Input::is_ajax()) {
			//create and call api to get all comments of this post
			$data['post_id'] = Input::post('post_id');
			$method = 'GET';
			$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments";
			
			$comments = $this->init_curl(null, $method, $link);
			if ($comments['meta']['code'] == 200) {
				$rs['data'] = $comments['data'];
			} else {
				$rs['data'] = '';
			}	
				
			//print_r($rs);die;
		}
		return json_encode($rs);
	}
	
	/**
	 * The function use to delete a comment.
	 * @param $post_id, comment id
	 * have check permission for this function on api
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_delete() {
		$data = array();
		
		//check ajax called
		if (Input::is_ajax()) {
			//check session for logged
			if (Session::get('token')) {
				//create data to call api
				$data['post_id'] = Input::post('post_id');
				$data['comment_id'] = Input::post('id');
				$data['token'] = Session::get('token');
				
				//set method and link
				$method = 'DELETE';
				$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
				$rs = $this->init_curl($data, $method, $link);
				//check for sucess
				if ($rs['meta']['code'] == 200) {
					//return 1 for success
					return 1;
				} else {
					return 2;
				}
			} else {
				//return 0 b/c user not login
				return 0;
			}
		}
		
		
	}
	
	/**
	 * The function use to update a comment.
	 * @param $post_id, comment id, content
	 * have check permission for this function on api
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_update() {
		$data = array();
	
		//check ajax called
		if (Input::is_ajax()) {
			//check session for logged
			if (Session::get('token')) {
				//create data to call api
				$data['post_id'] = Input::post('post_id');
				$data['comment_id'] = Input::post('comment_id');
				$data['content'] = Security::clean(Input::post('content'), $this->filters);
				$data['token'] = Session::get('token');
				if (empty($data['content'])) {
					return 3;
				} else {
					//set method and link
					$method = 'PUT';
					$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
					$rs = $this->init_curl($data, $method, $link);
					//check for sucess
					if ($rs['meta']['code'] == 200) {
						//return 1 for success
						return 1;
					} else {
						//return if have error
						return 2;
					}
				}
				
			} else {
				//return 0 b/c user not login
				return 0;
			}
		}
	
	
	}
	
	/**
	 * The function  use to get all comments of user
	 * @param user_id
	 * 
	 * @access public
	 * @return status
	 */
	public function action_get_all_user_comments() {
		$data = array();
		$this->template->title = "User comments - Miniblog";
		$this->template->set('breadcrumbs', '<li><a href="#">Users</a></li>
								<li class="active">Comments</li>
						',false);
		//create data and call api
		$user_id = Uri::segment(2);
	
		$method = 'GET';
		$link = 'http://localhost/miniblog/miniblog-lam.vy/src/v1/users/'.$user_id.'/comments';
		$rs = $this->init_curl(null, $method, $link);
		//check result
		//create data var to contain result
	
		$data['data']= array();
		if ($rs['meta']['code'] == 200) {
			$data['data'] = $rs['data'];
				
			$data['result'] = '<div class="alert alert-success" role="alert">
									<strong>Success!</strong> Have '.$rs['meta']['result'].' comments in list .
		        				</div>';
		} else {
				
			$data['result'] = '<div class="alert alert-warning" role="alert">
									<strong>Sorry!</strong> '.$rs['meta']['messages'].'
		        				</div>';
		}
		//return the content of template
		$this->template->content = View::forge('comments/user_comments', $data);
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