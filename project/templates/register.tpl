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
<div class="center_title">Регистрация</div>

{if !$result}

<form method="post" action="register.php"
	onsubmit="return checkRegisterForm(this)">


<table class="form">




	<tr>
		<td>Ваша электронная почта</td>
		<td><input id="email" type="email" name="email" size="50" required="required" /></td>
	</tr>

	<tr>
		<td>Пароль</td>
		<td><input id="password1" type="password" name="password" size="50"
			required="required" /></td>
	</tr>
		<tr>
		<td>&nbsp</td>
		<td><div style="font-size: small;">не менее 6 символов, только латинские буквы и цифры</div></td>
	</tr>

	<tr>
		<td>Пароль повторить</td>
		<td><input id="password2" type="password" name="password_copy" size="50"
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Код допуска (выдается админом)</td>
		<td><input id="code" type="password" name="code" size="50"
			required="required" /></td>
	</tr>

	<tr>
		<td></td>
		<td><input type="submit" value="ОК"
			style="width: 120px; height: 20px"></td>

	</tr>
	<tr>
		<td></td>
		<td>
		<div style="color: red;">{$message}</div>
		</td>

	</tr>


</table>

</form>
{else}

<table class="form">


	<tr>
		<td></td>
		<td>
		<div style="color: green;">{$message}</div>
		</td>

	</tr>


</table>
{/if}</div>







{include file="footer.tpl"}</div>
</body>
</html>
