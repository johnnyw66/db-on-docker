<?php
namespace com\fastchat\dao ;
use com\fastchat\database\SqlHelper ;

	
	 
	class RequestDao { 
		
		const SQL_GETREQUESTS =	"SELECT CONCAT(CONCAT(CONCAT(u.firstname,'_'),u.surname),u.id) requestors 
								FROM  requests r 
								JOIN users u ON r.requestorId = u.id 
								WHERE r.requesteeId ='%1'" ;
		
		const SQL_GETGROUPREQUESTS =	"SELECT GROUP_CONCAT(CONCAT(CONCAT(CONCAT(u.firstname,'_'),u.surname),u.id)) requestors 
								FROM  requests r 
								JOIN users u ON r.requestorId = u.id 
								WHERE r.requesteeId ='%1'" ;

		const SQL_FINDREQUEST =	"SELECT COUNT(*) as number FROM  requests WHERE requestorId = '%1' AND requesteeId ='%2'" ;
		const SQL_REMOVEREQUEST =	"DELETE FROM  requests WHERE requestorId = '%1' AND requesteeId ='%2'" ;

		const SQL_REMOVEREQUESTBYNAME =	"DELETE FROM requests WHERE id IN 
											(SELECT id FROM (SELECT r.id id FROM requests r 
											JOIN users u ON u.id = r.requestorId 
											WHERE r.requesteeId = '%1' AND  CONCAT(CONCAT(CONCAT(u.firstname,'_'),u.surname),u.id) ='%2') x) " ;
		
		const SQL_ADDREQUEST =	"INSERT INTO  requests (requestorId, requesteeId) VALUES ('%1', '%2')" ;

		private $sqlHelper ;
		
		public function __construct() {

                $this->sqlHelper = new SqlHelper() ;
        }
		
		// Given for a particular user.id - Returns a Friend Request as list as a string of comma separated values
		 
		public function getFriendRequestsCSV($requesteeId) {
			
			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETGROUPREQUESTS,$requesteeId)) ;
			$this->sqlHelper->close() ;
			return isset($results[0]['requestors']) ? $results[0]['requestors'] : "";
		}

		public function getFriendRequests($requesteeId) {
			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_GETREQUESTS,$requesteeId)) ;
			$this->sqlHelper->close() ;
			return $results[0] ;
		}
		
		public function requestExists($requestorId,$requesteeId) {
			
			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildQueryResult($helper->buildQueryString(self::SQL_FINDREQUEST,$requestorId,$requesteeId)) ;
			
			$this->sqlHelper->close() ;
			
			return ($results[0]['number'] == 1);
			
		}	
		
		public function addRequest($requestorId,$requesteeId) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_ADDREQUEST,$requestorId,$requesteeId)) ;
			$this->sqlHelper->close() ;
			return $results ;
		} 


		public function removeRequest($requestorId,$requesteeId) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_REMOVEREQUEST,$requestorId,$requesteeId)) ;
			$this->sqlHelper->close() ;
			return $results ;
		} 


		public function removeRequestByIdAndUsername($requestorId,$requesteeUsername) {

			$this->sqlHelper->connect() ;
			$helper = $this->sqlHelper ;
			//$query = $helper->buildQueryString(self::SQL_REMOVEREQUESTBYNAME,$requestorId,$requesteeUsername) ;
			//echo "$query" ;
			$results = $helper->buildUpdateResult($helper->buildQueryString(self::SQL_REMOVEREQUESTBYNAME,$requestorId,$requesteeUsername)) ;
			$this->sqlHelper->close() ;
			return $results ;
		} 

		

	}
	
	
?>
