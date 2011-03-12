$(document).ready(function() {
    $("input[name='user']").focus();
});

function login(redirect) {

  $.post("do.php", { "action":"login", "user":$("input[name='user']").val(), "password":$("input[name='password']").val() }, function(data) {

	   $("#error").css("display","none");
	   $("#autherror").css("display","none");
	   
	   if (data.out == 1) {
	     $("input[name='password']").val('').focus();
	     $("#error").css("display","block");
	   }
	   else if (data.out == 0) {
	     window.location = redirect;
	     return;
	   }

	   else if (data.out == 2) {
		$("#autherror").css("display","block");
                $("#autherror").html('Your account is not activated. Click <a href="authenticateaccount.php?user=' + $("input[name='user']").val() + '">here</a> to activate.');
	   }
	
	   else {
		alert("An unexpected error has occured.\nTry Logging in again.");
	   }
	 }, "json");
}
