<?php
include('builders.php') ;

require '../com/fastchat/dao/postdao.php' ;
require '../com/fastchat/database/connection.php' ;

use com\fastchat\dao\PostDao ;

	session_start() ;
	$strictjson = false ;
	
	if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
	    throw new Exception('Request method must be POST!');
 	} 

	$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
	if($strictjson && strcasecmp($contentType, 'application/json') != 0){
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
		
		$postId = $decoded['postid'] ;
		$userId = $details['id'] ;
		
		$postDao = new PostDao() ;
		$sqlresult = $postDao->deletePostFromUserId($postId,$userId) ;
		
		$result =  json_encode(
			array(
				'result' => 'OK',
				'status' => 400,
				'postid' => $postId,
				'userid' => $userId,
				'sqlresult' => 0
			) 
		) ;
		echo $result ;
		
	} else {
		
		$result = json_encode(
		 array (
				'result' => 'ERROR NO SESSION',
				'status' => 404	
			)
		) ;
		echo $result ;
	}

	
?>

