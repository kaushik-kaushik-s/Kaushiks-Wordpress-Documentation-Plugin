(function($){
	$(document).ready(function(){
		$('input[name="doc_search"]').on('keyup', function(){
			var value = $(this).val().toLowerCase();
			$('.kswdp-doc-page ul li').filter(function(){
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
})(jQuery);