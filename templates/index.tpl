<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"}
</head>
<body>
<div id="wrap">{include file="header.tpl"}



<div id="content"><!--<div class="quick_panel"></div>-->
<div class="center_title">{$application_name}</div>

<table class="table_on_index">

	<tbody>


		<tr>
			<td><a href="edit.php?entity=patient&do=edit">
			<button class="button_on_index">Добавить пациента</button>
			</a></td>
		</tr>
		<tr>
			<td><a href="index.php?page=list">
			<button class="button_on_index">Список пациентов</button>
			</a></td>
		</tr>
		
		<tr>
		<!--		<td><a href="index.php?page=list_abs_data"><button>Список недостающих данных</button></a></td>-->
		
			<td><a href="index.php?page=logout">
			<button class="button_on_index">Выход</button>
			</a></td>
		</tr>



	</tbody>
</table>


</div>



{include file="footer.tpl"}</div>
</body>
</html>
