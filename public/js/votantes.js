$(function(){
	$("#myModal").draggable({
		handle: ".modal-header"
	});
	modalRegistraduria = function(){
		$('.modal .modal-body').css('height', $(window).height() * 0.7);
		$('#myModal').modal('show');	
	}
	
})
