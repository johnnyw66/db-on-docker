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

if (isset($_GET['profile_username'])) {
	
	$username = $_GET['profile_username'] ;

	$locale	 = new Locale() ;
	$userDao = new UserDao() ;
	$friendDao = new FriendDao() ;
	$likeDao = new LikeDao() ;
	$postDao = new PostDao() ;
	$requestDao = new RequestDao() ;

	$profileUser = $userDao->getUserFromUsername($username) ;

	$profilePicture = $profileUser['profileicon'] ;
	$profileUsername =$profileUser['username'] ;
	$profileEmail=$profileUser['email'] ;
	
	$profileUserId = $profileUser['id'] ;
	$profileAccountClosed= ($profileUser['active'] == '0');

	if(isset($_POST['friendAction'])) {
		
		$action = $_POST['friendAction'] ;

		switch ($action) {
	
			case 'REMOVE':
				$friendDao->removeFriends($userId,$profileUserId) ;
				break ;
	
			case 'ACCEPT':
				$friendDao->makeFriends($userId,$profileUserId) ;
				$requestDao->removeRequest($profileUserId,$userId) ;				
				break ;
	
			case 'IGNORE':
				$requestDao->removeRequest($profileUserId,$userId) ;				
				break ;
				
			case 'ABORT':
				$requestDao->removeRequest($userId,$profileUserId) ;				
				break ;
		
			case 'REQUEST':
				$requestDao->addRequest($userId,$profileUserId) ;
				break ;
				
			default:
				break ;
			
		} 
	}
	
	$friends = $friendDao->getFriendsFromUserId($profileUserId) ;
	$likesCount = $likeDao->getLikesCountFromUserId($profileUserId) ;
	$postsCount = $postDao->getPostsCountFromUserId($profileUserId) ;
	$myFriend = $friendDao->isFriendsWith($userId,$profileUserId) ;
	$friendsWithMe = $friendDao->isFriendsWith($profileUserId,$userId) ;
	$friendsWithMe = $friendDao->isFriendsWithUserName($userId,$profileUsername) ;
	$mutualFriendsCount = ($userId == $profileUserId) ? 0 : $friendDao->getMutualFriendsCount($userId,$profileUserId) ; // mutual friends count will return 'friends count' if user and profile are the same
	
	$requestsFromProfiledUser = $requestDao->requestExists($profileUserId,$userId) ;
	$requestsToProfileUser = $requestDao->requestExists($userId,$profileUserId) ;

} else {
	header('Location: index.php') ;
}

?>

<div class='wrapper'>

	<style = 'text/css'>
		.wrapper {
			margin-left: 0px;
			padding-left: 0px;
		}
	</style>
	
	<div class='profile_left'>
		<img src='<?php echo $profilePicture ;?>'>
		
		<div class='profile_info'>
			
			<?php
				if ($profileAccountClosed) {
					header('Location: account_closed.php');
				}

				echo buildHyperLink("User: ".$profileUsername,$profileUsername) ;
				echo buildParagraph("Email: ".$profileEmail) ;
				echo buildParagraph("Friends: ".count($friends)) ;
				echo buildParagraph("Mutual Friends: ".$mutualFriendsCount) ;
				
				echo buildParagraph("Posts: $postsCount") ;
				echo buildParagraph("Likes: ".$likesCount) ;
				
				if ($profileUserId != $userId) {
					if ($friendsWithMe) {
						// Already friends - offer remove
						echo buildFriendsButton($userId,$profileUsername,'REMOVE',$locale->text('REMOVE')) ;

					} else if ($requestDao->requestExists($profileUserId,$userId)) {
						// There's a request from the profiled user -
						echo buildFriendsButton($userId,$profileUsername,'ACCEPT',$locale->text('ACCEPT')) ;
						echo buildFriendsButton($userId,$profileUsername,'IGNORE',$locale->text('IGNORE')) ;
							
					} else if ($requestDao->requestExists($userId,$profileUserId)) {
						// The current user has already sent a request to this user - ABORT REQUEST
						echo buildFriendsButton($userId,$profileUsername,'ABORT',$locale->text('ABORT')) ;	
					} else {
						// 
						//echo "REQUEST!!!" ;
						echo buildFriendsButton($userId,$profileUsername,'REQUEST',$locale->text('REQUEST')) ;	
					}
					
				} else {
					// Build up a list of Requestors and display their usernames.
					$requests = $requestDao->getFriendRequestsCSV($profileUserId) ;
					echo buildLimitedFriendLinks($requests,'friendrequestlist',10) ;
				}
			
			?>

		</div>
	</div>
	
	<div class='mainBlock column'>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendMessageModal" data-from-username='<?php echo $userName ; ?>' data-to-username='<?php echo $profileUsername ;?>'>Send Message</button>

		Hello From Profile Page!
		<?php echo $profileUsername ; ?>
		<?php  echo "FRIENDS---->"; var_dump($friends) ; ?>
		<?php echo "<BR>UserId $userId is PEEKING  at $profileUserId<BR>"; ?>
		<?php
		?>
	</div>

	<div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="messageModalLabel">New message</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
	          <div class="form-group">
	            <label for="recipient-name" class="col-form-label">Recipient:</label>
	            <input type="text" class="form-control" id="recipient-name">
	          </div>
	          <div class="form-group">
	            <label for="message-text" class="col-form-label">Message:</label>
	            <textarea class="form-control" id="message-text"></textarea>
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal" id='close' >Close</button>
	        <button type="button" class="btn btn-primary" data-dismiss="modal" id='sendmessagebutton'>Send message</button>
	      </div>
	    </div>
	  </div>
	</div>


	
</div>
</body>
</html>