<?php
include('includes/builders.php') ;
require 'com/fastchat/database/connection.php' ;
require 'com/fastchat/dao/commentdao.php' ;
use com\fastchat\dao\CommentDao ;

session_start() ;

if (!isset($_SESSION['details'])) {

	header('Location: register.php') ;

} else {

	$details = $_SESSION['details'] ;
	$userId = $details['id'] ;	
	$commentDao = new CommentDao() ;
	
}

?>
<html>
<header>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</header>

<script>
	
	function validateText(text) {
		return text.replace(/(<([^>]+)>)/ig,"").trim() ;
		
	}
	
	function validateComment(commentForm) {
		try {
				replacement = validateText(commentForm.comment_body.value) ;
				commentForm.comment_body.value =  replacement;
				if (replacement.length == 0) {
					return false ;
				}
		} catch(e) {
				alert(e);
				return false ;
		}
		return true ;
	}
</script>

<body>
	
	<?php
		if (isset($_GET['post_id'])) {
			$post_id = $_GET['post_id'] ;
		}
		if (isset($_POST['comment_body'])) {
			$comment = $_POST['comment_body'] ;
			if (isset($_GET['post_id'])) {
				$post_id = $_GET['post_id'] ;
				$result = $commentDao->addComment($post_id,$comment,$userId) ;

				echo "<p>Comment $comment $post_id (by user $userId) Posted!</p>" ;
			}
		} else {
			// no posting done.
		}
	?>
	
	
	<form name='commentForm' action='comments.php?post_id=<?php echo $post_id ;?>' id='comment_form' onsubmit='return validateComment(commentForm);' METHOD='POST'>
		<textarea name='comment_body'></textarea>
		<input type='submit' name='postComment' value='POST'>
	</form>

	<?php
		$comments = $commentDao->getComments($post_id) ;

		foreach($comments as $comment) {
			echo buildCommentEntry($comment) ;
		}	
	?>

</body>
</html>