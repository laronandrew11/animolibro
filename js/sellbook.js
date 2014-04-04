
 $(document).ready(function()
 {
  $("#success-alert").hide();
// Popover 
 $('#sellForm input').hover(function()
 {
 $(this).popover('show')
 });

// Validation
 $("#sellForm").validate({
rules:{
book_isbn:{required:true,digits:true, minlength: 13 },
book_title:{required:true},
book_authors:{required:true},
book_publisher:{required:true},
book_price:{required:true,number:true},
book_description:{required:true},
meetup_place:{required:true},

 },

messages:{
book_isbn:{
 required:"Field must not be empty.",
 minlength:"ISBN number must be minimum 13 characters",
  digits:"ISBN should contain only digits 0-9"},
 
book_title:{
 required:"Field must not be empty."},
book_authors:{
 required:"Field must not be empty."},
 book_publisher:{
 required:"Field must not be empty."},
book_price:{
 required:"Field must not be empty.",
 number:"Price must be a valid decimal number"},
 book_description:{
 required:"Field must not be empty."},
meetup_place:{
 required:"Field must not be empty."},

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