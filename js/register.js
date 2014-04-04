
 $(document).ready(function()
 {
  //$("#success-alert").hide();

// Popover 
 /*$('#registerHere input').hover(function()
 {
 $(this).popover('show')
 });*/

 
// Validation
 $("#registerHere").validate({
rules:{
user_name:"required",
user_email:{required:true,email: true},
user_contactno:{required:true, number:true},
user_password:{required:true,minlength: 6},
confirm_password:{required:true,equalTo: "#user_password"},
 },

messages:{
user_name:"Field must not be empty",
user_email:{
 required:"Field must not be empty",
 email:"Enter valid email address"},
user_password:{
 required:"Field must not be empty",
 minlength:"Password must be minimum 6 characters"},
 user_contactno:{
 required:"Field must not be empty",
 number:"Contact number should contain only digits 0-9"
 },
confirm_password:{
 required:"Field must not be empty",
 equalTo:"Password and Confirm Password must match"},
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

