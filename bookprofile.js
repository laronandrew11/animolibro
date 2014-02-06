 $(document).ready(function()
 {
 $('.buy-btn').on('click', function(){
	$(this).removeClass('buy-btn');
	$(this).addClass('disabled');
	$(this).text("Bought");
 });
 })



