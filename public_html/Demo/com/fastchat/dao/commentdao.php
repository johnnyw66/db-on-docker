<?php
namespace com\fastchat\dao ;
use com\fastchat\database\SqlHelper ;

	
	 
	class CommentDao { 
		const SQL_GETCOMMENTS = "SELECT p.*,u.firstname,u.surname,a.asset FROM posts p 
									JOIN users u ON u.id = p.posted_by
									JOIN avatars a ON a.id = u.avatarId
									WHERE p.post_root = '%1' AND p.hidden = false AND p.type = 'post' Order by created DESC" ;
									



		const SQL_GETNUMCOMMENTS = "SELECT count(*) as number FROM posts p WHERE p.post_root = '%1' AND p.hidden = false AND p.type = 'post'" ;
		const SQL_ADDCOMMENT = "INSERT INTO posts (body,posted_by,post_root) VALUES('%1','%2','%3')" ;
		const SQL_REMOVECOMMENT = "UPDATE posts SET 'hidden' = true WHERE id = '%1'" ;
		const SQL_SHOWCOMMENT = "UPDATE posts SET 'hidden' = false WHERE id = '%1'" ;


		private $sqlHelper ;
		
		public function __construct() {
        	$this->sqlHelper = new SqlHelper() ;
        }


		public function getCommentsCount($postId) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETNUMCOMMENTS,$postId)) ;
			$size = $results[0]['number'] ;
			
			$this->sqlHelper->close() ;
			
			return $size ;
		} 


		public function getComments($postId) {

			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETCOMMENTS,$postId)) ;

			$this->sqlHelper->close() ;
			
			return $results ;
				
		} 
	
		public function addComment($post_id,$message,$userId) {
			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$query = $helper->buildQueryString(self::SQL_ADDCOMMENT,$helper->escapeStringAndRemoveTags($message),$userId,$post_id) ;
			$results = $helper->buildUpdateResult($query) ;

			$this->sqlHelper->close() ;
			return $results  ;
		}


	}
	
?>
