<?php
include('builders.php') ;

require '../com/fastchat/database/connection.php' ;
require '../com/fastchat/dao/commentdao.php' ;
require '../com/fastchat/dao/postdao.php' ;

use com\fastchat\dao\CommentDao ;
use com\fastchat\dao\PostDao ;

	session_start() ;
	
	$details = $_SESSION['details'] ;

	$commentDao = new CommentDao() ;
	$postDao = new PostDao() ;
	
	$pageNumber = isset($_REQUEST['page']) ?  $_REQUEST['page'] : 0;
	$limit = isset($_REQUEST['limit'])  ?  $_REQUEST['limit'] : 10;

	$userId = $details['id'];

	if (!isset($details['totalposts'])) {
		$details['totalposts'] = $postDao->getPostCountFromFriends($userId);
		echo buildTotalPosts($details['totalposts'], $limit) ;
	}
	
	$totalPosts = $details['totalposts'] ;
	$maxPages = ceil($totalPosts / $limit) ;

	if ($pageNumber < $maxPages ) {
		$posts = $postDao->getPostsFromFriends($userId,$limit,$pageNumber) ;				
		//echo "COUNT $count MAXPAGES $maxPages<BR>" ;
		foreach($posts as $post) {
			$number = $commentDao->getCommentsCount($post['id']) ;
			echo buildPostEntry($userId,$post,$number) ;
		}	
	} 

	
?>

