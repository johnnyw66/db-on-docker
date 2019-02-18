<?php
include('includes/header.php') ;
include('includes/builders.php') ;

require 'com/fastchat/database/connection.php' ;
require 'com/fastchat/dao/likedao.php' ;
require 'com/fastchat/dao/postdao.php' ;

use com\fastchat\dao\LikeDao ;
use com\fastchat\dao\PostDao ;

$likeDao = new LikeDao() ;
$postDao = new PostDao() ;


if (isset($_POST['postText'])) {
	$postResult = $postDao->addPost($_POST['postText'],$userId) ;
}

?>

<div class='wrapper'>

	<div class = 'userDetails column'>
			<a href='<?php echo $userName ; ?>'> <img src='<?php echo $details['avatarasset'] ; ?>'></a>
			<div class='userDetailsPicProfile'>
				<a href="<?php echo $userName ;?>"><?php echo $details['firstname']. " ".$details['surname'] ;?></a>
				<br>Posts: <?php echo $postDao->getPostCount($userId) ; ?>
				<br>Likes: <?php echo $likeDao->getLikesCountFromUserId($userId) ; ?>
			</div>
	</div>

	
	<div class='mainBlock column'>
		<form class='post_form' action = 'index.php' method='POST'>
			<textarea name='postText' placeholder='Got something to say?'></textarea>
			<input type='submit' name='postButton'  value='POST'>
		</form>		
	</div>

	<div class='lastPost column'>
		<!--
		<button type='button' class='delete-post-button' id='delete-post' data-postid='22'>X</button> 
		-->
		
	</div>

	<div class='debug_area' style='top: 0;'>DEBUG TEXT</div>

	<div class='posts_area column' page='0'></div>

	<div class='bottom_area column'>
		<div class='busy_icon'>
			<img id = 'loading' src='assets/images/icons/loading.gif' width='64' height='64'>
		</div>
	</div>

	
	<script src = 'js/ajax_support.js'></script>
	
<?php
	include('includes/footer.php') ;
?>		
		
</div>


</body>
</html>