<?php
use Model\V1\Post;
use Model\V1\User;
use Model\V1\Comment;
use Fuel\Core\Controller_Rest;
use Auth\Auth;
use Fuel\Core\Validation;
use Fuel\Core\Security;
use Fuel\Core\Input;
use Fuel\Core\Uri;

/**
 * The Comment Controller.
 * @extends  Controller_Rest for API
 * A post controller have function for comment use the blog system
 * @package  app
 *
 */
class Controller_V1_Comment extends Controller_Rest {
	
	//return json format
	protected $format = 'json';
	//clean data
	protected $filters = array('strip_tags', 'htmlentities');
	
	/**
	 * The method add new comment in the post
	 * @link http://localhost/v1/posts/{post_id}/comments
	 * @method : POST
	 * @access  public
	 * @return  Response
	 */
	public function post_create_comment() {
		//check token 
		$token = Security::clean(Input::post('token'), $this->filters);
		
		if (empty($token)) {
			
			//return error 1202 token invalid
			return $this->response(array(
					'meta' => array(
							'code' => TOKEN_NULL_ERROR ,
							'description' => TOKEN_NULL_DESC ,
							'messages' => TOKEN_NULL_MSG,
					) ,
					'data' => null,
			));
			
		} else {
			//check token valid
			$rs = User::check_token($token);
			if (is_numeric($rs) && $rs > 0) {
				//data of comment
				
				//get post id from segment
				$data['post_id'] = Uri::segment(3);
				$data['content'] = Security::clean(Input::post('content'), $this->filters);
				$data['author_id'] = $rs;
				 	
				$comment = Comment::create_comment($data);
				//return result
				return $this->response($comment);
				
			} else {
				//return token invalid error
				return $this->response($rs);
			}
			
			
		}
		
	}
	
	/**
	 * The method edit comment of a post
	 * @link http://localhost/v1/posts/{post_id}/comments/{comment_id}
	 * @method : PUT
	 * @access  public
	 * @return  Response
	 */
	public function put_update_comment(){
		//get token
		$token = Security::clean(Input::put('token'), $this->filters);
		//check token
		if (empty($token)) {
			
			//return error 1202 token invalid
			return $this->response(array(
					'meta' => array(
							'code' => TOKEN_NULL_ERROR ,
							'description' => TOKEN_NULL_DESC ,
							'messages' => TOKEN_NULL_MSG,
					) ,
					'data' => null,
			));
				
		} else {
			
			//check token valid
			$rs = User::check_token($token);
			
			if (is_numeric($rs) && $rs >0) {
				//edit comment
				$data['comment_id'] = Uri::segment(5);
				$data['content'] = Security::clean(Input::put('content'), $this->filters);
				$data['author_id'] = $rs;
				$result = Comment::update_comment($data);
				if (false !== $result) {
					
					return $this->response($result);
					
				} else {
					return $this->response(
							array(
									'meta' => array(
											'code' => COMMENT_VALIDATE_ERROR ,
											'description' => COMMENT_VALIDATE_DSC ,
											'messages' => COMMENT_VALIDATE_MSG
									),
									'data' => null
							)
					);
				}
			} else {
				return $this->response($rs);
			}
		}
		
	}
	
	/**
	 * The method delete comment of a post
	 * @link http://localhost/v1/posts/{post_id}/comments/{comment_id}
	 * @method : DELETE
	 * @access  public
	 * @return  Response
	 */
	public function delete_comment() {
		$post_id = Uri::segment(3);
		$comment_id = Uri::segment(5);
		$token = Security::clean(Input::delete('token'), $this->filters);
		if (empty($token)) {

			//return error 1202 token invalid
			return $this->response(array(
					'meta' => array(
							'code' => TOKEN_NULL_ERROR ,
							'description' => TOKEN_NULL_DESC ,
							'messages' => TOKEN_NULL_MSG,
					) ,
					'data' => null,
			));
		} else {
			//check token
			$rs = User::check_token($token);
			if (is_numeric($rs) && $rs > 0) {
				$author_id = $rs; 
				//check permission for delete, the owner of post or comment id can be del it
				$deletable = Comment::is_deletable($post_id, $comment_id, $author_id);
				//var_dump($check); die;
				if (true == $deletable) {
					//delete comment
					$result = Comment::delete_comment($comment_id);
					return $this->response($result);
				
				} else {
					return $this->response(
						array(
						    'meta' => array(
						              'code' => COMMENT_DEL_PERMISSION_ERROR,
						    		  'description' => COMMENT_DEL_PERMISSION_DSC,
						    		  'messages' => COMMENT_DEL_PERMISSION_MSG
				 	         ),
							'data' => null
					)
					);
				}
			} else {
				return $this->response($rs);
			}
		}
		
		return $this->response($post_id);
	}
}