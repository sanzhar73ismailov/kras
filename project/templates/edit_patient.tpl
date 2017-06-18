<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="jquery-ui.min.css">
<title>{$title}</title>
{include file="js_include.tpl"}
<script type="text/javascript">
  $(function() {
   
    var availableDoctorTags = [
                               {$doctorNames}
                         ];
    $( "#doctor" ).autocomplete({
        source: availableDoctorTags
      });
    var availableHospitalTags = [
                               {$hospitalNames}
                         ];
    $( "#hospital" ).autocomplete({
        source: availableHospitalTags
      });
    
  });
  </script>
</head>
<body>


<div id="wrap">{include file="header.tpl"}



<div id="content">
<div id="wrap">{include file="panel.tpl"}
<div class="center_title">Пациент</div>

<form method="post" action="edit.php" onsubmit="return checkform(this)">
<input type="hidden" name="do" value="save" /> <input type="hidden"
	name="entity" value="{$entity}" /> 

<table class="form">
	{if $edit}
	<tr>
		<td><input type="submit" value="Сохранить" 	style="width: 120px; height: 20px"></td>
		<td class="req_input">Обязательные поля выделены этим цветом, <br />
		без их заполнения данные не сохранятся!</td>
	</tr>
	{else}
	<tr>
		<td><a href="edit.php?entity={$entity}&id={$object->id}&do=edit">
		<img width="20" height="20" alt="Править" src="images/edit.jpg"/></a></td>
		<td></td>
	</tr>
	{/if}
	<tr>
		<td>Код пациента</td>
		<td>{if $object->id} {$object->id} <input type="hidden" name="id"
			value="{$object->id}" /> {else}
		<div style="background-color: #d14836">Новый</div>
		{/if}</td>

	</tr>


	<tr>
		<td>Фамилия</td>
		<td><input {$class_req_input} type="text" {$readonly} name="last_name"
			size="50" value="{$object->last_name}" /></td>
	</tr>

	<tr>
		<td>Имя</td>
		<td><input {$class_req_input} type="text"
			{$readonly} name="first_name" size="50" value="{$object->first_name}" /></td>
	</tr>

	<tr>
		<td>Отчество</td>
		<td><input {$class} type="text" {$readonly} name="patronymic_name"
			size="50" value="{$object->patronymic_name}" /></td>
	</tr>

	<tr>
		<td>Пол</td>
		<td><select {$class_req_input} {$disabled} name="sex_id">
			<option></option>
			{foreach $sexvals as $item}
			<option {if $item->id == $object->sex_id} selected="selected" {/if}
			value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Дата рождения (в формате дд/мм/гггг<br />
		пример: 07/02/1980)</td>
		<td><input {$class} type="text" {$readonly} name="date_birth"
			id="date_birth" size="50" value="{$object->date_birth_string}"
			onblur="IsObjDate(this);" onkeyup="TempDt(event,this);" /></td>
	</tr>
	
	
	<tr>
		<td>Год рождения</td>
		<td><input {$class_req_input} type="number"  min="1924" max="2010" {$readonly} name="year_birth"
			id="year_birth"	size="50" value="{$object->year_birth}" /></td>
	</tr>

	<tr>
		<td>Вес (кг)</td>
		<td><input {$class} type="text" {$readonly} name="weight_kg"
			id="weight_kg" size="50" value="{$object->weight_kg}"
			onblur="isObjDouble(this);" /></td>
	</tr>

	<tr>
		<td>Рост (см)</td>
		<td><input {$class} type="text" {$readonly} name="height_sm"
			id="height_sm" size="50" value="{$object->height_sm}"
			onblur="isObjDouble(this);" /></td>
	</tr>

	<tr>
		<td>Профессиональные или<br />
		иные вредности (да, нет)</td>
		<td><select
			{$class} {$disabled} name="prof_or_other_hazards_yes_no_id">
			{foreach $yesnovals as $item}
			<option {if $item->id == $object->prof_or_other_hazards_yes_no_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Профессиональные или<br />
		иные вредности (описание)</td>
		<td><input {$class} type="text"
			{$readonly} name="prof_or_other_hazards_discr" size="50"
			value="{$object->prof_or_other_hazards_discr}" /></td>
	</tr>

	<tr>
		<td>Национальность</td>
		<td><select {$class_req_input} {$disabled} name="nationality_id"
			id="nationality_id">
			<option></option>
			{foreach $nationalityvals as $item}
			<option {if $item->id == $object->nationality_id} selected="selected"
			{/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select>
		
<!--		<div id="pole_for_add_nationality"><input type="checkbox"-->
<!--			id="nationality_add" onclick="add_natinality();" /> Добавить вариант-->
<!--		</div>-->
		</td>
	</tr>

	<tr>
		<td>Курит (да, нет)</td>
		<td><select {$class} {$disabled} name="smoke_yes_no_id">
			{foreach $yesnovals as $item}
			<option {if $item->id == $object->smoke_yes_no_id}
			selected="selected" {/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>
	</tr>

	<tr>
		<td>Если курит указать как часто</td>
		<td><input {$class} type="text" {$readonly} name="smoke_discr"
			size="50" value="{$object->smoke_discr}" /></td>
	</tr>

	<tr>
		<td>Откуда материл<br />
		(Город, больница)</td>
		<td><input id="hospital" {$class_req_input} type="text" {$readonly} name="hospital"
			size="50" value="{$object->hospital}" /></td>
	</tr>


	<tr>
		<td>ФИО врача</td>
		<!-- <td><input {$class} type="text" {$readonly} name="doctor" size="50"
			value="{$object->doctor}" /> -->
			
			<td><input id="doctor" {$class} type="text" {$readonly} name="doctor" size="50"
			value="{$object->doctor}" /></td>
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
	{else} {/if}

</table>

</form>

</div>

{include file="footer.tpl"}</div>

</body>
</html>
