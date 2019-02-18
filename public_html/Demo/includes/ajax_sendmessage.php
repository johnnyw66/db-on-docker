<?php
include('builders.php') ;

require '../com/fastchat/dao/postdao.php' ;
require '../com/fastchat/database/connection.php' ;

use com\fastchat\dao\PostDao ;

	session_start() ;
	
	if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
	    throw new Exception('Request method must be POST!');
 	} 

	$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
	if(strcasecmp($contentType, 'application/json') != 0){
	    throw new Exception('Content type must be: application/json');
	}
	
	$content = trim(file_get_contents("php://input"));
	
	//Attempt to decode the incoming RAW post data from JSON.
	$decoded = json_decode($content, true);

	//If json_decode failed, the JSON is invalid.
	if(!is_array($decoded)){
	    throw new Exception('Received content contained invalid JSON!');
	}
	
		
	if (isset($_SESSION['details'])) {

		$details = $_SESSION['details'] ;
		
		$message = $decoded['message'] ;
		$fromUsername = $decoded['from'] ;
		$toUsername = $decoded['to'] ;
		

		$postDao = new PostDao() ;
		$result = $postDao->postMessageFromUserNameToUsername($message,$fromUsername,$toUsername) ;
		
		$result =  json_encode(
			array(
				'result' => 'OK',
				'no' => 400,
				'from' =>$decoded['from'],
				'to' =>$decoded['to'],
				'message' =>$decoded['message']
			) 
		) ;
		echo $result ;
		
	} else {
		
		$result = json_encode(
		 array (
				'result' => 'ERROR NO SESSION',
				'no' => 404	
			)
		) ;
		echo $result ;
	}

	
?>

