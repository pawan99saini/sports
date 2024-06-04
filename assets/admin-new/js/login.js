(function () {
	// ______________LOADER
	$("#global-loader").fadeOut("slow");

	$(document).on('submit', '#loginform', function() {
	    $('#login-load').fadeIn();

	    var formData = new FormData(this);

	    $.ajax({
	        url: $(this).attr('action'),
	        type : 'POST',
	        data : formData,
	        dataType: 'json',
	        processData: false,
	        contentType: false,
	        success: function( response ) {
	            $('#login-load').fadeOut();
	            
	            $('#msg-login').html( response.message );
	            
	            if( response.status == 1 ) {
	                setTimeout(function() {
	                    window.location.href = response.url;
	                }, 1500);                    
	            } 
	        },
	        error : function(request, status, error) {
	            $('#login-load').fadeOut();
	            console.log(request.responseText);
	        }
	    });
	});
})();