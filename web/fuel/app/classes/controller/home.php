<?php
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
 * The Home Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Home extends Controller_Template {

	
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	
	public function action_index()
	{
		$data = array();
		$data['title']   = "Home - Miniblog";
		$data['content'] = "";
		$this->template->title = "Home - Miniblog";
		$this->template->breadcrumbs = "";
		//get all post 
		$method = "GET";
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts";
		$rs = $this->init_curl(null, $method, $link);
		
		//config page
		$config = array(
				'name' => 'bootstrap3', 
				'pagination_url' => Uri::base(false).'',
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
		
		$start = $pagination->offset;
		$row = $pagination->per_page;
		
		$data['data'] = $this->get_post_page($start, $row);
		$data['pagination'] = $pagination;
		$this->template->content = View::forge('home/index', $data);
		
	}

	public function get_post_page($start, $row) {
		
		$method = "GET";
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/page/$start/$row";
		$rs = $this->init_curl(null, $method, $link);
		
		return $rs['data'];
		
	}
	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello() {
		return Response::forge(Presenter::forge('welcome/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404() {
		return Response::forge(Presenter::forge('welcome/404'), 404);
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
