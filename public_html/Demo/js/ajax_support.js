var loading = false ;


function buildFormattedPostCollectionCall(pageNumber) {

	var ajaxParameters = {
		url: 'includes/ajax_loadposts.php',
		type: 'POST',
		data: 'page=' + pageNumber,
		cache: false,

		success: function(rdata) {
			$('#loading').hide() ;
			var olddata = $('.posts_area').html() ;
			var newdata = rdata.trim() ;
			$('.posts_area').html(olddata + newdata) ;
			// increase page only if we had new stuff to display.
			if (newdata.length > 0) {
				$('.posts_area').attr('page',pageNumber + 1) ;
			}
			loading = false ;	//allow new downloads
			
		},
		
		error: function(errData) {

			$('#loading').hide() ;
			$('.posts_area').html('ERROR LOADING POSTS!' + errData) ;
			loading = false ;	//allow new downloads
		}
		
	} ;
	return ajaxParameters ;
	
}

function loadPostData() {
	$('#loading').show() ;
	loading = true ;
	window.setTimeout(function() {
		var pageNumber = parseInt($('.posts_area').attr('page'))  ;
		$.ajax(buildFormattedPostCollectionCall(pageNumber)) ;
	},4000) ;
}


function initDeletePostCallback() {
	$('.delete-post-button').on('click',function(e){
		var deleteButtonClicked = e.currentTarget.dataset['postid'] ;
		console.log('button clicked',deleteButtonClicked) ;
 	}) ;
}

$(document).ready(function() {
	
	debug() ;
	if (!loading) {
		loadPostData() ;
	}
	
	
}) ;


$(window).scroll(function() {
		debug() ;
		var pos = $('body').scrollTop() ; 
		var viewHgt = $('body').height()  ;
		var paPos = $('.posts_area').offset().top ;
		var paHgt = $('.posts_area').height() ;
	
		var page = parseInt($('.posts_area').attr('page'))  ;
		var maxPages = parseInt($('.total_posts').attr('maxPages'))  ;
		
		//var pageLimit = parseInt($('.posts_area').attr('page_limit'))  ;
	
		if ((true) &&  (page < maxPages) && (pos + viewHgt >= paPos + paHgt)) {
			if (!loading) {
				loadPostData() ;
			}
		}
	
}) ;




/*
	Debug support
*/

function buildDebug() {
	var pos = $('body').scrollTop() ;
	var viewHgt = $('body').height()  ;
	var paPos = $('.posts_area').offset().top ;
	var paHgt = $('.posts_area').height() ;
	return 'dbg: pos ' + pos + ' viewHgt ' + viewHgt + ' paPos ' + paPos + ' paHgt '  + paHgt  ;
}

function debug() {
	$('.debug_area').html(buildDebug()) ;
}

function loadTestData() {

	$('#loading').show() ;
	loading = true ;

	window.setTimeout(
		function() {
		
			str = $('.posts_area').html()  ;
			var pageNumber = parseInt($('.posts_area').attr('page'))  ;
	
			for(i = 0 ; i < 100 ; i++) {
				str += 'LINE ' +  i.toString() + '(Page ' + pageNumber.toString(10)+ ')<BR>' ;
			}
	
			$('.posts_area').html(str) ;
			$('.posts_area').attr('page',pageNumber + 1) ;
			loading = false ;
			$('#loading').hide() ;
		},1000) ;
}
