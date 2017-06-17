<?php
class Investigation extends Entity{

	public $id;
	public $patient_id;
	public $tumor_another_existence_yes_no_id;
	public $tumor_another_existence_discr;
	public $diagnosis;
	public $intestinum_crassum_part_id;
	public $colon_part_id;
	public $rectum_part_id;
	public $treatment_discr;
	public $status_gene_kras_id;
	public $status_gene_kras3_id;
	public $status_gene_kras4_id;
	public $status_gene_nras2_id;
	public $status_gene_nras3_id;
	public $status_gene_nras4_id;
	private $date_invest;
	public $date_invest_sql;
	public $date_invest_string;
	public $depth_of_invasion_id;
	public $stage_id;
	public $metastasis_regional_lymph_nodes_yes_no_id;
	public $metastasis_regional_lymph_nodes_discr;
	public $tumor_histological_type_id;
	public $tumor_differentiation_degree_id;
	public $block;
	public	$comments;
	public	$user;
	public	$insert_date;



	public function set_date_invest($date_invest){
		$this->date_invest = $date_invest;
		$this->date_invest_sql = parent::getSqlDateFromDate($date_invest);
		$this->date_invest_string=parent::getFormatStringFromDate($date_invest);
	}

	public  function get_date_invest(){
		return $this->date_invest;
	}


	public  function setDateFromSqlDate($input_val){
		$this->set_date_invest(parent::getDateFromSqlDate($input_val));
	}

	public  function setDateFromFormatDate($input_val){
		$this->set_date_invest(parent::getDateFromFormatDate($input_val));
	}


}

