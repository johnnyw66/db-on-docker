<?php
require 'com/fastchat/forms/form_handlers.php' ;
?>

<html>

<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/reg_style.css">
	<script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	<script src = 'js/jqregister.js'></script>
	<script src = 'js/validatehelper.js'></script>
</head>	

<body>
	<?php
	
	if (isset($_POST[REG_BUTTON])) {
		
		if (isset($_SESSION['reg_fname'])) {
			
			$formShow = 'showRegistrationForm()' ;		// We have failed to register - keep Reg Form showing
			
		} else {
			$formShow = 'showLoginForm()' ;
			$formShow = 'flipOverToLogin()' ;
			
		}
		
	} else if (isset($_POST[LOGIN_BUTTON])){
		
		$formShow = 'showLoginForm()' ;					// login failed - keep showing Login Form.


	} else {
//		clearAllSessionVars() ;							// GET - Clear all variables and reveal Login Form.
		session_destroy() ;							// GET - Clear all variables and reveal Login Form.
		$formShow = 'revealLogin()' ;
	}

	echo '
		<script>
			$(document).ready(function() { '.$formShow.' ;
			}) ;
		</script> ' ;
	?>
	
	<div class='background'>
		
		<div id='loginform' class='formbox'>
			<div class='form_title'>
				<h1>FastChat</h1>
				Login
			</div>
			<form name='loginForm' action='register.php' onsubmit="return validateLoginForm(loginForm);" method='POST'>
		
				<input type='email' name='<?php echo LOGIN_EMAIL ; ?>' placeholder='Email' value="<?php echo getDefaultSessionVar(LOGIN_EMAIL) ;?>" required /><br>
				<input type='password' name='<?php echo LOGIN_PASSWORD ; ?>' placeholder='Password' required/><br>
				<input type='submit' name='<?php echo LOGIN_BUTTON ; ?>' value='Login'  />
				
				<?php echo getDefaultSessionVar(LOGIN_FORM_MESSAGE) ; ?>

				<br>
				<a href='#' id='signup_link'>Need to Register? Sign-up here.</a>

			</form>
		</div>

		<div id='registrationform' class='formbox'>
			<div class='form_title'>
					<h1>FastChat</h1>
						Register
			</div>
			<form name='regForm' action='register.php' onsubmit="return validateRegisterForm(regForm);" method='POST'>
				
				<input type='text' name='<?php echo REG_FNAME ; ?>' placeholder='First Name'  size=<?php echo NAME_SIZE ; ?> value="<?php echo getDefaultSessionVar(REG_FNAME) ; ?>" required /><br>
				<input type='text' name='<?php echo REG_LNAME ; ?>' placeholder='Last Name' size=<?php echo NAME_SIZE ; ?> value="<?php echo getDefaultSessionVar(REG_LNAME) ; ?>" required /><br>
				<input type='email' name='<?php echo REG_EMAIL ; ?>' placeholder='Email'  value="<?php echo getDefaultSessionVar(REG_EMAIL) ; ?>" required /><br>
				<input type='email' name='<?php echo REG_EMAILCONFIRM ; ?>' placeholder='Confirm Email' value="<?php echo getDefaultSessionVar(REG_EMAIL) ; ?>" required /><br>
				<input type='password' name='<?php echo REG_PASSWORD ; ?>' placeholder='Password'  size=<?php echo PASSWORD_SIZE ; ?> required/><br>
				<input type='password' name='<?php echo REG_PASSWORDCONFIRM ; ?>' placeholder='Confirm Password'  size=<?php echo PASSWORD_SIZE ; ?> required /><br>
				<input type='submit' name='<?php echo REG_BUTTON ; ?>' value='Register'  />

				<?php echo getDefaultSessionVar(REG_FORM_MESSAGE) ; ?>
				
				<br>
				<a href='#' id='signin_link'>Already Registered? Sign-in here.</a>
			</form>
		</div>
		
		
	</div>
</body>
</html>