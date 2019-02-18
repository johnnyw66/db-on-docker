<?php
namespace com\fastchat\posts ;
use com\fastchat\database\SqlHelper ;
	const EMO_TYPE_LIKE 	= 'LIKE' ;
	const EMO_TYPE_CRY 		= 'CRY' ;
	const EMO_TYPE_LAUGH 	= 'LAUGH' ;
	
	/* 
		SELECT * FROM posts p WHERE posted_by IN (SELECT u.id FROM friends f JOIN users u ON u.id =  f.friendId  AND u.active = true WHERE f.userId = '%1') AND p.hidden = false  ;

		(SELECT u.id FROM friends f 
		JOIN users u ON u.id =  f.friendId  AND u.active = true WHERE f.userId = '103')  ;


		SELECT * FROM posts p JOIN users u on u.id = p.posted_by ;
		Get likes on post_id
		
		SELECT * FROM likes WHERE post_id = ' ;
		
		'POST table' --> id, posted_by, posted_to, body, created, hidden, privacy (seen by 'me', 'friends' 'public')
		'LIKE table' --> id, post_id,liked_by like_type enum{'LIKE','LAUGH','CRY'} (EMO_TYPE_*)
	*/
	
	const SQL_ADDLIKE = "INSERT INTO likes (post_id,liked_by,like_type) 
							VALUES('%1','%2','%3')" ;

	const SQL_GETUSERLIKES = "SELECT count(*) as number FROM likes l JOIN posts p ON p.id = l.post_id WHERE p.posted_by = '%1' AND l.like_type = '%2' AND p.hidden = false " ;

	const SQL_GETLIKESONPOST 	= "SELECT u.* FROM likes l 
							JOIN users u ON u.id = l.liked_by
							JOIN posts p ON p.id = l.post_id
	 						WHERE l.post_id = '%1' AND l.like_type='%2' AND p.hidden = false AND u.active = true" ;

	const SQL_DOESUSERLIKESPOST = "SELECT count(*) as number FROM likes l 
						 		WHERE l.post_id = '%2' AND l.liked_by = '%1' AND l.like_type = '%3'" ;

	const SQL_UPDATE_USERLIKESPOST =	"INSERT INTO likes (liked_by,post_id,like_type) VALUES( '%1', '%2', '%3')" ;

	const SQL_UPDATE_USERREVOKELIKESPOST =	"DELETE FROM likes WHERE liked_by = '%1' AND post_id ='%2' AND like_type = '%3'" ;
	
	
	const SQL_GETCOMMENTS = "SELECT p.*,u.firstname,u.surname,a.asset FROM posts p 
							JOIN users u ON u.id = p.posted_by
							JOIN avatars a ON a.id = u.avatarId
							WHERE post_root = '%1' AND hidden = false Order by created DESC" ;


	const SQL_GETNUMCOMMENTS = "SELECT count(*) as number FROM posts p WHERE post_root = '%1' AND hidden = false" ;

	const SQL_ADDPUBLICPOST = "INSERT INTO posts (body,posted_by,privacy) 
								VALUES('%1','%2','%3')" ;
								
	const SQL_ADDPOST = "INSERT INTO posts (body,posted_by,posted_to,privacy) 
								VALUES('%1','%2','%3','%4')" ;
	
	const SQL_ADDCOMMENT = "INSERT INTO posts (body,posted_by,post_root) VALUES('%1','%2','%3')" ;
	const SQL_REMOVECOMMENT = "UPDATE posts SET 'hidden' = true WHERE id = '%1'" ;
	const SQL_SHOWCOMMENT = "UPDATE posts SET 'hidden' = false WHERE id = '%1'" ;




	const SQL_ADDFRIEND = "INSERT INTO friends (userId,friendId) 
												VALUES('%1','%2')" ;

	const SQL_REMOVEFRIEND = "DELETE FROM friends WHERE WHERE userId = '%1' AND friendId = '%2'" ;


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



	class SocialPostHelper { 
		

		private $sqlHelper ;
		private $connectionOpen ;		
		
		public function __construct($sqlHelper) {

                $this->sqlHelper = $sqlHelper ;
				$this->connectionOpen = false ;
        }

		
		public function connect() {
			$this->sqlHelper->connect() ;
			$this->connectOpen = true ;
			
		}
	
		public function close() {
			$this->sqlHelper->close() ;
			$this->connectOpen = false ;
			
		}
		
		public function getPostCount($from) {

			$this->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETNUMPOSTS,$from)) ;
			$size = $results[0]['number'] ;
			
			$this->close() ;
			
			return $size ;
		} 
		
		public function getPostCountFromFriends($userId) {

			$this->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETPOSTCOUNTFROMFRIENDSANDMYSELF,$userId)) ;
			$size = $results[0]['number'] ;

			$this->close() ;
			
			return $size ;
		} 

		public function getPostsFromFriends($userId,$limit,$page = 0) {

			$this->connect() ;
			$helper = $this->sqlHelper ;
			$query = SQL_GETPOSTSFROMFRIENDSANDMYSELF ;
			$offset = $page * $limit ;
			$query .= " LIMIT $offset,$limit" ;
			$results = $helper->buildQueryResult($helper->buildQueryString($query,$userId)) ;
			$this->close() ;
			
			return $results ;
		} 
		
		public function getActivePosts() {
			$this->connect() ;
			$helper = $this->sqlHelper ;
			
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETALLPOSTS)) ;

			$this->close() ;

			return $results ;
		}
		
		public function getPosts($from) {

			$this->connect() ;
			$helper = $this->sqlHelper ;
			
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETMYPOSTS,$from)) ;

			$this->close() ;
			
			return $results ;
		} 

		public function addPost($message,$from,$to=null,$privacy='public') {
			$this->connect() ;

			$helper = $this->sqlHelper ;
			$filteredMessage = $helper->escapeStringAndRemoveTags($message) ;

			// Ignore empty messages.
			if ($filteredMessage != "") {
				
				if ($to != null) {
					$query = $helper->buildQueryString(SQL_ADDPOST,$filteredMessage,$from,$to,$privacy) ;
				} else {
					$query = $helper->buildQueryString(SQL_ADDPUBLICPOST,$filteredMessage,$from,$privacy) ;
				}
				
				$result = $helper->buildUpdateResult($query) ;
				$this->close() ;
				return $result ;
			}
			
			$this->close() ;
			// flag empty message 
			return false;
		} 
		

		public function getCommentsCount($postId) {

			$this->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETNUMCOMMENTS,$postId)) ;
			$size = $results[0]['number'] ;
			
			$this->close() ;
			
			return $size ;
		} 


		public function getComments($postId) {

			$this->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETCOMMENTS,$postId)) ;

			$this->close() ;
			
			return $results ;
				
		} 
		
		public function addComment($post_id,$message,$userId) {
			$this->connect() ;

			$helper = $this->sqlHelper ;
			$query = $helper->buildQueryString(SQL_ADDCOMMENT,$helper->escapeStringAndRemoveTags($message),$userId,$post_id) ;
			$results = $helper->buildUpdateResult($query) ;

			$this->close() ;
			return $results  ;
		}



		public function addFriend($userId, $friendId) {
			
			$helper = $this->sqlHelper ;
			
			try {
				$this->connect() ;
				$query = $helper->buildQueryString(SQL_ADDFRIEND,$userId,$friendId) ;
				$results = $helper->buildUpdateResult($query) ;
				
			} catch(Exception $e) {
				throw new Exception("Breaking Unique Pair constraint!") ;
			} finally {
				$this->close() ;
			}
		}
	

		public function removeFriend($userId, $friendId) {
			
			$helper = $this->sqlHelper ;
			
			try {
				$this->connect() ;
				$query = $helper->buildQueryString(SQL_ADDFRIEND,$userId,$friendId) ;
				$results = $helper->buildUpdateResult($query) ;
				
			} catch(Exception $e) {
				throw new Exception("Breaking Unique Pair constraint!") ;
			} finally {
				$this->close() ;
			}
		}
	
	
	
		// LIKES AND DISLIKES (CRY and LAUGH emo's are reserved for future use)
	
		public function getLikesCount($userId) {
			$this->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETUSERLIKES,$userId,EMO_TYPE_LIKE)) ;
			$size = $results[0]['number'] ;
			
			$this->close() ;
			
			return 0 ;
		}
		public function revokelikePost($userId,$postId) {

			$this->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(SQL_UPDATE_USERREVOKELIKESPOST,$userId,$postId,EMO_TYPE_LIKE)) ;
			
			$this->close() ;
			
			return $results ;
		} 

		public function likePost($userId,$postId) {

			$this->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(SQL_UPDATE_USERLIKESPOST,$userId,$postId,EMO_TYPE_LIKE)) ;

			$this->close() ;
			
			return $results ;
		} 
		
		public function getLikesOnPost($postId) {

			$this->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_GETLIKESONPOST,$postId,EMO_TYPE_LIKE)) ;
			$this->close() ;
			
			return $results ;
		} 

		public function doesUserLikePost($userId,$postId) {

			$this->connect() ;
			$helper = $this->sqlHelper ;
			
			$results = $helper->buildQueryResult($helper->buildQueryString(SQL_DOESUSERLIKESPOST,$userId,$postId,EMO_TYPE_LIKE)) ;
			$size = $results[0]['number'] ;
			
			$this->close() ;
			
			return $size ;
		} 
		
		// END OF LIKES AND DISLIKES
		
		public function hidePost($post_id) {
			
		}

		public function resetPrivacy($post_id,$privacy) {
			
		}
		
		private function stripTagsAndEscape($message) {
			
			return $message ;
		}

	}
	
	
?>
