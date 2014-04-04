
 $(document).ready(function()
 {
  //$("#success-alert").hide();

// Popover 
 /*$('#loginHere input').hover(function()
 {
 $(this).popover('show'),
 setTimeout(function () {
	var $self=$(this);	
        $self.popover('hide');
    }, 2000);

 });*/

 
// Validation
 $("#loginHere").validate({
rules:{
user_email:{required:true,email: true},
user_password:{required:true,minlength: 6},
 },

messages:{
user_email:{
 required:"Field must not be empty",
 email:"Enter valid email address"},
user_password:{
 required:"Field must not be empty",
 minlength:"Password must be minimum 6 characters"}
 },


 
 
errorClass: "help-inline",
errorElement: "span",
highlight:function(element, errorClass, validClass)
 {
 $(element).parents('.control-group').addClass('error');
 },
unhighlight: function(element, errorClass, validClass)
 {
 $(element).parents('.control-group').removeClass('error');
 $(element).parents('.control-group').addClass('success');
 }
 });
  //Submission
 /*$("#btn-submit").onclick(function(){

 //$("#success-alert").show();
 });*/
 });

