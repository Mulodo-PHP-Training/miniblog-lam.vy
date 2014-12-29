<?php
use Model\V1\Post;
use Model\V1\Comment;
use Model\V1\User;
/**
 * The Test for Post Controller version 1.
 * @extends TestCase
 *
 * @author Lam Vy
 * @group Comment
 */
class Test_Controller_V1_Comment extends TestCase {

	protected static $user = array();
	/**
	 * called before each test method
	 * @before
	*/
	public function setUp() {
			
	}

	/**
	 * called after each test method
	 * @after
	 */
	public function tearDown() {
		//to do
	  
	}
	public static function setUpBeforeClass() {
		self::$user = self::do_login();
	}
	/**
	 * Cleanup test resource (CLASS LEVEL).
	 */
	public static function tearDownAfterClass() {

		self::do_logout(self::$user['token']);
		self::$user = null;
	}
	/**
	 * funtion to test login ok
	 *
	 * @return the data of user logged
	 */
	public static function do_login() {
		//create data to test ok
		$username = 'kenny4';
		$password = '12345';
		$rs = User::login($username, $password);
		//compare id return is greater than 0 is login ok
			
		return $rs;
	
	
	}
	
	/**
	 * funtion to test logout after login ok
	 *
	 * @return reset token in db
	 */
	public static function do_logout($token) {
	
		$rs = User::logout($token);
	
	}
	

	/**
	 * use test create the comment is ok
	 * method POST
	 * compare with code is 200
	 * @group create_comment_ok
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments
	 */
	public function test_create_post() {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '49',
				'content' => 'update comment test in model',
		);
		$method = 'POST';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments";
		$rs = $this->init_curl($data, $method, $link);
		
		$this->assertEquals('200', $rs['meta']['code']);
		$this->assertGreaterThan(0, $rs['data']['id']);
		$this->assertEquals($data['post_id'], $rs['data']['post_id']);
	}
	
	/**
	 * use test create the comment is not ok, content null
	 * method POST
	 * compare with code is 1003
	 * @group create_comment_notok
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments
	 *
	 */
	public function test_create_post_empty() {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '49',
				'content' => '',
		);
		$method = 'POST';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments";
		$rs = $this->init_curl($data, $method, $link);
		
		$this->assertEquals('1003', $rs['meta']['code']);
	
	}
	/**
	 * use test create the comment is not ok, post_id not exist
	 * method POST
	 * compare with code is 3001
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments
	 * @group create_comment_notok
	 *
	 */
	public function test_create_post_notok() {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '39',
				'content' => 'test post comment in model',
		);
		$method = 'POST';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments";
		$rs = $this->init_curl($data, $method, $link);
		
		$this->assertEquals('3001', $rs['meta']['code']);
	
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