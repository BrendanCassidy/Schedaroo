$(document).ready(function() { $("input[name='oldpass']").focus(); });

function changePass() {
	$.post("do.php", { "action":"update_password", "oldpass":$("input[name='oldpass']").val(), "newpass":$("input[name='newpass']").val(), "rnewpass":$("input[name='rnewpass']").val() }, function(data) {	
		$("#badpasserror").css("display","none");
		$("#badmatcherror").css("display","none");
		
		if (data.out == 1) {
		    $("input[name='rnewpass']").val('');
			$("input[name='newpass']").val('');
			$("input[name='oldpass']").val('').focus();
		 	$("#badpasserror").css("display","block");
			$("#badmatcherror").css("display","none");
		}
		else if (data.out == 2) {
			$("input[name='rnewpass']").val('');
		    $("input[name='newpass']").val('').focus();
		    $("#badmatcherror").css("display","block");
			$("#badpasserror").css("display","none");
		}
		else if (data.out == 0) { window.location = 'problems.php'; }
		else { alert("An unexpected error has occured.\nTry Logging in again."); }
		
	}, "json");
}