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
<div class="center_title">{$title}</div>

{if $result}

<table class="form">


	<tr>
		<td></td>
		<td>
		<div style="color: green;">{$message}</div>
		</td>


	</tr>
	<tr>
		<td></td>
		<td><a href="index.php?page=login">Войти</a></td>



	</tr>


</table>


{else}

<table class="form">


	<tr>
		<td></td>
		<td>
		<div style="color: red;">{$message}</div>
		</td>

	</tr>


</table>
{/if}</div>
{include file="footer.tpl"}</div>
</body>
</html>
