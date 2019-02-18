<?php
namespace com\fastchat\dao ;
use com\fastchat\database\SqlHelper ;

	
	 
	class MessageDao { 
		const SQL_GETMESSAGES = "SELECT p.*,u.firstname,u.surname,a.asset FROM posts p 
									JOIN users u ON u.id = p.posted_by
									JOIN avatars a ON a.id = u.avatarId
									WHERE p.post_root = '%1' AND p.hidden = false AND p.type = 'message' Order by created DESC" ;
									



		const SQL_GETNUMMESSAGES = "SELECT count(*) as number FROM posts p WHERE p.posted_by = '%1' AND p.hidden = false AND p.type = 'message'" ;
		const SQL_ADDMESSAGE = "INSERT INTO posts (body,posted_by,post_root,type) VALUES('%1','%2','%3','message')" ;
		const SQL_SHOWMESSAGE = "UPDATE posts SET 'hidden' = false WHERE id = '%1'" ;


		private $sqlHelper ;
		
		public function __construct() {
        	$this->sqlHelper = new SqlHelper() ;
        }


		public function getMessageCount($userId) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETNUMMESSAGES,$userId)) ;
			$size = $results[0]['number'] ;
			
			$this->sqlHelper->close() ;
			
			return $size ;
		} 


		public function getMessageThread($postId) {

			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETCOMMENTS,$postId)) ;

			$this->sqlHelper->close() ;
			
			return $results ;
				
		} 
	
		public function addMessage($message,$userId,$toUser) {
			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$query = $helper->buildQueryString(self::SQL_ADDMESSAGE,$helper->escapeStringAndRemoveTags($message),$userId,$toUser) ;
			$results = $helper->buildUpdateResult($query) ;

			$this->sqlHelper->close() ;
			return $results  ;
		}


	}
	
?>
