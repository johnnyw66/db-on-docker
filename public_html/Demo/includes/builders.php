<?php

const COMMAND_LIKE 	=	'commandLike' ;

	function buildEstimateCreationTime($creationTime) {
		$format = "Y-m-d H:i:s" ;
		$creation =  DateTime::createFromFormat($format,$creationTime) ;
		$now = DateTime::createFromFormat($format,gmdate($format)) ;
		$interval = $creation->diff($now) ;
	
		if ($interval->y >= 1) {
			return $interval->y.' year'.(($interval->y == 1) ? '' : 's').' ago' ;
		} else if ($interval->m >= 1) {
			return $interval->m.' month'.(($interval->m == 1) ? '' : 's').' ago' ;
		} else if ($interval->d >= 1) {
			return $interval->d.' day'.(($interval->d == 1) ? '' : 's').' ago' ;
		} else if ($interval->h >= 1) {
			return $interval->h.' hour'.(($interval->h == 1) ? '' : 's').' ago' ;
		} else if ($interval->i >= 1) {
			return $interval->i.' min'.(($interval->i == 1) ? '' : 's').' ago' ;
		} else {
			return "Just now" ;
		}
	}

	function buildCommentEntry($post) {

		$asset = $post['asset'] ;
		$userFirstname = $post['firstname'] ;
		$userSurname = $post['surname'] ;
		$body = $post['body'] ;
		$created = $post['created'] ;
		$ect = buildEstimateCreationTime($created) ;
		$added_by = $userFirstname."_".$userSurname.$post['posted_by'] ;
		$user_to = isset($post['posted_to']) ? $post['posted_to'] : 'NulL' ;
		$postId = $post['id'] ;
		
		$commentEntry = "<div class = 'comment_post'> 

						<div class = 'post_profile_pic'>
							<img src = '$asset' width = '16' height = '16'>
						</div>
						
						<div class = 'posted_by' style = 'color:#acacac ;'>
							<a href ='$added_by' target='_parent'>  postid:$postId $userFirstname $userSurname </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$ect
						</div>
						
						<div id = 'post_body'>
							$body<br>
						</div>
				</div><hr>" ;

		return $commentEntry ;
	}
	
	
	
	function buildDeletePostButton($postId) {
		
		return "<div id='postdelete_div' onClick = 'javascript:deletePost($postId)'><button type='button' class='delete-post-button' id='delete-post' data-postid='$postId'>X</button></div>" ;
		
	}
	
	function buildPostEntry($ownerId,$post,$numberOfComments=0) {
	
		$asset = $post['asset'] ;
		$userFirstname = $post['firstname'] ;
		$userSurname = $post['surname'] ;
		
		$postedById = $post['posted_by'] ; 
		
		
		
		$body = $post['body'] ;
		$created = $post['created'] ;
		$ect = buildEstimateCreationTime($created) ;
		
		$added_by = $userFirstname."_".$userSurname.$post['posted_by'] ;
		$user_to = isset($post['posted_to']) ? $post['posted_to'] : 'NulL' ;
		$postId = $post['id'] ;
		
		if ($ownerId == $postedById) {
			$deleteOption = buildDeletePostButton($postId);
		} else {
			$deleteOption = "" ;
		}
		
//		$postEntry = "<div class = 'status_post'> 

		$postEntry = "<div class = 'status_post' onClick = 'javascript:togglePostComment($postId)'> 
		
						<div class = 'post_profile_pic'>
							<img src='$asset' width='50'>
						</div>

						<div class = 'posted_by' style = 'color:#acacac ;'>
							<a href='$added_by'>  postid:$postId $userFirstname $userSurname </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$ect $deleteOption
						</div>
						
						
						
						<div id = 'post_body'>
							$body<br>
						</div>
				    </div>

					<div class = 'comment_like_options'>
						Comments($numberOfComments)&nbsp;&nbsp;&nbsp;&nbsp;
						<iframe src='likes.php?post_id=$postId' scrolling='no'></iframe>
					</div>


					<div class = 'post_comment' id = '$postId' style = 'display:none;'>
						<iframe src = 'comments.php?post_id=$postId' frameborder='0' id='comment_frame'></iframe>
					</div>
				
				<hr>" ;
				
		return $postEntry ;
	}

	function buildTotalPosts($totalPosts,$limit) {
		$maxPages = ceil($totalPosts / $limit) ;
		return "<div class ='total_posts' totalPosts = '$totalPosts' maxPages = '$maxPages'></div>" ;
	}

	function buildLikeFormButton($postId,$commandValue,$buttonText,$totallikes) {
		
		return "<form action='likes.php?post_id=$postId' method='POST' scrolling=none>
					<input type='submit' class='likebutton' name='likebutton' value='$buttonText' title='Click'>
					<input type='hidden' name='".COMMAND_LIKE."' value='$commandValue'>
					<div class='totallikes'>$totallikes</div>
				</form>" ;
	}
	
	function buildLikesPopup($postId,$likers) {
		return "<div class='likespopup'><span class='popuptext' id='$postId'>Popup text...$likers</span></div>" ;
	}
	
	function buildFriendsButton($userId,$profileUserId,$friendAction,$buttonLabel='BUTTONLABEL') {
		return "<form action='$profileUserId' method='POST'><input type='submit' id = '$userId' class='friendButton$friendAction' value = '$buttonLabel'><input type='hidden' name='friendAction' value='$friendAction'></form>" ;
	}

	// Build a list with Accept/Ignore buttons
	
	function buildComplexFriendLinks($requests,$class,$limit) {

		echo("<div class='$class'>") ;
		foreach(explode(',',$requests) as $index=>$requesteeName) {
			echo "\t<div class='$class"."_form'>\n" ;
			echo "\t\t<a href = '$requesteeName'>$requesteeName</a>\n" ;
			?>
			<form action='requests.php' method='POST'>
				<input type='submit' name='ACCEPT'  value='ACCEPT'>
				<input type='submit' name='IGNORE'  value='IGNORE'>
				<input type='hidden' name='requestee' value='<?php echo $requesteeName ; ?>'>
			</form>
			<?php
			
			echo("</div>") ;
			
		}
		echo("</div>") ;
	}


	function buildLimitedFriendLinks($requests,$class,$limit) {

		echo("<div class='$class'>") ;
		foreach(explode(',',$requests) as $index=>$friend) {
			echo buildFriendHyperLink($friend) ;
		}
		echo("</div>") ;
	}

	function buildHyperLink($text,$link,$class='hyper') {
		return "<div class='$class'><p><a href='$link'>$text</a></p></div>" ;
	}

	function buildFriendHyperLink($friendname) {
		return  buildHyperLink($friendname,$friendname);
	}

	
	

	function buildParagraph($text) {
		return "<p>".$text."</p>" ;
	}
	
?>
