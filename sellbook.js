
 $(document).ready(function()
 {
  $("#success-alert").hide();
// Popover 
 $('#registerHere input').hover(function()
 {
 $(this).popover('show')
 });

// Validation
 $("#registerHere").validate({
rules:{
book_isbn:{required:true,minlength: 13},
book_title:{required:true},
book_authors:{required:true},
book_price:{required:true},
meetup_place:{required:true},
user_password:{required:true},
 },

messages:{
book_isbn:{
 required:"Enter the book's ISBN number to automatically fill out other information.",
 minlength:"ISBN number must be minimum 13 characters"},
book_title:{
 required:"Enter the book's full title."},
book_authors:{
 required:"Enter the book's authors."},
book_price:{
 required:"Set your asking price for this book."},
meetup_place:{
 required:"Where do you want to meet your buyers?"},
user_password:{
 required:"Enter a password."}
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
 $("#btn-submit").onclick(function(){

 $("#success-alert").show();
  alert("WADASDASDAS");
 });
 });