<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"}
<script src="jscript/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(document).ready(function() 
	    { 
	        $("#myTable").tablesorter(); 
	    } 
	);
</script>
</head>
<body>
<div id="wrap">{include file="header.tpl"}



<div id="content">


<!--<div class="quick_panel"></div>-->
<div class="center_title">Список пациентов</div>
<div class="comment_label">* Для сортировки по столбцу кликните по заголовку этого столбца</div>
<table class="table_list" id="myTable">
	<thead>
		<tr>
			<th>Код</th>
			<th>ФИО</th>
			<th>Пол</th>
			<th>Дата рожд</th>
			<th>Больница-леч. врач</th>
			<th>Дата рег.</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	{foreach $patients as $item}

	<tr>
		<td>{$item.id}</td>
		<td style="font-size: medium;"><a href="edit.php?entity=patient&id={$item.id}">{$item.last_name} {$item.first_name} {$item.patronymic_name}</a></td>
		<td style="font-size: small;">{$item.sex}</td>
		<td style="font-size: small;">{if isset($item.date_birth)} {$item.date_birth} {else}
		{$item.year_birth} {/if}</td>
		<td style="font-size: small;">{$item.hospital} - {$item.doctor}</td>
		<td style="font-size: small;">{$item.insert_date} </td>
		
<!--		<td>-->
<!--		<a href="edit.php?entity=investigation&id=0&patient_id={{$item.id}}">Изменить клинические данные</a>-->
<!--		</td>-->
	</tr>


	{/foreach}
	</tbody>
</table>


</div>


<p>&nbsp</p>
{include file="footer.tpl"}
</div>
</body>
</html>
