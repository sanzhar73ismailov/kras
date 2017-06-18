<div id="header">
<h1>KRAS</h1>
<p />
<table width="100%"><tr><td  align="center">
<table border="1" style="">
	<tr>
	{if $authorized==1}
		<td><a href="index.php"><button>На главную страницу</button></a></td>
		<td><a href="index.php?page=list"><button>Список пациентов</button></a></td>
		<td><a href="edit.php?entity=patient&do=edit"><button>Добавить пациента</button></a></td>
		
		<td><a href="index.php?page=list_abs_data"><button>Список недостающих данных</button></a></td>
		

	{else}
	<td><a href="index.php?page=register"><button>Регистрация</button></a></td>
		<td><a href="index.php?page=login"><button>Войти</button></a></td>
	{/if}	

		
		
		<td><a href="index.php?page=contacts"><button>Контакты</button></a></td>
		<td><a href="index.php?page=feedback"><button>Обратная связь</button></a></td>
		
	{if $authorized}
		<td><a href="index.php?page=logout"><button>Выход</button></a></td>
	{/if}	
	

	</tr>
</table>
</td></tr></table>
</div>

