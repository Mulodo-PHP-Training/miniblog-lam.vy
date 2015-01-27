<?php
namespace Model\V1;

use Fuel\Core\Log;
use Fuel\Core\Validation;
use Model;
use Fuel\Core\DB;
use Auth\Auth;
use Fuel\Core\Fieldset;
use Fuel\Core\Database_Connection;
/*
 * extends from Model
* @var Post contain method do some transaction with post table
* ex : create, update, delete, active/deactive the post
*
*/

class Comment extends \Orm\Model {
	//create table name for comment
	protected static $_table_name = 'comment';

	//create properties for comment
	protected  static  $_properties = array('id', 'content', 'post_id', 'author_id', 'created_at', 'modified_at');

	/*
	* method use to create a new comment
	* @param input data  include post_id, token, content, author_id
	* @return array data of the comment created
	*/
	public static function create_comment($data) {
		//check content not empty
		if (!empty($data['content'])) {
			
			try {
					
				//check exist post and post is actived in post db
				$post = Post::forge();
				//select user info from id input and check if user actived
				$entry = Post::find(
						'all',
						array('where' => array( array('id', $data['post_id']), array('status', 1))
						));

				//count data return > 0 is post exist
				if (count($entry) > 0) {
					//add comment in the post
					$time = time();
					$data['created_at'] = $time;
					$data['modified_at'] = $time;
					$comment = Comment::forge($data);
					$comment->save();
					//return the data of the comment
					return array(
					 		'meta' => array(
					 				'code' => SUSSCESS_CODE,
					 				'messages' => 'Create comment success!'
					 		),
					 		'data' => array(
					 				'id' => $comment->id,
					 				'content' => $comment->content,
					 				'post_id' => $comment->post_id,
					 				'author_id' => $comment->author_id,
					 				'created_at' => $comment->created_at,
					 				'modified_at' => $comment->modified_at
					 				
					 		)
					);
					
				} else {
					//return error array if user not exist
					return array(
							'meta' => array(
									'code' => COMMENT_ADD_ERROR ,
									'description' => COMMENT_ADD_DSC ,
									'messages' => COMMENT_ADD_MSG
							),
							'data' => null
					);
				}	
					
					
			} catch (\Exception $ex) {
				Log::error($ex->getMessage());
				return $ex->getMessage();
			}
			
		} else {
			//return error
			return array(
					'meta' => array(
							'code' => COMMENT_VALIDATE_ERROR ,
							'description' => COMMENT_VALIDATE_DSC ,
							'messages' => COMMENT_VALIDATE_MSG
					),
					'data' => null
			);
		}
		
	}
	
	/*
	* method use to update a comment
	* @param input data  include comment_id, author_id, content
	* @return array data of the comment updated
	*/
	public static function update_comment($data) {
		
		//check content not empty
		if (!empty($data['content'])) {				
			try {
				
				$time = time();
				
				$row = DB::update('comment')->set(
							array(									
									'content' => $data['content'],
									'modified_at' => $time
							))->where('id', $data['comment_id'])->where('author_id', $data['author_id'])->execute();	
				if ($row > 0) {
					//get info of post
					$data = DB::select('id', 'post_id', 'author_id', 'content', 'created_at', 'modified_at')
					->from('comment')
					->where('id', '=', $data['comment_id'])
					->execute();
					//return data of the comment updated
					return array(
							'meta' => array(
									'code' => SUSSCESS_CODE,
									'messages' => 'Update comment success!'
							),
							'data' =>$data[0]
					);
						
				} else {
					//return failed
						return array(
								'meta' => array(
										'code' => COMMENT_EDIT_ERROR,
										'description' => COMMENT_EDIT_DSC,
										'messages' => COMMENT_EDIT_MSG
								),
								'data' => null
								);
					
				}
				
			} catch(\Exception $ex) {
				Log::error($ex->getMessage());
				return $ex->getMessage();
			}
			
		} else {
			//return false for content null
			return false;
		}
	}
	
   /*
	* method use to check user have permission for delete a comment
	* owner of the post or comment can be remove it
	* @param input data  include post_id, comment_id, author_id
	* @return true or false
	*/
	
	public static function is_deletable($post_id, $comment_id, $author_id) {
		try {
			$query = DB::query("SELECT author_id FROM post WHERE id =:post_id UNION SELECT author_id FROM comment WHERE id =:comment_id ");
			$query->bind('post_id', $post_id);
			$query->bind('comment_id', $comment_id);
			$data = $query->execute();
			
			//print_r($query[0]['author_id']); die;
			$rs = false;
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]['author_id'] == $author_id) {
					$rs = true;
				}
				
			} 
			return $rs;
		} catch (\Exception $ex) {
			Log::error($ex->getMessage());
			return $ex->getMessage();
		}
	}
	
   /*
    * method use to delete a comment
    * @param comment_id
	* @return success code is 200 and message
	*/
	public static function delete_comment($comment_id) {
		try {
			$entry = DB::delete('comment')->where('id', '=', $comment_id)->execute();
			if ($entry == 1) {
				$rs = array(
						'meta' => array(
								'code' => SUSSCESS_CODE,
								'messages' => 'Delete comment success!'
						),
						'data' => null
				);
					
			} else {
				$rs = array(
						    'meta' => array(
						              'code' => COMMENT_DEL_ERROR,
						    		  'description' => COMMENT_DEL_DSC,
						    		  'messages' => COMMENT_DEL_MSG
				 	         ),
							'data' => null
					);
			}
			return $rs;
			
		} catch (\Exception $ex) {
			Log::error($ex->getMessage());
		}
	}
	
	/*
	* method use to get all comments of a post_id
	* @param post_id
	* @return code is 200 when get success
	* else return code is 3005 and error message
	*/
	public static function get_all_post_comments($post_id) {
		try {
			//select comments
			$query = DB::query("SELECT comment.id, comment.content, comment.author_id, comment.created_at, comment.modified_at, user.username FROM comment, user WHERE comment.post_id=:post_id AND comment.author_id=user.id ");
			$query->bind('post_id', $post_id);
			$rs = $query->execute();
			
			if (count($rs) > 0) {
				
				return $rs;
			} else {
				
				return false;
			}
			
			
		} catch(\Exception $ex) {
			Log::error($ex->getMessage());
			return $ex->getMessage();
		}
	}

	/*
	* method use to get all comments of a author_id
	* @param $author_id- the system id of user
	* @return code is 200 when get success
	* else return code is 3006 and error message
	*/
	public static function get_all_user_comments($author_id) {
		try {
			//select comments
			$query = DB::query(' SELECT comment.id, comment.content, comment.post_id, comment.created_at, comment.modified_at, post.title 
					FROM comment, post 
					WHERE comment.author_id = :author_id AND post.id = comment.post_id');
			$query->bind('author_id', $author_id);
			$rs = $query->execute();
				
			if (count($rs) > 0) {
	
				return $rs;
			} else {
	
				return false;
			}
				
				
		} catch(\Exception $ex) {
			Log::error($ex->getMessage());
			return $ex->getMessage();
		}
	}

}