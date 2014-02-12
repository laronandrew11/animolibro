
 $(document).ready(function()
 {
 $('.accept-btn').on('click', function () {
	$(this).removeClass('accept-btn');
	$(this).addClass('disabled');
	$(this).text("Sold");
 });

 });

