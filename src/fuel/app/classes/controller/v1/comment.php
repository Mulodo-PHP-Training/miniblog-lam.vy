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
	public function post_comment() {
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

}