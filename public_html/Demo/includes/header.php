<?php
require 'includes/session.php' ;

if (isset($_SESSION['details'])) {
	
	$details = $_SESSION['details'] ;
	$userDetails = $details['email'] ;
	$userId = $details['id'] ;
	$firstname = $details['firstname'] ;
	$surname = $details['surname'] ;
	$userName=$firstname."_".$surname.$userId ;
	
} else {
	header('Location: register.php') ;
}
?>
<html>
<head>
	<title>TITLE</title>
	
	<!-- Javascript -->

	<script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src = 'js/bootstrap.js'></script>
	<script src = 'js/bootbox.min.js'></script>
	<script src = 'js/commentsupport.js'></script>
	<script src = 'js/ajax_messagehandler.js'></script>
	<script src = 'js/jquery.jcrop.js'></script>
	<script src = 'js/jcrop_bits.js'></script>
	
	
	<!-- CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.Jcrop.css">
	
</head>
<body>
	<div class='top_bar'>
		<div class='logo'>
			<!--
			<a href='index.php'><img src='assets/images/icons/fastchat-icon.png' /></a>
			-->
			<a href='index.php'>FastChat</a>
		</div>
		
		<nav>
			 <!-- this icon's 1) style prefix == fas and 2) icon name == igloo -->
			<a href='#'><?php echo $details['firstname'] ;?></a>
			
			<a href='index.php'><i class="fas fa-home fa-lg"></i></a>
			<a href='#'><i class="fas fa-bell fa-lg"></i></a>
			<a href='#'><i class="fas fa-envelope fa-lg"></i></a>
			<a href='requests.php'><i class="fas fa-users fa-lg"></i></a>
			<a href='#'><i class="fas fa-cog fa-lg"></i></a>
			<a href='logout.php'><i class="fas fa-sign-out-alt fa-lg"></i></a>
			
		</nav>
	</div>