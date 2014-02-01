<!-- Include Bootstrap Asserts JavaScript Files. -->
<script type="text/javascript" src="jquery.validate.js"></script>
<script type="text/javascript">
 $(document).ready(function()
 {
// Popover 
 $('#registerHere input').hover(function()
 {
 $(this).popover('show')
 });

// Validation
 $("#registerHere").validate({
rules:{
user_name:"required",
user_email:{required:true,email: true},
user_password:{required:true,minlength: 6},
confirm_password:{required:true,equalTo: "#user_password"},
 },

messages:{
user_name:"Enter your first and last name",
user_email:{
 required:"Enter your email address",
 email:"Enter valid email address"},
user_password:{
 required:"Enter your password",
 minlength:"Password must be minimum 6 characters"},
confirm_password:{
 required:"Enter confirm password",
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
 });
</script>