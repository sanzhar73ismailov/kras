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

<table class="table_list" id="myTable">
	<thead>
		<tr>
<th>ID</th>
<th>ФИО</th>
<th>sex_id</th>

<th>year_birth</th>
<th>weight_kg</th>
<th>height_sm</th>
<th>prof_or_other_hazards_yes_no_id</th>

<th>nationality_id</th>
<th>smoke_yes_no_id</th>




<th>tumor_another_existence_yes_no_id</th>

<th>diagnosis</th>
<th>intestinum_crassum_part_id</th>
<th>colon_part_id</th>
<th>rectum_part_id</th>
<th>status_gene_kras_id</th>
<th>status_gene_kras3_id</th>
<th>status_gene_kras4_id</th>
<th>status_gene_nras2_id</th>
<th>status_gene_nras3_id</th>
<th>status_gene_nras4_id</th>
<th>date_invest</th>
<th>depth_of_invasion_id</th>
<th>stage_id</th>
<th>metastasis_regional_lymph_nodes_yes_no_id</th>
<th>tumor_histological_type_id</th>
<th>tumor_differentiation_degree_id</th>
		</tr>
	</thead>
	<tbody>
		{foreach $items as $item}

		<tr>
		
			<td>{$item.id}</td>
		<td>{$item.last_name} {$item.first_name} </td>
		<td>{$item.sex_id}</td>
	
		<td>{$item.year_birth}</td>
		<td>{$item.weight_kg}</td>
		<td>{$item.height_sm}</td>
		<td>{$item.prof_or_other_hazards_yes_no_id}</td>
	
		<td>{$item.nationality_id}</td>
		<td>{$item.smoke_yes_no_id}</td>
		
		
	
		<td>{$item.tumor_another_existence_yes_no_id}</td>
	
		<td>{$item.diagnosis}</td>
		<td>{$item.intestinum_crassum_part_id}</td>
		<td>{$item.colon_part_id}</td>
		<td>{$item.rectum_part_id}</td>
	
		<td>{$item.status_gene_kras_id}</td>
		<td>{$item.status_gene_kras3_id}</td>
		<td>{$item.status_gene_kras4_id}</td>
		<td>{$item.status_gene_nras2_id}</td>
		<td>{$item.status_gene_nras3_id}</td>
		<td>{$item.status_gene_nras4_id}</td>
		<td>{$item.date_invest}</td>
		<td>{$item.depth_of_invasion_id}</td>
		<td>{$item.stage_id}</td>
		<td>{$item.metastasis_regional_lymph_nodes_yes_no_id}</td>
		<td>{$item.tumor_histological_type_id}</td>
		<td>{$item.tumor_differentiation_degree_id}</td>
		</tr>


		{/foreach}
	</tbody>
</table>



</div>



{include file="footer.tpl"}</div>
</body>
</html>
