<?php
namespace com\fastchat\posts ;
use com\fastchat\database\SqlHelper ;
	



	class SocialPostHelper { 
		

		const SQL_ADDPUBLICPOST = "INSERT INTO posts (body,posted_by,privacy) 
									VALUES('%1','%2','%3')" ;

		const SQL_ADDPOST = "INSERT INTO posts (body,posted_by,posted_to,privacy) 
									VALUES('%1','%2','%3','%4')" ;


		const SQL_GETNUMPOSTS = "SELECT count(*) as number FROM posts WHERE posted_by = '%1' AND hidden = false " ;

		const SQL_GETMYPOSTS = "SELECT * FROM posts 
									WHERE posted_by = '%1' AND hidden = false " ;

		const SQL_GETALLPOSTS = "SELECT p.*,u.firstname,u.surname,a.asset FROM posts p 
				JOIN users u ON u.id = p.posted_by  
				JOIN avatars a ON a.id = u.avatarId 
				WHERE p.hidden = false AND u.active = true Order By created DESC" ;

		const SQL_GETPOSTSFROMFRIENDS = "SELECT p.*,usr.firstname,usr.surname,a.asset FROM posts p 
			JOIN users usr ON usr.id = p.posted_by
			JOIN avatars a ON a.id = usr.avatarId 
			WHERE p.posted_by IN 
				(SELECT u.id FROM friends f 
					JOIN users u ON u.id =  f.friendId  AND u.active = true 
					WHERE f.userId = '%1') AND p.hidden = false AND p.post_root IS NULL ORDER BY created DESC" ;


		const SQL_GETPOSTCOUNTFROMFRIENDS = "SELECT count(*) as number FROM posts p 
					WHERE p.posted_by IN 
						(SELECT u.id FROM friends f 
							JOIN users u ON u.id =  f.friendId  AND u.active = true 
							WHERE f.userId = '%1') AND p.hidden = false AND p.post_root IS NULL" ;


		const SQL_GETPOSTSFROMFRIENDSANDMYSELF = "SELECT p.*,usr.firstname,usr.surname,a.asset FROM posts p 
			JOIN users usr ON usr.id = p.posted_by
			JOIN avatars a ON a.id = usr.avatarId 
			WHERE p.posted_by IN 
				(SELECT u.id FROM friends f 
					JOIN users u ON u.id =  f.friendId  AND u.active = true 
					WHERE f.userId = '%1'
				UNION SELECT '%1'
					)  AND p.hidden = false AND p.post_root IS NULL ORDER BY created DESC" ;

		const SQL_GETPOSTCOUNTFROMFRIENDSANDMYSELF = "SELECT count(*) as number FROM posts p 
					WHERE p.posted_by IN 
						(SELECT u.id FROM friends f 
							JOIN users u ON u.id =  f.friendId  AND u.active = true 
							WHERE f.userId = '%1'
						UNION SELECT '%1'
							)  AND p.hidden = false AND p.post_root IS NULL" ;


		private $sqlHelper ;
		
		public function __construct($sqlHelper) {

                $this->sqlHelper = $sqlHelper ;
        }

		
		public function connect() {
			$this->sqlHelper->connect() ;
			
		}
	
		public function close() {
			$this->sqlHelper->close() ;
			
		}
		
		public function getPostCount($from) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETNUMPOSTS,$from)) ;
			$size = $results[0]['number'] ;
			
			$this->sqlHelper->close() ;
			
			return $size ;
		} 
		
		public function getPostCountFromFriends($userId) {

			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETPOSTCOUNTFROMFRIENDSANDMYSELF,$userId)) ;
			$size = $results[0]['number'] ;

			$this->sqlHelper->close() ;
			
			return $size ;
		} 

		public function getPostsFromFriends($userId,$limit,$page = 0) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$query = self::SQL_GETPOSTSFROMFRIENDSANDMYSELF ;
			$offset = $page * $limit ;
			$query .= " LIMIT $offset,$limit" ;
			$results = $helper->buildQueryResult($helper->buildQueryString($query,$userId)) ;
			$this->sqlHelper->close() ;
			
			return $results ;
		} 
		
		public function getActivePosts() {
			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETALLPOSTS)) ;

			$this->sqlHelper->close() ;

			return $results ;
		}
		
		public function getPosts($from) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETMYPOSTS,$from)) ;

			$this->sqlHelper->close() ;
			
			return $results ;
		} 

		public function addPost($message,$from,$to=null,$privacy='public') {
			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$filteredMessage = $helper->escapeStringAndRemoveTags($message) ;

			// Ignore empty messages.
			if ($filteredMessage != "") {
				
				if ($to != null) {
					$query = $helper->buildQueryString(self::SQL_ADDPOST,$filteredMessage,$from,$to,$privacy) ;
				} else {
					$query = $helper->buildQueryString(self::SQL_ADDPUBLICPOST,$filteredMessage,$from,$privacy) ;
				}
				
				$result = $helper->buildUpdateResult($query) ;
				$this->close() ;
				return $result ;
			}
			
			$this->sqlHelper->close() ;
			// flag empty message 
			return false;
		} 
		

		
		private function stripTagsAndEscape($message) {
			
			return $message ;
		}

	}
	
	
?>
