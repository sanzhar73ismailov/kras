<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
<script src="jscript/myScript.js"></script>
</head>
<body>


<div id="wrap">{include file="header.tpl"}



<div id="content">
<div id="wrap">{include file="panel.tpl"}
<div class="center_title">Пациент: клинич. данные</div>
<form method="post" action="edit.php" onsubmit="return checkform(this)">
<input type="hidden" name="do" value="save">
<input type="hidden" name="entity" value="{$entity}"/> 
<input	type="hidden" name="patient_id" value="{$object->patient_id}"/> 
{if $object->id}
<input type="hidden" name="id" value="{$object->id}" /> 
{/if}
	
	

<table class="form">
	{if $edit}
	<tr>
		<td><input type="submit" value="Сохранить" style="width: 120px; height: 20px"></td>
		<td class="req_input">Обязательные поля выделены этим цветом, <br />
		без их заполнения данные не сохранятся!</td>
	</tr>
	{else}
	<tr>
		<td><a href="edit.php?entity={$entity}&id={$object->id}&patient_id={$object->patient_id}&do=edit"><img width="20" height="20" alt="Править" src="images/edit.jpg"/></a></td>
		<td></td>
	</tr>
	{/if}
	



	<td>Пациент</td>
	<td style="font-size: large; font-weight: bold "> {$patient->last_name} {$patient->first_name} {$patient->patronymic_name} (Код {$patient->id})</td>
	</tr>

	<tr>
		<td>Наличие других доброкачественных<br />
		и(или) злокач. опухолей (да, нет)</td>
		<td><select
			{$class} {$disabled} name="tumor_another_existence_yes_no_id">
			{foreach $yesnovals as $item}
			<option {if $item->id ==$object->tumor_another_existence_yes_no_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>


	</tr>

	<tr>
		<td>Наличие других доброкачественных<br />
		и злокач. опухолей (описание)</td>
		<td><input {$class} type="text"
			{$readonly} name="tumor_another_existence_discr" size="50"
			value="{$object->tumor_another_existence_discr}" /></td>
	</tr>

	<tr>
		<td>Диагноз текстом</td>
		<td><input {$class} type="text" {$readonly} name="diagnosis" size="50"
			value="{$object->diagnosis}" /></td>
	</tr>

	<tr>
		<td>Поврежденный отдел толстой кишки</td>
		<td><select {$class} {$disabled} name="intestinum_crassum_part_id">
			{foreach $intestinum_crassum_part_vals as $item}
			<option {if $item->id == $object->intestinum_crassum_part_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Если повреждена ободочная кишка,<br />
		указать какая часть</td>
		<td><select {$class} {$disabled} name="colon_part_id">
			{foreach $colon_part_vals as $item}
			<option {if $item->id == $object->colon_part_id} selected="selected"
			{/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Если повреждена прямая кишка,<br />
		указать какая часть</td>
		<td><select {$class} {$disabled} name="rectum_part_id">
			{foreach $rectum_part_vals as $item}
			<option {if $item->id == $object->rectum_part_id} selected="selected"
			{/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Вид и объем полученного лечения (описание)</td>
		<td><input {$class} type="text" {$readonly} name="treatment_discr"
			size="50" value="{$object->treatment_discr}" /></td>
	</tr>

	<tr>
		<td>Статус гена K-RAS экзон 2</td>
		<td><select {$class} {$disabled} name="status_gene_kras_id">
			{foreach $status_gene_kras_vals as $item}
			<option {if $item->id == $object->status_gene_kras_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>
	<!--------------->
	<tr>
		<td>Статус гена K-RAS экзон 3</td>
		<td><select {$class} {$disabled} name="status_gene_kras3_id">
			{foreach $status_gene_kras3_vals as $item}
			<option {if $item->id == $object->status_gene_kras3_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>
	<tr>
		<td>Статус гена K-RAS экзон 4</td>
		<td><select {$class} {$disabled} name="status_gene_kras4_id">
			{foreach $status_gene_kras4_vals as $item}
			<option {if $item->id == $object->status_gene_kras4_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>
	<tr>
		<td>Статус гена N-RAS экзон 2</td>
		<td><select {$class} {$disabled} name="status_gene_nras2_id">
			{foreach $status_gene_nras2_vals as $item}
			<option {if $item->id == $object->status_gene_nras2_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>
	<tr>
		<td>Статус гена N-RAS экзон 3</td>
		<td><select {$class} {$disabled} name="status_gene_nras3_id">
			{foreach $status_gene_nras3_vals as $item}
			<option {if $item->id == $object->status_gene_nras3_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>
	<tr>
		<td>Статус гена N-RAS экзон 4</td>
		<td><select {$class} {$disabled} name="status_gene_nras4_id">
			{foreach $status_gene_nras4_vals as $item}
			<option {if $item->id == $object->status_gene_nras4_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>
	
    <!--------------->
	<tr>
		<td>Дата исследования(в формате дд/мм/гггг<br />
		пример: 07/02/2013)</td>
		<td><input {$class_req_input} type="text" {$readonly} name="date_invest"
			id="date_invest" size="50" value="{$object->date_invest_string}"
			onblur="IsObjDate(this);" onkeyup="TempDt(event,this);" /></td>
	</tr>

	<tr>
		<td>Глубина инвазии на основании<br />
		гистологического заключения</td>
		<td><select style="width: 355px;"
			{$class} {$disabled} name="depth_of_invasion_id">
			{foreach $depth_of_invasion_vals as $item}
			<option {if $item->id == $object->depth_of_invasion_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Стадия заболевания по TNM</td>
		<td><select {$class} {$disabled} name="stage_id">
			{foreach $stage_vals as $item}
			<option {if $item->id == $object->stage_id} selected="selected" {/if}
			value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Поражение регионарных лимфатических<br />
		узлов на основании результатов гистологического<br />
		исследованияоперационного материала (да, нет)</td>
		<td><select
			{$class} {$disabled} name="metastasis_regional_lymph_nodes_yes_no_id">
			{foreach $yesnovals as $item}
			<option {if $item->id ==
			$object->metastasis_regional_lymph_nodes_yes_no_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Описание Поражения регионарных лимфатических<br />
		узлов на основании результатов гистологического<br />
		исследования операционного материала</td>
		<td><input {$class} type="text"
			{$readonly} name="metastasis_regional_lymph_nodes_discr" size="50"
			value="{$object->metastasis_regional_lymph_nodes_discr}" /></td>
	</tr>



	<tr>
		<td>Гистологический тип опухоли<br />
		(аденокарцинома или муцинозный рак)</td>
		<td><select {$class} {$disabled} name="tumor_histological_type_id">
			{foreach $tumor_histological_type_vals as $item}
			<option {if $item->id == $object->tumor_histological_type_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Степень дифференцировки опухоли <br />
		(высокодифференцированная, умеренно или <br />
		низкодифференцированная опухоль)</td>
		<td><select
			{$class} {$disabled} name="tumor_differentiation_degree_id">
			{foreach $tumor_differentiation_degree_vals as $item}
			<option {if $item->id == $object->tumor_differentiation_degree_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>№ блоков, стеклопрепаратов</td>
		<td><input {$class} type="text" {$readonly} name="block" size="50"
			value="{$object->block}" /></td>
	</tr>
	<tr>
		<td>Примечание</td>
		<td><input {$class} type="text" {$readonly} name="comments" size="50"
			value="{$object->comments}" /></td>
	</tr>

	{if $edit}
	<tr>
		<td><input type="submit" value="Сохранить"
			style="width: 120px; height: 20px"></td>
		<td><input type="reset" value="Сброс"
			style="width: 120px; height: 20px"></td>
	</tr>
	{/if}

</table>

</form>

</div>

{include file="footer.tpl"}</div>

</body>
</html>
