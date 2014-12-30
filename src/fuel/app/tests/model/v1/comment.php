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
	public function test_create_comment() {
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
		
		return $rs['data']['id'];
	}
	
	/**
	 * use test create the comment is not ok, content null
	 * method POST
	 * compare with code is 1003
	 * @group create_comment_notok
	 *
	 */
	public function test_create_comment_empty() {
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
	public function test_create_comment_notok() {
		//create data
	
		$data = array(
				'author_id' => self::$user['id'],
				'post_id' => '39',
				'content' => 'test post comment in model',
		);
		$rs = Comment::create_comment($data);
		$this->assertEquals('3001', $rs['meta']['code']);
	
	}
	
	/**
	 * use test update the comment is ok
	 * method POST
	 * compare with code is 200
	 * @group update_comment_ok
	 * @depends test_create_comment
	 */
	public function test_update_comment($comment_id) {
		//create data
	
		$data = array(
				'author_id' => self::$user['id'],
				'comment_id' => $comment_id,
				'content' => 'update comment '.$comment_id.' test in model',
		);
		$rs = Comment::update_comment($data);
		$this->assertEquals('200', $rs['meta']['code']);
		$this->assertGreaterThan(0, $rs['data']['id']);
		$this->assertEquals($data['author_id'], $rs['data']['author_id']);
	}
	
	/**
	 * use test update the comment is not ok, content null
	 * method POST
	 * compare with code is 1003
	 * @group update_comment_notok
	 * @depends test_create_comment
	 */
	public function test_update_comment_empty($comment_id) {
		//create data
	
		$data = array(
				'author_id' => self::$user['id'],
				'comment_id' => $comment_id,
				'content' => '',
		);
		$rs = Comment::create_comment($data);
		$this->assertEquals('1003', $rs['meta']['code']);
	
	}
	
	/**
	 * use test update the comment is not ok, comment_id not exist
	 * compare with code is 3002
	 * @group update_comment_notok
	 *
	 */
	public function test_update_comment_notok() {
		//create data
	
		$data = array(
				'author_id' => self::$user['id'],
				'comment_id' => '0',
				'content' => 'test update comment in model comment id not exist',
		);
		$rs = Comment::update_comment($data);
		$this->assertEquals('3002', $rs['meta']['code']);
	
	}
	/**
	 * use test is_deletable is ok
	 * return true
	 * compare with true
	 * @group is_deletable_ok
	 * @dataProvider is_deletable_ok_provider
	 */
	public function test_is_deletable_ok($data) {
		
		$rs = Comment::is_deletable($data['post_id'], $data['comment_id'], $data['author_id']);
		$this->assertTrue($rs);
	
	}
	/**
	 * use test is_deletable is not ok
	 * the author_id not owner of post or comment
	 * compare with false
	 * @group is_deletable_notok
	 */
	public function test_is_deletable_notok() {
	
		$data = array(
				'author_id' => '0',
				'post_id' => '49',
				'comment_id' => '16'
				);
		$rs = Comment::is_deletable($data['post_id'], $data['comment_id'], $data['author_id']);
		$this->assertFalse($rs);
	
	}
	
	/**
	 * use test delete comment  ok
	 * compare with code 200
	 * @group delete_comment_ok
	 * @depends test_create_comment
	 */
	public function test_delete_comment_ok($comment_id) {
		
		$rs = Comment::delete_comment($comment_id);
		$this->assertEquals('200', $rs['meta']['code']);
	
	}
	
	/**
	 * use test delete comment  ok
	 * compare with code 200
	 * @group delete_comment_ok
	 */
	public function test_delete_comment_notok() {
	
		$rs = Comment::delete_comment(0);
		$this->assertEquals('3003', $rs['meta']['code']);
	
	}
	
	/**
	 * Define test data for test is_deletable ok
	 *
	 * @return array Test data
	 */
	public function is_deletable_ok_provider() {
		$test_data = array();
		//owner the comment
		$test_data[][] = array(
			'author_id' => '210',
			'post_id' => '49',
			'comment_id' => '16'
		);
		//owner of the post
		
		$test_data[][] = array(
			'author_id' => '89',
			'post_id' => '49',
			'comment_id' => '16'
		);
		
		return $test_data;
	}
	
}