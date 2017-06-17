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

<div class="center_title">Обратная связь</div>

<form method="post" action="sendmail.php"
	onsubmit="return checkform(this)"><input type="hidden" name="hidd"
	value="" />

<table class="form">



	<tr>
		<td>Ваша электронная почта</td>
		<td><input type="email" name="email" size="50" required="required" value="{$email}" /></td>
	</tr>
	
    <tr>
		<td>Тема</td>
		<td><input type="text" name="subject" size="50" required="required" /></td>
	</tr>

	<tr>
		<td>Вопрос</td>
		<td><textarea name="question_content" 
			style="width: 100%; height: 150px;"  required="required"></textarea></td>
	</tr>


	<tr>
		<td></td>
		<td><input type="submit" value="Послать"
			style="width: 120px; height: 20px"></td>

	</tr>
	<tr>
		<td></td>
		<td>{$message}</td>

	</tr>


</table>

</form>


</div>







{include file="footer.tpl"}</div>
</body>
</html>
