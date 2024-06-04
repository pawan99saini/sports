$(function(e) {
	$('textarea').each(function() {
		if($(this).attr('data-target')) {
			var clasEditor = $(this).attr('data-target');
			$('.'+ clasEditor).richText();
		}
	});

	function initializeEditor() {
		$('textarea').each(function() {
			if($(this).attr('data-target')) {
				var clasEditor = $(this).attr('data-target');
				$('.'+ clasEditor).richText();
			}
		});
	}
});