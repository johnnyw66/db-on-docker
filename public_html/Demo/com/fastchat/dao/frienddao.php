<?php
namespace com\fastchat\dao ;
use com\fastchat\database\SqlHelper ;

	
	 
	class FriendDao { 
		
	
		const SQL_GETFRIENDS 			= 	"SELECT 
											u.*,
											CONCAT(CONCAT(CONCAT(u.firstname,'_'),u.surname),u.id) as username,
											a.asset as profileicon 
											FROM friends f 
											JOIN users u on u.id = f.friendId 
											JOIN avatars a on a.id = u.avatarId
											WHERE f.userId = '%1' AND u.active = true";
		
		const SQL_AREFRIENDS 			= 	"SELECT uf.* FROM friends f 
											JOIN users u  ON u.id  = f.userId 
											JOIN users uf ON uf.id = f.friendId 
											WHERE f.userId = '%1' AND f.friendId = '%2' AND uf.active = true AND u.active = true" ;
	
		const SQL_AREFRIENDSUSERNAME 	= 	"SELECT uf.* FROM friends f 
											JOIN users u  ON u.id  = f.userId 
											JOIN users uf ON uf.id = f.friendId 
											WHERE f.userId = '%1' AND CONCAT(CONCAT(CONCAT(uf.firstname,'_'),uf.surname),uf.id) = '%2' AND uf.active = true AND u.active = true" ;

		const SQL_REMOVEFRIEND 			= 	"DELETE FROM friends WHERE userId = '%1' AND friendId = '%2'" ;
		
		const SQL_ADDFRIEND				= 	"INSERT INTO friends (userId,friendId) VALUES ('%1', '%2')" ;
		
		const SQL_ADDFRIENDBYIDANDNAME	= 	"INSERT INTO friends (userId, friendId) 
											SELECT u.id userId ,uf.id friendId FROM users u 
											JOIN users uf ON CONCAT(CONCAT(CONCAT(uf.firstname,'_'),uf.surname),uf.id) = '%2'
											WHERE u.id = '%1'" ;
											
		
		const SQL_ADDFRIENDBYNAMES		= "INSERT INTO friends (userId, friendId) 
											SELECT u.id userId ,uf.id friendId FROM users u 
											JOIN users uf ON CONCAT(CONCAT(CONCAT(uf.firstname,'_'),uf.surname),uf.id) = '%2'
											WHERE CONCAT(CONCAT(CONCAT(u.firstname,'_'),u.surname),u.id) = '%1'" ;
		
		
		const SQL_MUTUALFRIENDS 		= "SELECT friendId FROM friends 
											WHERE userId = '%1' AND friendId <> '%2'  
											AND friendId IN (SELECT friendId FROM friends WHERE userId='%2' AND friendId <> '%1')" ;
								
		const SQL_MUTUALFRIENDSCOUNT 		= "SELECT COUNT(*) as total 
												FROM (SELECT friendId FROM friends WHERE userId = '%1' AND friendId <> '%2'  
												AND friendId 
												IN (SELECT friendId FROM friends WHERE userId='%2' AND friendId <> '%1')) as mutual" ;


		private $sqlHelper ;
		
		public function __construct() {
                $this->sqlHelper = new SqlHelper() ;
        }

		public function getMutualFriends($userId,$profiledUserId) {
			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_MUTUALFRIENDS,$userId,$profiledUserId)) ;
			
			$this->sqlHelper->close() ;
			return $results ;
		}

				
		public function getMutualFriendsCount($userId,$profiledUserId) {
			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_MUTUALFRIENDSCOUNT,$userId,$profiledUserId)) ;
			
			$this->sqlHelper->close() ;
			return $results[0]['total'] ;
		}
		
		public function getFriendsFromUserId($userId) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETFRIENDS,$userId)) ;
			
			$this->sqlHelper->close() ;
			
			return $results ;
		} 
		

		public function isFriendsWithUserName($userId,$userName) {
			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_AREFRIENDSUSERNAME,$userId,$userName)) ;
		
			$this->sqlHelper->close() ;

			return (count($results) == 1) ;
			
		}
		
		public function isFriendsWith($userId,$queryFriendId) {
			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_AREFRIENDS,$userId,$queryFriendId)) ;
		
			$this->sqlHelper->close() ;

			return (count($results) == 1) ;
			
		}
		
		public function makeFriends($userId,$friendId) {
			$this->addFriend($userId,$friendId) ;
			$this->addFriend($friendId,$userId) ;
		}
		
		public function makeFriendsByNames($username,$friendname) {
			$this->addFriendByNames($username,$friendname) ;
			$this->addFriendByNames($friendname,$username) ;
		}
		
		
		public function removeFriends($userId,$friendId) {
			$this->removeFriend($userId,$friendId) ;
			$this->removeFriend($friendId,$userId) ;
		}
		
		public function addFriend($userId,$friendId) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$result = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_ADDFRIEND,$userId,$friendId)) ;
			
			$this->sqlHelper->close() ;
			
			return $result ;
			
		}
		
		public function addFriendByNames($username,$friendUsername) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$query = $helper->buildQueryString(self::SQL_ADDFRIENDBYNAMES,$username,$friendUsername) ;
			echo $query ;
			
			$result = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_ADDFRIENDBYNAMES,$username,$friendUsername)) ;
			
			$this->sqlHelper->close() ;
			
			return $result ;
			
		}
		
		
		public function removeFriend($userId,$friendId) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$result = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_REMOVEFRIEND,$userId,$friendId)) ;
			
			$this->sqlHelper->close() ;
			
			return $result ;
			
		}
		

	}
	
	
?>
