<?php
include_once 'includes/global.php';

$smarty = new Smarty();



if(isset($_REQUEST["entity"])){

	$entity = $_REQUEST["entity"];
	$id = (int) $_REQUEST["id"];


	if($entity == "patient"){

		if($_REQUEST["id"]){
			$id = (int) $_REQUEST["id"];
			//echo "<h1>Старый</h1>";
		}else{
			//echo "<h1>Молодой</h1>";

		}



		$patientParsed = $dao->parse_form_to_patient($_REQUEST);
		//var_dump($patientParsed);



		$insert_id = $dao->save_patient($patientParsed);
		$patient =$dao->getPatient($insert_id);
		//echo "<p>insert_id=$insert_id <p>";

        $smarty->assign('entity',$entity);

		fill_patient_form_by_dic($smarty, $dao);
	
		$smarty->assign('patient',$patient);
		$smarty->assign('readonly',"readonly='readonly'");
		$smarty->assign('disabled',"disabled='disabled'");
		$smarty->assign('edit',false);
		$smarty->assign('class_req_input',"class='read_only_input'");
		$smarty->assign('class',"class='read_only_input'");

		$smarty->display('templates/edit_patient.tpl');

	}elseif ($entity == "investigation"){

		if($_REQUEST["id"]){
			$id = (int) $_REQUEST["id"];
			//echo "<h1>Старое иссл</h1>";
		}else{
			//echo "<h1>Новое иссл</h1>";

		}



		$investigationParsed = $dao->parse_form_to_investigation($_REQUEST);
		//var_dump($investigationParsed);


		$insert_id = $dao->save_investigation($investigationParsed);

		//echo "<p>insert_id=$insert_id <p>";
		$investigation =$dao->getInvestigation($insert_id);
		//var_dump($investigation);

		fill_investigation_form_by_dic($smarty, $dao);
		
		$smarty->assign('investigation', $investigation);
		$smarty->assign('readonly',"readonly='readonly'");
		$smarty->assign('disabled',"disabled='disabled'");
		$smarty->assign('edit',false);
		$smarty->assign('class_req_input',"class='read_only_input'");
		$smarty->assign('class',"class='read_only_input'");
		$smarty->display('templates/edit_investigation.tpl');
		
	}else{
		exit("error entity");
	}


}else{
	exit ("Error!");
}

?>