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
class Test_Model_V1_Comment extends TestCase {

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
	 *
	 */
	public function test_create_post() {
		//create data
		
		$data = array(
				'author_id' => self::$user['id'],
				'post_id' => '49',
				'content' => 'update comment test in model',
				);
		$rs = Comment::create_comment($data);
		$this->assertEquals('200', $rs['meta']['code']);
		$this->assertGreaterThan(0, $rs['data']['id']);
		$this->assertEquals($data['author_id'], $rs['data']['author_id']);
		$this->assertEquals($data['post_id'], $rs['data']['post_id']);
	}
	
	/**
	 * use test create the comment is not ok, content null
	 * method POST
	 * compare with code is 1003
	 * @group create_comment_notok
	 *
	 */
	public function test_create_post_empty() {
		//create data
	
		$data = array(
				'author_id' => self::$user['id'],
				'post_id' => '49',
				'content' => '',
		);
		$rs = Comment::create_comment($data);
		$this->assertEquals('1003', $rs['meta']['code']);
		
	}
	/**
	 * use test create the comment is not ok, post_id not exist
	 * method POST
	 * compare with code is 3001
	 * @group create_comment_notok
	 *
	 */
	public function test_create_post_notok() {
		//create data
	
		$data = array(
				'author_id' => self::$user['id'],
				'post_id' => '39',
				'content' => 'test post comment in model',
		);
		$rs = Comment::create_comment($data);
		$this->assertEquals('3001', $rs['meta']['code']);
	
	}
	
}