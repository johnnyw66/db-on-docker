	String.prototype.camelCase = function() {
		// @todo - Tokenise with delim ' ' - Start every word with lower case and then remove white spaces
		// concat all words to one string.
	    return this.charAt(0).toUpperCase() + this.toLowerCase().slice(1);
	}
	
	String.prototype.removeWhiteSpace = function() {
		return this.replace(/\s/g,"") ;
	}
	
	String.prototype.removeTags = function() {
		return this.replace(/(<([^>]+)>)/ig,"") ;
	}
	
	
	function checkValidEmail(email) {
		return (/^\w+([\.+]?\w+)*([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) ;
	}
	
	function validateName(name,fname='fieldname',limit = 2) {

		if (name.length > limit) {
			throw Error("!!!Size of field '" + fname +"' too large - Limit " + limit + ' chars') ;
		}
		
		return name.removeWhiteSpace().removeTags().camelCase();
	}
	

	function validateEmail(email,confirm) {

		fil_email = email.removeWhiteSpace().removeTags().toLowerCase() ;
		fil_confirmemail = confirm.removeWhiteSpace().removeTags().toLowerCase() ;

		if (fil_email === fil_confirmemail) {
			if (!checkValidEmail(fil_email)) {
				throw new Error("Invalid email format!") ;
			}
			return fil_email;
		} else {
			throw new Error("Emails do not match!") ;
		}
		
	}
	
	function validatePassword(password,confirm) {

		if (password === confirm) {
			if (password.length < 1) {
				throw new Error("Password must have at least 1 characters!")
			}
			return password ;
		} else {
			throw new Error("Passwords do not match!") ;
		}
	}
	
	function validateFormText(inputTag) {
		return validateName(inputTag.value,inputTag.placeholder,inputTag.size) ;
	}
	
	function validateRegisterForm(formValidate) {
		
		try {
			formValidate.reg_fname.value = validateFormText(formValidate.reg_fname) ;
			formValidate.reg_lname.value = validateFormText(formValidate.reg_lname) ;
			formValidate.reg_email.value = validateEmail(formValidate.reg_email.value,formValidate.reg_emailconfirm.value) ;
			formValidate.reg_password.value = validatePassword(formValidate.reg_password.value,formValidate.reg_passwordconfirm.value) ;
			return true ;
		} catch(e) {
			alert(e);
			return false ;
		}
	}
	
	function validateLoginForm(formValidate) {
		try {
			formValidate.login_email.value = validateEmail(formValidate.login_email.value,formValidate.login_email.value) ;
			return true ;
		} catch(e) {
			alert(e);
			return false ;
		}
		
	}
	
	