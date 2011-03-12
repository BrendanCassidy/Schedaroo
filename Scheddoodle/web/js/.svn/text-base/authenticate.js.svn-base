$(document).ready(function() {
    $("input[name='id']").focus();
});

function authenticate(redirect) {

  $.post("do.php", { "action":"authenticate", "user":$("input[name='id']").val()}, function(data) {

	   $("#error").css("display","none");

	   if (data.out == -1) {
	     $("input[name='id']").val('').focus();
	     $("#error").css("display","block");
	   }
	   else if (data.out == 1) {
	     window.location = "login.php?message=1";
	     return;
	   }
	   else if (data.out == 0) {
	     window.location ="login.php?message=2";
           }
	   else {
	     alert("An unexpected error has occured.\nTry Logging in again.");
	   }
	 }, "json");
}
