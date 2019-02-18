$(document).ready(function() {

	$('#signup_link').click(function(){
		// signup link pressed. Slide up current loginform and slide down and reveal new registration form.
		flipOverToRegistration() ;
 	}) ;

	$('#signin_link').click(function(){
		// signup link pressed. Slide up current registration form and slide down and reveal new login form.
		flipOverToLogin() ;
 	}) ;

}) ;

function revealRegistration() {
	$('#registrationform').slideDown('slow',function(){
	}) ;
}

function revealLogin() {
	$('#loginform').slideDown('slow',function(){
	}) ;
}

function flipOverToRegistration() {
	
	// show loginform 1st (just in case there's been some 'POST'ing) and then start the slide show.
	$('#loginform').show() ;
	$('#registrationform').hide() ;
	
	$('#loginform').slideUp('slow',function(){
		$('#registrationform').slideDown('slow',function(){
			// Completed!	
		})
	}) ;
}

function flipOverToLogin() {
	// show registration 1st (just in case there's been some 'POST'ing) and then start the slide show.
	$('#registrationform').show() ;
	$('#loginform').hide() ;
	
	$('#registrationform').slideUp('slow',function(){
		$('#loginform').slideDown('slow',function(){
			// Completed!	
		})
	}) ;

}
function showRegistrationForm() {
	showNHideForms('#registrationform','#loginform') ;
}
function showLoginForm() {
	showNHideForms('#loginform','#registrationform') ;
}

function showNHideForms(showFormId,hideFormId) {
	$(showFormId).show() ;
	$(hideFormId).hide() ;
}
	