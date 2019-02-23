<?php
namespace com\fastchat\database ;

use mysqli ;
use Redis ;
	interface CachingManagerInf {
		static public function create() ;
		public function get($key,$fn) ;
		public function flushAll() ;
		public function flushClass($keyClass) ;
		public function flush($key) ;
	}
	

	class SimpleCachingManager implements CachingManagerInf {
	
		private static $instance ;
		private $hashTable ;
		private $cacheon ;
		
		private function __construct() {
		}
		
		static public function create() {
			if (!self::$instance) {
                          self::$instance = new SimpleCachingManager();
			} else {
				var_dump("Reference Singleton") ;
				
			}
           return self::$instance;
		}
		
		public function flushAll() {
		}
		public function flushClass($keyClass) {
			
		}
		
		public function flush($key) {
		}
		

		public function get($key,$fn) {

		   $redis = new Redis() ; 
		   $client = $redis->connect('redis', 6379) ; 		
		   if (!$redis->exists($key)) {
				$result = $fn($key) ;
				
				$redis->set($key,serialize($result)) ;
				return $result ;
		   }
		   return  unserialize($redis->get($key)) ;

		}

	}
	// Simple MySQL Helper - no pooling of connections..
	class SqlHelper { 
		const SQLSERVER                                     =       "mysql" ;
		const SQLUSER                                       =       "socialuser" ;
		const SQLPASSWORD                            		=   	"secret" ;
		const SQLSCHEMA                                     =       "social" ;
		
		private $mysqlSchema ;
		private $mysqlHost  ;
		private $mysqlUser ;
		private $mysqlPassword ;
		private $mysqli ;

	 	private $cachingManager ;						//
		
				
		public function __construct($host=null,$user=null,$password=null,$schema=null) {
                global $SQLSERVER,$SQLUSER,$SQLPASSWORD,$SQLSCHEMA ;

                $this->mysqlHost = ($host != null) ? $host : self::SQLSERVER;
                $this->mysqlUser = ($user != null) ? $user : self::SQLUSER ;
                $this->mysqlPassword = ($password != null) ? $password : self::SQLPASSWORD;
                $this->mysqlSchema = ($schema != null) ? $schema : self::SQLSCHEMA;
				$this->cachingManager = SimpleCachingManager::create() ;
				
				mysqli_report(MYSQLI_REPORT_STRICT);
        }

		// Helper function to remove HMTL tags, escape strings and trim white-space.
		
		public function escapeStringAndRemoveTags($str) {
				return trim($this->mysqli->escape_string(strip_tags($str))) ;
		}
		
        // Simple Build up Query String with multiple arguments 
        // buildQueryString("SELECT * FROM Table Where Date = '%1'","2010-10-10")
        // Supports up to 9 arguments 

        public function buildQueryString() {
                $argArray = array('%1','%2','%3','%4','%5','%6','%7','%8','%9') ;
                $numargs = func_num_args();
                $repArray = func_get_args();
                $string = array_shift($repArray) ;
                $result = str_replace($argArray,$repArray,$string) ;
                return $result ;
        }
        

		// 
        public function buildQueryResult($query) {

			return ($this->cachingManager->get($query,function($query){
                $res = array() ;
                $result = $this->mysqli->query($query);
                if ($result) {
                        while ($row = $result->fetch_assoc()) {
                                array_push($res,$row) ;
                        }
                }
                return $res ;
			})) ;	
        }

        public function buildUpdateResult($query) {
                $result = $this->mysqli->query($query);
                return $result ;
        }
        
		public function close() {
                $this->mysqli->close();
        }       

		public function connect() 
        {	
					try {
		                $this->mysqli = new mysqli($this->mysqlHost, 
												$this->mysqlUser, 
												$this->mysqlPassword,
												$this->mysqlSchema) ;
					} catch (Exception $e) {
						throw new Exception("???".$e->getMessage()) ;
					}
					
        }

	}
	
	
?>
