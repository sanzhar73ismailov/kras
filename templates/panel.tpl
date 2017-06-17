    
<table class="panel">
	<tr>
		<td>
		{if $entity eq "patient"}
		<span class="selected_tab">Личные данные</span>
		 
		{else}
		<a class="not_selected_tab" href="edit.php?entity=patient&id={$object->patient_id}&do=view">Личные
		данные</a>
		{/if}
		</td>
		
		
		<td>
		{if $patient_exist}
			{if $entity eq "investigation"}
				<span class="selected_tab">Клинические данные</span>
			   
			{else}
			<a class="not_selected_tab" href="edit.php?entity=investigation&patient_id={$object->id}">
			{if $investigation_exist}
			   Клинические данные
			{else}
			   Добавить клинические данные
			{/if}
			</a>
			    
			{/if}
		{/if}
		</td>
	</tr>

</table>