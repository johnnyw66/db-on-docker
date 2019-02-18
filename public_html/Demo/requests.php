<?php
include('includes/header.php') ;
include('includes/builders.php') ;
require 'com/fastchat/database/connection.php' ;
require 'com/fastchat/dao/userdao.php' ;
require 'com/fastchat/dao/frienddao.php' ;
require 'com/fastchat/dao/likedao.php' ;
require 'com/fastchat/dao/postdao.php' ;
require 'com/fastchat/dao/requestdao.php' ;
require 'com/fastchat/locale/locale.php' ;
use com\fastchat\locale\Locale ;

use com\fastchat\dao\UserDao ;
use com\fastchat\dao\FriendDao ;
use com\fastchat\dao\LikeDao ;
use com\fastchat\dao\PostDao ;
use com\fastchat\dao\RequestDao ;

$locale	 = new Locale() ;
$userDao = new UserDao() ;
$friendDao = new FriendDao() ;
$likeDao = new LikeDao() ;
$postDao = new PostDao() ;
$requestDao = new RequestDao() ;

?>


<div class='main_column column' id='main_column'>
	<h4>Friend Requests</h4>
<?php
		
		$requests = $requestDao->getFriendRequestsCSV($userId) ;
		if ($requests == '') {
			echo buildParagraph("You have no friend requests at this time") ;
		} else {
			echo buildComplexFriendLinks($requests,'request_friends_main',20) ;	
		}
		
		if (isset($_POST['ACCEPT'])) {
			// retrieve username of accepted friend
			$requesteeUsername = $_POST['requestee'] ;
			echo "ACCEPT requesteeUsername  = $requesteeUsername loggedIn username $userName" ;
			
			$friendDao->makeFriendsByNames($userName,$requesteeUsername) ;
			$requestDao->removeRequestByIdAndUsername($userId,$requesteeUsername) ;
		} else 
		if (isset($_POST['IGNORE'])) {
			// retrieve username of rejected friend
			$requesteeUsername = $_POST['requestee'] ;
			$requestDao->removeRequestByIdAndUsername($userId,$requesteeUsername) ;
		} else {
			//var_dump($_SERVER) ;
		}
		
?>
	
</div>
</body>
</html>