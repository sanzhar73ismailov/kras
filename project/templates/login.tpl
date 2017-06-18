<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"}

</head>
<body>
<div id="wrap">{include file="header.tpl"}
<div id="content">


<div class="center_title">Вход</div>
<form method="post" action="login.php"
	onsubmit="return checkform(this)"><input type="hidden" name="hidd"
	value="" />

<table class="form">



	<tr>
		<td>Ваша электронная почта</td>
		<td><input type="email" name="login" size="50" required="required" /></td>
	</tr>
	
    <tr>
		<td>Пароль</td>
		<td><input type="password" name="password" size="50" required="required" /></td>
	</tr>

	<tr>
		<td></td>
		<td><input type="submit" value="Войти"
			style="width: 120px; height: 20px"></td>

	</tr>
	<tr>
		<td><a href="index.php?page=register">Пройти регистрацию</td>
		<td>{$message}</td>

	</tr>


</table>

</form>


</div>







{include file="footer.tpl"}</div>
</body>
</html>
