<?php
include('includes/header.php') ;
require 'com/fastchat/posts/posts.php' ;
require 'com/fastchat/database/connection.php' ;

use com\fastchat\database\SqlHelper ;
use com\fastchat\posts\SocialPostHelper ;

if (isset($_POST['postText'])) {
	$sqlHelper = new SqlHelper() ;
	$postHelper = new SocialPostHelper($sqlHelper) ;
	$postHelper->addPost($_POST['postText'],$details['id']) ;
}

?>

<div class='wrapper'>

	<div class = 'userDetails column'>
			<a href='<?php echo $userName ; ?>'> <img src='<?php echo $details['avatarasset'] ; ?>'></a>
			<div class='userDetailsPicProfile'>
				<a href="<?php echo $userName ;?>"><?php echo $details['firstname']. " ".$details['surname'] ;?></a>
				<br>Posts:0 
				<br>Likes: 0
				<?php echo isset($_POST['postText']) ? $_POST['postText'] : 'aaa' ; ?>
			</div>
	</div>
	
	<div class='mainBlock column'>
		<form class='post_form' action = 'index.php' method='POST'>
			<textarea name='postText' placeholder='Got something to say?'></textarea>
			<input type='submit' name='postButton'  value='POST!'>
		</form>		
	</div>


</div>

<div class='dropdown'>
  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown link
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>


</body>
</html>