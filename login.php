<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/dbconn.php";
    require_once "lib/head.php";
?>
<!-- 로그인 폼 -->
<div class="login_container">
	<form class="form-signup" id="form-login" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<h2 class="form-signup-heading">Sign In</h2>

		<label for="email">Email</label>
		<input type="email" class="form-control" id="email" name="email" placeholder="Email" autofocus>

		<label class="hidden" id="pwd_label" for="pwd">Password</label>
		<input class="hidden form-control" type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">

		<label class="hidden" id="pin_label" for="pin_pwd">PIN</label>
		<input class="hidden form-control" type="password" class="form-control" id="pin_pwd" name="pin_pwd" placeholder="PIN">

		<br />
		<input type="button" class="btn btn-lg btn-primary btn-block" id="btn_submit_login" value="Sign In"></button>

		<input type="hidden" id="login_type" value="fp">

	</form>
</div>

<?php
    require_once "lib/get_ip.php";
	require_once "lib/footer.php"
?>

<script type="text/javascript">
	$("#form-login").keyup(function(event) {
		if(event.keyCode == 13) {
			$("#btn_submit_login").click();
		}
	});

	$("#btn_submit_login").on("click", function() {
		var email_val = $("#email").val();
		var login_type = $("#login_type").val();

		if(login_type == 'fp')
		{

			if (typeof email_val === 'undefined' || email_val === '') {
				alert("Enter a valid email address");
			}
			else {
				var d1 = new Date();
				var fp = new Fingerprint2();
                var ips = document.getElementById("ip").innerHTML.split('.');
				var string = '';
				var i = 0;
				fp.get(function(result, components,a,b) {
					// var d2 = new Date();
					// var timeString = "Time took to calculate the fingerprint: " + (d2 - d1) + "ms";

					var strings = '';

					for (var property in components) {
						strings = strings + '!@#' + components[property]['value'];
					}

					for (var ip in ips) {
						 strings = strings + '!@#' + ip;
					}

					var ttt = strings.split('!@#'); // array 형태로 변환
					var ddd = ttt.shift(); // 첫번째 원소 제거
					$.ajax({
						type : "POST",
						data : {
							email : email_val,
							datas : JSON.stringify(ttt) // json 형태로 변환
						},
						url : "lib/chk_fingerprint.php",
						success: function(result)
						{
							if(result == '1111')
							{
								alert('This email address does not exist');
							}
							else if(result == '1112')
							{
								alert('Try again (err 109)');
							}
							else if(result == '1101')
							{
								alert('Welcome');
								location.href = 'index.php';
							}
							else if(result == '1122')
							{
								alert('Fingerprint login failed. Please enter password');
								$("#login_type").val("password");
								$("#pwd_label").removeClass("hidden");
								$("#pwd").removeClass("hidden");
								$("#pwd").focus();

							}
							else if(result == '1151')
							{
								alert('Fingerprint is not perfect. Please enter PIN');
								$("#login_type").val("pin");
								$("#pin_label").removeClass("hidden");
								$("#pin_pwd").removeClass("hidden");
								$("#pin_pwd").focus();
							}
							else
							{
								alert('Try again (err 110)');
							}

				        },
				        error: function (xhr, ajaxOptions, thrownError) {
					           alert(xhr.status);
					           alert(xhr.responseText);
					           alert(thrownError);
					       }
					});
				});
			}
		}
		else if(login_type == 'password')
		{
			var email_val = $("#email").val();
			var password_val = $("#pwd").val();

			$.ajax({
				type : "POST",
				data : {
					email : email_val,
					password : password_val
				},
				url : "lib/chk_pwd.php",
				success: function(result)
				{
					if(result == '2111')
					{
						alert('This email address does not exist');
					}
					else if(result == '2221')
					{
						alert('Welcome');
						location.href = 'index.php';
					}
					else if(result == '2223')
					{
						alert('Try again');
					}
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		           alert(xhr.status);
		           alert(xhr.responseText);
		           alert(thrownError);
		        }
			});
		}
		else if(login_type == 'pin')
		{
			var email_val = $("#email").val();
			var pin_val = $("#pin_pwd").val();

			var fp = new Fingerprint2();
            var ips = document.getElementById("ip").innerHTML.split('.');

			fp.get(function(result, components,a,b) {

					var strings = '';

					for (var property in components) {
						strings = strings + '!@#' + components[property]['value'];
					}

					for (var ip in ips) {
						 strings = strings + '!@#' + ip;
					}

					var ttt = strings.split('!@#'); // array 형태로 변환
					var ddd = ttt.shift(); // 첫번째

					$.ajax({
						type : "POST",
						data : {
							email : email_val,
							pin : pin_val,
							datas : JSON.stringify(ttt)
						},
						url : "lib/chk_pin.php",
						success: function(result)
						{
							if(result == '3111')
							{
								alert('This email address does not exist');
							}
							else if(result == '3112')
							{
								alert('Try again(err 312)');
							}
							else if(result == '3101')
							{
								alert('Welcome');
								location.href = 'index.php';
							}
							else if(result == '3323')
							{
								alert('Nice Try :)');
								history.back();
							}
							else if(result == '3233')
							{
								alert('PIN login failed. Please enter password');
								$("#login_type").val("password");
								$("#pwd_label").removeClass("hidden");
								$("#pwd").removeClass("hidden");
								$("#pin_label").addClass("hidden");
								$("#pin_pwd").addClass("hidden");
								$("#pwd").focus();
							}
				        },
				        error: function (xhr, ajaxOptions, thrownError) {
				           alert(xhr.status);
				           alert(xhr.responseText);
				           alert(thrownError);
				        }
					});
			});


		}

	});

</script>
