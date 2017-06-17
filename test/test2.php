<script type="text/javascript">



</script>
<?php
include 'includes/global.php';

$arr = array("id",
"patient_id",
"tumor_another_existence_yes_no_id",
"tumor_another_existence_discr",
"diagnosis",
"intestinum_crassum_part_id",
"colon_part_id",
"rectum_part_id",
"treatment_discr",
"status_gene_kras_id",
"date_invest",
"depth_of_invasion_id",
"stage_id",
"metastasis_regional_lymph_nodes_yes_no_id",
"metastasis_regional_lymph_nodes_discr",
"tumor_histological_type_id",
"tumor_differentiation_degree_id",
"block");

$arr_pat = array("id",
"last_name",
"first_name",
"patronymic_name",
"sex_id",
"sex",
"date_birth_string",
"year_birth",
"weight_kg",
"height_sm",
"prof_or_other_hazards_yes_no_id",
"prof_or_other_hazards_yes_no",
"prof_or_other_hazards_discr",
"nationality_id",
"nationality",
"smoke_yes_no_id",
"smoke_yes_no",
"smoke_discr",
"hospital",
"doctor",
"comments",
"user",
"insert_date");


foreach ($arr as $value){
	//echo sprintf("\$investigation->%s= \$this->getNullForObjectFieldIfStringEmpty(\$request['%s']);<br>",$value,$value);
	//echo sprintf("\$investigation->%s=\$row[0]['%s'];<br>", $value,$value);
	//echo sprintf("\$stmt->bindValue(':%s', \$investigation->%s, PDO::PARAM_INT);<br>", $value,$value);
	
}
foreach ($arr_pat as $value){
	//echo sprintf("\$investigation->%s= \$this->getNullForObjectFieldIfStringEmpty(\$request['%s']);<br>",$value,$value);
	//echo sprintf("\$investigation->%s=\$row[0]['%s'];<br>", $value,$value);
	//echo sprintf("<td>{if \$item->%s == null} - {else} + {/if}</td>\n", $value);
	
	//echo sprintf("<th>%s</th>\n", ++$i);
		echo sprintf("\$%s_trans='';<br>", $value);
	
}

?>