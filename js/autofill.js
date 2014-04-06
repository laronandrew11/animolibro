$(function() {
			$("#typeahead").typeahead({
				source:function(typeahead, query) {
					$.ajax({
						url: 'php/source.php',
						type: 'POST',
						data: 'query=' + query,
						dataType: 'JSON',
						async: false,
						success: function(data) {
							typeahead.process(data);
						}
					});
				}
			});
		});