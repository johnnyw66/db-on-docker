var receipient ;
var sender ;


function sendMessage(text,from,to) {
	
	var jsonPost = JSON.stringify({
		to : to,
		from : from,
		message : text
	}) ;

	var ajaxParameters = {

			url: 'service/json/sendmessage.php',
			type: 'POST',
			dataType: 'json',
			data: jsonPost,
			cache: false,
			contentType: 'application/json',

			success: function(rdata) {
				// json response
				alert('Done sending message ' + rdata['message'] + ' ' + rdata['from'] + ' ' + rdata['to']) ;
			},

			error: function(errData) {
				alert('Some Error sending message ' + errData) ;
			}

		} ;
		
		window.setTimeout(function() {
			$.ajax(ajaxParameters) ;
		},500) ;

		
}

$(document).ready(function() {
	
		$('#sendMessageModal').on('show.bs.modal', function (event) {

		  var button = $(event.relatedTarget)  ; // Button that triggered the modal
		  receipient = button.data('to-username') ;// Extract info from data-* attributes
		  sender = button.data('from-username') ; // Extract info from data-* attributes
	
		  var modal = $(this)
		  modal.find('.modal-title').text('New message to ' + receipient)
		  modal.find('.modal-body input').val(receipient)

		}) ;
	
	
		$('#sendMessageModal').on('hide.bs.modal', function (event) {
	  
		// note: button objects did not cause this event - it was the modal object!
		// We find the focused element to determine if we want to 'send' a message.
		 
		var activeElement = $(document.activeElement);
		var text = $('#message-text').val()
					.replace(/(<([^>]+)>)/ig,"")
					.trim() ;  // remove HTML tags and leading/trailing WS.
	
		console.log('The event that actually closed the modal is : ', activeElement[0].id);
	
		if (text.length > 0 && activeElement[0].id == 'sendmessagebutton') {
			sendMessage(text,sender,receipient) ;
			$('#message-text').val('') ;
		}

	}) ;


	
}) ;







