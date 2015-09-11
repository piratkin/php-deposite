<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf8'>
<title>Регистрация:</title>
<style type="text/css">
input.login_button {
    position: relative;
    display: inline-block;
    font-family: Arial,Helvetica,FreeSans,"Liberation Sans","Nimbus Sans L",sans-serif;
    font-weight: 700;
    color: rgb(245,245,245);
    text-shadow: 0 -1px rgba(0,0,0,.1);
    text-decoration: none;
    user-select: none;
    padding: .3em 1em;
    outline: none;
    border: none;
    border-radius: 3px;
    background: #0c9c0d linear-gradient(#82d18d, #0c9c0d);
    box-shadow: inset #72de26 0 -1px 1px, inset 0 1px 1px #98ff98, #3caa3c 0 0 0 1px, rgba(0,0,0,.3) 0 2px 5px;
    -webkit-animation: pulsate 1.2s linear infinite;
    animation: pulsate 1.2s linear infinite;
}
input.login_button:hover {
    -webkit-animation-play-state: paused;
    animation-play-state: paused;
    cursor: pointer;
}
input.login_button:active {
    top: 1px;
    color: #fff;
    text-shadow: 0 -1px rgba(0,0,0,.3), 0 0 5px #ffd, 0 0 8px #fff;
    box-shadow: 0 -1px 3px rgba(0,0,0,.3), 0 1px 1px #fff, inset 0 1px 2px rgba(0,0,0,.8), inset 0 -1px 0 rgba(0,0,0,.05);
}
@-webkit-keyframes pulsate {
    50% {color: #fff; text-shadow: 0 -1px rgba(0,0,0,.3), 0 0 5px #ffd, 0 0 8px #fff;}
}
@keyframes pulsate {
    50% {color: #fff; text-shadow: 0 -1px rgba(0,0,0,.3), 0 0 5px #ffd, 0 0 8px #fff;}
}
</style>
</head>
<body style="margin:0px; background:#eee;">
<div id="login_form" style="width: 100%; height: 95%; position: relative;">
<form method="post" target="_top" action="/" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 300px; height: 160px; margin: auto;">
    <table style="border: 1px solid black; background:#ccc; padding: 5px; font: normal 'Trebuchet MS', 'Trebuchet', 'Verdana', sans-serif; border-radius:5px">
	    <tr>
			<td colspan="2">
			    <?php 
				     if (test(HAS_LOGIN) || test(HAS_PASSWORD)) {
					     if (!test(ACCESS_LOGIN))    echo "<li style='color: red; font-size:small;'><i>неверный логин</i></li>"; 
                         if (!test(ACCESS_PASSWORD)) echo "<li style='color: red; font-size:small;'><i>неверный пароль</i></li>"; 
					 }
				?> 
			</td>
		</tr>
		<tr>
			<td colspan="2">
				Электронная почта:<br />
				<input type="text" name="user_login" maxlength="50" size="30%" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				Пароль:<br />
				<input type="password" name="user_pass" maxlength="50" size="30%" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" class="login_button" name="Login" value="Войти" style="margin-top: 5px;"/>
			</td>
		</tr>
	</table>	
</form>
</div>
</body>
</html>