<?php
include('includes/builders.php') ;
require 'com/fastchat/database/connection.php' ;
require 'com/fastchat/dao/likedao.php' ;
require 'com/fastchat/locale/locale.php' ;

use com\fastchat\locale\Locale ;
use com\fastchat\dao\LikeDao ;

const REQUEST_REVOKELIKE	=	'REVOKE_LIKE' ;
const REQUEST_LIKE 			=	'LIKE' ;

session_start() ;

if (!isset($_SESSION['details'])) {

	header('Location: register.php') ;

} else {

	$details = $_SESSION['details'] ;
	$userId = $details['id'] ;

	$locale = new Locale() ;
	$likeDao = new LikeDao() ;
	
}

?>
<html>
<header>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	
</header>

<body>
	<style type='text/css'>
		body {
			background-color: #fff;
		}
		form {
			padding:2px;
			position:absolute;
			top:0;
		}
	
	</style>
	<?php
	
		if (!isset($_GET['post_id'])) {
			header('Location: register.php') ;
		}
		 
		$postId = $_GET['post_id'] ;
		
		if (isset($_POST[COMMAND_LIKE])) {

			$request = $_POST[COMMAND_LIKE] ;
			
			if ($request == REQUEST_REVOKELIKE) {
				
				$res = $likeDao->revokelikePost($userId,$postId) ;
					
			} else if ($request == REQUEST_LIKE) {

				$res = $likeDao->likePost($userId,$postId) ;
			}
		} 
		
		$activeUsersWhoLiked = $likeDao->getLikesOnPost($postId) ;
		$numberOfUsersLikingPost = count($activeUsersWhoLiked) ;
		$liked = $likeDao->doesUserLikePost($userId,$postId) ;

		//echo buildLikesPopup($postId,$demoLikesList) ;
				
		if ($liked == 0) {
			echo buildLikeFormButton($postId,REQUEST_LIKE, $locale->text('LIKE'), $numberOfUsersLikingPost) ;
		} else {
			echo buildLikeFormButton($postId, REQUEST_REVOKELIKE, $locale->text('REVOKE LIKE'), $numberOfUsersLikingPost) ;
		}

?>	

</body>
</html>