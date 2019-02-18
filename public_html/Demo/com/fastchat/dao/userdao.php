<?php
namespace com\fastchat\dao ;
use com\fastchat\database\SqlHelper ;

	
	 
	class UserDao { 
	
	//	$checkEmail = $sqlHelper->buildQueryResult("SELECT * FROM users WHERE email = '$reg_email'") ;
	//$query = $sqlHelper->buildQueryString("INSERT into users (firstname,surname,email,password) VALUES ('%1','%2','%3',SHA2('%4', 224))",
	//$query = "SELECT u.id, u.firstname, u.surname, u.email, a.asset as avatarasset FROM users u JOIN avatars a on a.id = u.avatarId  WHERE email = '$login_email' and password = SHA2('$login_password',224)" ;
	
		const SQL_GETUSERFROMUSERNAME 		= "SELECT u.*,
												CONCAT(CONCAT(CONCAT(u.firstname,'_'),u.surname),u.id) as username,
												a.asset as profileicon 
												FROM users u 
												JOIN avatars a on a.id = u.avatarId 
												WHERE CONCAT(CONCAT(CONCAT(u.firstname,'_'),u.surname),u.id) = '%1'" ;
		

		const SQL_CHECKEMAILS				=	"SELECT * FROM users WHERE email = '%1'" ;
		
		
		const SQL_ADDUSER					=	"INSERT into users (firstname,surname,email,password) VALUES ('%1','%2','%3',SHA2(CONCAT('%3','%4'), 224))" ;

		const SQL_GETFROMCREDENTIALS		=	"SELECT u.id, u.firstname, u.surname, u.email, a.asset as avatarasset 
													FROM users u JOIN avatars a on a.id = u.avatarId  
												WHERE email = '%1' and password = SHA2(CONCAT('%1','%2'),224)" ;
		
		
		private $sqlHelper ;
		
		public function __construct() {

                $this->sqlHelper = new SqlHelper() ;
        }


		public function addUser($firstname,$surname,$email,$password) {
			$this->sqlHelper->connect() ;

			$helper = $this->sqlHelper ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_ADDUSER,$firstname,$surname,$email,$password)) ;
			
			$this->sqlHelper->close() ;
			
			return $results ;
			
		}

		public function getUserFromEmails($email) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_CHECKEMAILS,$email)) ;
			
			$this->sqlHelper->close() ;
			
			return $results ;
		} 

		public function getUserFromCredentials($email,$password) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETFROMCREDENTIALS,$email,$password)) ;
			
			$this->sqlHelper->close() ;
			
			return $results ;
		} 
		
		
		public function getUserFromUsername($username) {

			$this->sqlHelper->connect() ;
			
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETUSERFROMUSERNAME,$username)) ;
			
			$this->sqlHelper->close() ;
			
			return $results[0] ;
		} 

	}
	
	
?>
