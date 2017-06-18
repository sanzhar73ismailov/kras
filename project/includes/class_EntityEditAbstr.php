<?php

class EntityEditFabrica{
	public static function createEntityEdit($entity){
		global $smarty;
		global $dao;
		$entityEditObj = null;
		if($entity == "patient"){
			$entityEditObj = new PatientEdit();
		} elseif ($entity == "investigation"){
			$entityEditObj = new InvestigationEdit();
		}else{
			exit("UnsupportedOperationException");
		}
	}

}

abstract class EntityEdit{
	protected  $do = 'view';
	protected  $id = 0;
	protected  $smarty;

	public function __construct($do, $id, $dao, $smarty){
		$this->do = $do;
		$this->id = $id;
		$this->dao = $dao;
		$this->smarty = $smarty;
	}

	public function go(){
		switch ($this->do){
			case "view":
				fill_entity_form_by_dic();
				$this->viewAction();
				$this->viewWork();
				break;
			case "edit":
				fill_entity_form_by_dic();
				$this->editAction();
				$this->editWork();
				break;
			case "save":
				$this->saveAction();
				break;
			default:
				exit("UnsupportedOperationException");
		}
	}

	private function editWork(){
		$this->smarty;
		$this->smarty->assign('readonly',"");
		$this->smarty->assign('disabled',"");
		$this->smarty->assign('class',"");

		$this->smarty->assign('class_req_input',"class='req_input'");
		$this->smarty->assign('edit',true);
		//$this->fill_entity_form_by_dic();
	}
	private function viewWork(){
		$this->smarty->assign('readonly',"readonly='readonly'");
		$this->smarty->assign('disabled',"disabled='disabled'");
		$this->smarty->assign('edit',false);
		$this->smarty->assign('class_req_input',"class='read_only_input'");
		$this->smarty->assign('class',"class='read_only_input'");
		$this->fill_entity_form_by_dic();
	}

	public abstract function viewAction();
	public abstract function editAction();
	public abstract function saveAction();

	public abstract function fill_entity_form_by_dic();

}

class PatientEdit extends EntityEdit{

	public function __construct($do, $id, $dao){
		parent::__construct($do, $id, $dao);

		$patient = null;
		$patient =$dao->getPatient($id);
		$investigation =$dao->getInvestigationByPatientId($id);
		$this->smarty->assign('investigation_exist', $investigation != null ? true : false);
		$this->smarty->assign('patient_exist', $patient != null ? true : false);
		$this->smarty->assign('object',$patient == null ? new Patient(): $patient);
		$this->smarty->display('templates/edit_patient.tpl');
	}
	public  function viewAction(){
		$this->smartyArray['title'] = "Просмотр пациента";
		open_tpl_to_view_patient($id, $smarty, $dao);
	}
	public  function editAction(){
		$this->smarty->assign('title', "Редактирование пациента");
		//open_tpl_to_view_patient($id, $smarty, $dao, $do="edit");
	}
	public  function saveAction(){
		$patientParsed = $dao->parse_form_to_patient($_REQUEST);
		$insert_id = $dao->save_patient($patientParsed);
		$this->smarty->assign('title', "Просмотр пациента");
		//open_tpl_to_view_patient($insert_id, $smarty, $dao);
	}
	public function fill_entity_form_by_dic(){
		$yes_no_vars = $dao->getDicValues("yes_no");
		$this->smarty->assign('sexvals', $dao->getDicValues("sex"));
		$this->smarty->assign('yesnovals', $dao->getDicValues("yes_no"));
		$this->smarty->assign('nationalityvals', $dao->getDicValues("nationality"));


	}
}

class InvestigationEdit extends EntityEdit{
	public function __construct($do, $id, $dao){
		parent::__construct($do, $id, $dao);

		$patient = $dao->getPatient($patient_id);
		//var_dump($patient);

		if($patient == null){
			exit("Исследование добавляется только имеющемуся пациенту");
		}

		$investigation = null;
		$investigation =$dao->getInvestigationByPatientId($patient_id);
		//echo "patient_id=$patient_id<p>";

		//var_dump($dao->getPatient((int) $_REQUEST["patient_id"]));
		if($investigation == null){
			$do = 'edit';
			$investigation = new Investigation();
			$investigation->patient_id = $patient_id;
		}
		$this->smarty->assign('object',$investigation);
		$this->smarty->assign('patient',$patient);
		$this->smarty->assign('patient_exist', true);
		$this->smarty->display('templates/edit_investigation.tpl');
	}
	public  function viewAction(){
		// echo "<p>VIEWWWWWWWWWWWWW" . $_REQUEST['patient_id'] . "<p>";
		$this->smarty->assign('title',"Просмотр клин данных");
		//open_tpl_to_view_investigation((int) $_REQUEST["patient_id"], $this->smarty, $dao);
	}
	public  function editAction(){
		$this->smarty->assign('title',"Редактирование клин. данных");
		//open_tpl_to_view_investigation((int) $_REQUEST["patient_id"], $this->smarty, $dao, $do="edit");
	}
	public  function saveAction(){
		$investigationParsed = $dao->parse_form_to_investigation($_REQUEST);

		//var_dump($investigationParsed);
		$insert_id = $dao->save_investigation($investigationParsed);
		$this->smarty->assign('title',"Просмотр клин данных");
		//echo "<p>insert_id=$insert_id <p>";
		//open_tpl_to_view_investigation($investigationParsed->patient_id, $this->smarty, $dao);
	}

	public function fill_entity_form_by_dic(){
		$yes_no_vars = $dao->getDicValues("yes_no");
		$this->smarty->assign('yesnovals',$yes_no_vars);
		$this->smarty->assign('intestinum_crassum_part_vals',$dao->getDicValues("intestinum_crassum_part"));
		$this->smarty->assign('colon_part_vals',$dao->getDicValues("colon_part"));
		$this->smarty->assign('rectum_part_vals',$dao->getDicValues("rectum_part"));
		$this->smarty->assign('status_gene_kras_vals',$dao->getDicValues("status_gene_kras"));
		$this->smarty->assign('depth_of_invasion_vals',$dao->getDicValues("depth_of_invasion"));
		$this->smarty->assign('stage_vals',$dao->getDicValues("stage"));
		$this->smarty->assign('tumor_histological_type_vals',$dao->getDicValues("tumor_histological_type"));
		$this->smarty->assign('tumor_differentiation_degree_vals',$dao->getDicValues("tumor_differentiation_degree"));
	}
}

?>