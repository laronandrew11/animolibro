$(function() {
		$("#book_title").typeahead({

				source:function(typeahead, query) {
					//alert("WOO!");
					$.ajax({
						
						url: 'php/selltitlefill.php',
						type: 'POST',
						data: 'title=' + query,
						dataType: 'JSON',
						async: false,
						success: function(data) {
							typeahead.process(data);
						}
					});
				}
			});
});
	

$(function() {
			$("#book_isbn").typeahead({
				//name:'isbn';
				source:function(typeahead, query) {
					$.ajax({
						
						url: 'php/sellautofill.php',
						type: 'POST',
						data: 'isbn=' + query,
						dataType: 'JSON',
						async: false,
						success: function(data) {
							typeahead.process(data);
						}
					});
				}
			});
			
		});
