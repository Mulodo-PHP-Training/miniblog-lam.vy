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
	public function test_create_comment() {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '49',
				'content' => 'update comment test in controller',
		);
		$method = 'POST';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments";
		$rs = $this->init_curl($data, $method, $link);
		
		$this->assertEquals('200', $rs['meta']['code']);
		$this->assertGreaterThan(0, $rs['data']['id']);
		$this->assertEquals($data['post_id'], $rs['data']['post_id']);
		
		return $rs['data'];
	}
	
	/**
	 * use test create the comment is not ok, content null
	 * method POST
	 * compare with code is 1003
	 * @group create_comment_notok
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments
	 *
	 */
	public function test_create_comment_empty() {
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
	public function test_create_comment_notok() {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '39',
				'content' => 'test comment comment in controller',
		);
		$method = 'POST';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments";
		$rs = $this->init_curl($data, $method, $link);
		
		$this->assertEquals('3001', $rs['meta']['code']);
	
	}
	

	/**
	 * use test update the comment is ok
	 * method PUT
	 * compare with code is 200
	 * @group update_comment_ok
	 * @depends test_create_comment
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments/{comment_id}
	 */
	public function test_update_comment($comment) {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'comment_id' => $comment['id'],
				'post_id' => '49',
				'content' => 'update comment '.$comment['id'].' test in controller',
		);
		$method = 'PUT';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
		$rs = $this->init_curl($data, $method, $link);
	
		$this->assertEquals('200', $rs['meta']['code']);
		$this->assertEquals($data['comment_id'], $rs['data']['id']);
	}
	
	/**
	 * use test update the comment is not ok, content null
	 * method PUT
	 * compare with code is 1003
	 * @group update_comment_notok
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments/{comment_id}
	 * @depends test_create_comment
	 */
	public function test_update_comment_empty($comment) {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '49',
				'comment_id' => $comment['id'],
				'content' => '',
		);
		$method = 'PUT';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
		$rs = $this->init_curl($data, $method, $link);
	
		$this->assertEquals('1003', $rs['meta']['code']);
	
	}
	/**
	 * use test update the comment is not ok, comment_id not exist
	 * method PUT
	 * compare with code is 3002
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments/{comment_id}
	 * @group update_comment_notok
	 *
	 */
	public function test_update_comment_notok() {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '49',
				'comment_id' => '0',
				'content' => 'test comment comment in controller',
		);
		$method = 'PUT';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
		$rs = $this->init_curl($data, $method, $link);
		
	  	//compare with error code comment_id not exist
		$this->assertEquals('3002', $rs['meta']['code']);
	
	}
	
	/**
	 * use test delete comment is ok
	 * method DELETE
	 * compare with code is 200
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments/{comment_id}
	 * @group delete_comment_ok
	 * @depends test_create_comment
	 */
	public function test_delete_comment_ok($comment) {
		//create data
	
		$data = array(
				'token' => self::$user['token'],
				'post_id' => $comment['post_id'],
				'comment_id' => $comment['id'],
				
		);
		$method = 'DELETE';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
		$rs = $this->init_curl($data, $method, $link);
		
	  	//compare with error code comment_id not exist
		$this->assertEquals('200', $rs['meta']['code']);
	 
	}
	
	/**
	 * use test delete comment is not ok
	 * method DELETE
	 * compare with code is 3003 b/c comment id not exist
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments/{comment_id}
	 * @group delete_comment_notok
	 */
	public function test_delete_comment_notok() {
		//create data
	    //the comment not exist
	    //return error code 3004
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '49',
				'comment_id' => '0',
	
		);
		$method = 'DELETE';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
		$rs = $this->init_curl($data, $method, $link);
	
		//compare with error code comment_id not exist
		$this->assertEquals('3003', $rs['meta']['code']);
	
	}
	/**
	 * use test is_deletable not ok
	 * method DELETE
	 * compare with code is 3004 b/c access is denied
	 * link http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/{post_id}/comments/{comment_id}
	 * @group delete_comment_notok
	 */
	public function test_is_deletable_notok() {
		//create data
		//the user logged is not owner of comment or post
		//return error code 3004
		$data = array(
				'token' => self::$user['token'],
				'post_id' => '0',
				'comment_id' => '0',
	
		);
		$method = 'DELETE';
		$link = "http://localhost/miniblog/miniblog-lam.vy/src/v1/posts/$data[post_id]/comments/$data[comment_id]";
		$rs = $this->init_curl($data, $method, $link);
	
		//compare with error code comment_id not exist
		$this->assertEquals('3004', $rs['meta']['code']);
	
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