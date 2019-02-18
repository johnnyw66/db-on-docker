<?php
require 'com/fastchat/forms/formsupport.php' ;
require 'com/fastchat/database/connection.php' ;
require 'com/fastchat/dao/userdao.php' ;

use com\fastchat\dao\UserDao ;

session_start() ;  // start a session to store vars (used when email id already exists).

$userDao = new UserDao() ;


if (isset($_POST[REG_BUTTON])) {
	// We've entered here after submitting using the 'Register' button

	$reg_fname = $_POST[REG_FNAME] ;
	$reg_lname = $_POST[REG_LNAME] ;
	$reg_email = $_POST[REG_EMAIL] ;
	$reg_password = $_POST[REG_PASSWORD] ;
	
	setSessionVar(REG_FNAME,$reg_fname) ;			
	setSessionVar(REG_LNAME,$reg_lname) ;		
	setSessionVar(REG_EMAIL,$reg_email) ;		
	
	

	$checkEmail = $userDao->getUserFromEmails($reg_email) ;
	
	if (count($checkEmail) == 0) {

		$res = $userDao->addUser($reg_fname,$reg_lname,$reg_email,$reg_password) ;
		
		if ($res) {
			// We've just managed to register a user - clear all session vars and offer loginForm - (with email filled in)
			emptySessionVars() ;
			
			// Fill login fields
			setSessionVar(LOGIN_EMAIL, $reg_email) ;
			setSessionVar(LOGIN_FORM_MESSAGE, buildSpanMessage('Registration complete! Please login with your password',"#00C800")) ;
			
		} else {
			setSessionVar(REG_FORM_MESSAGE, buildSpanMessage('*** SOMETHING WENT WRONG: SERVER ERROR ***','#C80000')) ;
		}
	} else {
		setSessionVar(REG_FORM_MESSAGE, buildSpanMessage('*** Email Already Exists! ***','#C80000'));
	}
	

	
}	else if (isset($_POST[LOGIN_BUTTON])) {
	
	$login_email = $_POST[LOGIN_EMAIL] ;
	$login_password = $_POST[LOGIN_PASSWORD] ;
	setSessionVar(LOGIN_EMAIL, $login_email) ;		
	
	$userDetails = $userDao->getUserFromCredentials($login_email,$login_password) ;
	

	if (count($userDetails) == 1) {

		emptySessionVars() ;
		$details = $userDetails[0] ;
		setSessionVar('details', $details) ;
		setSessionVar('username', $details['firstname'].'_'.$details['surname'].$details['id']) ;
		setSessionVar('avatarasset', $details['avatarasset']) ;
		setSessionVar(LOGIN_FORM_MESSAGE,'') ;
		header("Location: index.php") ;

	} else {
		setSessionVar(LOGIN_FORM_MESSAGE,buildSpanMessage('*** Invalid Password and/or Email! ***','#C80000')) ;
	}

} else {
	// spurious POST
}
	
?>
