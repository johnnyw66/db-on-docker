<?php

define('REG_FNAME','reg_fname') ;
define('REG_LNAME','reg_lname') ;
define('REG_EMAIL','reg_email') ;
define('REG_EMAILCONFIRM','reg_emailconfirm') ;
define('REG_PASSWORD','reg_password') ;
define('REG_PASSWORDCONFIRM','reg_passwordconfirm') ;

define('REG_FORM_MESSAGE','reg_form_message') ;

define('LOGIN_EMAIL','login_email') ;
define('LOGIN_PASSWORD','login_password') ;
define('LOGIN_FORM_MESSAGE','login_form_message') ;

define('LOGIN_BUTTON','login_button') ;
define('REG_BUTTON','reg_button') ;

define('NAME_SIZE','32') ;
define('PASSWORD_SIZE','16') ;


function tidyFormEntry($entry) {
	return ucfirst(strtolower(str_replace(' ','',strip_tags($entry)))) ;
}

function buildSpanMessage($message,$colour="#14C800") {
	return "<br><br><span style='color: $colour;'>$message</span>" ;
}

function clearAllSessionVars() {
	foreach ($_SESSION as $key => $value) {
		$_SESSION[$key] = '' ;
	}
	
}

function removeAllSessionVarsExcept($array, $keys) {
  $_SESSION = array_diff_key($_SESSION, array_flip((array) $keys));   
}

function removeSessionVar($varname) {
	unset($_SESSION[$varname]) ;
}

function emptySessionVars() {
	$_SESSION = array() ;
}

function setSessionVar($varname, $value=null) {
	$_SESSION[$varname] = $value ;
}

function getSessionVar($varname) {
	return $_SESSION[$varname] ;
}

function getDefaultSessionVar($varname, $defaultValue='') {
	return isset($_SESSION[$varname]) ? getSessionVar($varname) : $defaultValue ;
}
?>
