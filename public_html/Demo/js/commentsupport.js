	function deletePost(post_id) {
		if ($(event.target).is('button')) {

			console.log('JSON deletePost postid =',post_id) ;

			bootbox.confirm('Are you sure you want to delete this post?',function(confirmed) {
				console.log('bootbox.confirm deletePost ',confirmed) ;

				if (confirmed) {
					$.post('service/json/deletemessage.php',JSON.stringify({postid:post_id}),function(response,status){
						console.log('JSON Post Done response -->',response) ;
						console.log('JSON Post Done status -->',status) ;
						
					},'json').fail(function(response,status) {
						console.log('JSON Error!! calling host php - response',response) ;
						console.log('JSON Error!! calling host php - status',status) ;
						
					}).done(function(){
						console.log('JSON Done ... Refreshing Page -->') ;
						location.reload() ;
					}) ;
				}
			}) ;
			
			
		} 
	}

	function togglePostComment(id) {

		if (!$(event.target).is('a')) {
			var find = '#' +id + '.post_comment' ;
			$(find).slideToggle() ;
		} 
	}
	
	
	


	