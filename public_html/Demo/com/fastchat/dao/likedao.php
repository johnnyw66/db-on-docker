<?php
namespace com\fastchat\dao ;
use com\fastchat\database\SqlHelper ;

	
	 
	class LikeDao { 
		
		const EMO_TYPE_LIKE 	= 'LIKE' ;
		const EMO_TYPE_CRY 		= 'CRY' ;
		const EMO_TYPE_LAUGH 	= 'LAUGH' ;
	
		const SQL_GETUSERLIKES 	= 	"SELECT count(*) as number 
									FROM likes l 
									JOIN posts p ON p.id = l.post_id 
									JOIN users u ON u.id = l.liked_by 
									WHERE p.hidden = false AND u.active = true AND  p.posted_by = '%1' AND l.like_type='%2'" ; 


		const SQL_GETLIKESONPOST =	"SELECT u.* FROM likes l 
									JOIN users u ON u.id = l.liked_by
									JOIN posts p ON p.id = l.post_id
		 							WHERE l.post_id = '%1' AND l.like_type='%2' AND p.hidden = false AND u.active = true" ;
		
		
		
		const SQL_DOESUSERLIKESPOST = "SELECT count(*) as number 
										FROM likes l 
										WHERE  l.liked_by = '%1' AND l.post_id = '%2' AND l.like_type = '%3'" ;

		const SQL_UPDATE_USERLIKESPOST =	"INSERT INTO likes (liked_by,post_id,like_type) VALUES( '%1', '%2', '%3')" ;

		const SQL_UPDATE_USERREVOKELIKESPOST =	"DELETE FROM likes WHERE liked_by = '%1' AND post_id ='%2' AND like_type = '%3'" ;

		private $sqlHelper ;
		
		public function __construct() {

                $this->sqlHelper = new SqlHelper() ;
        }

				
		
		public function getLikesCountFromUserId($userId) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETUSERLIKES,$userId,self::EMO_TYPE_LIKE)) ;
			$this->sqlHelper->close() ;
			
			return $results[0]['number'] ;
		} 


		public function getLikesOnPost($postId) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETLIKESONPOST,$postId,self::EMO_TYPE_LIKE)) ;
			$this->sqlHelper->close() ;
			
			return $results ;
		} 


		// LIKES AND DISLIKES (CRY and LAUGH emo's are reserved for future use)
		//@DEPRECATED
		//public function getLikesCount($userId) {
		//	return $this->getLikesCountFromUserId($userId) ;
		//}
	

		public function revokelikePost($userId,$postId) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_UPDATE_USERREVOKELIKESPOST,$userId,$postId,self::EMO_TYPE_LIKE)) ;
			
			$this->sqlHelper->close() ;
			
			return $results ;
		} 

		public function likePost($userId,$postId) {

			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_UPDATE_USERLIKESPOST,$userId,$postId,self::EMO_TYPE_LIKE)) ;

			$this->sqlHelper->close() ;
			
			return $results ;
		} 
		

		public function doesUserLikePost($userId,$postId) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_DOESUSERLIKESPOST,$userId,$postId,self::EMO_TYPE_LIKE)) ;
			$size = $results[0]['number'] ;
			
			$this->sqlHelper->close() ;
			
			return $size ;
		} 
		

	}
	
	
?>
