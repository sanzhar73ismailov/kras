<?php

class Patient extends Entity{
	public $id;
	public	$last_name;
	public	$first_name;
	public	$patronymic_name;
	public	$sex_id;
	public	$sex;
	private $date_birth;
	public $date_birth_sql;
	public $date_birth_string;
	public	$year_birth;
	public	$weight_kg;
	public	$height_sm;
	public	$prof_or_other_hazards_yes_no_id;
	public	$prof_or_other_hazards_yes_no;
	public	$prof_or_other_hazards_discr;
	public	$nationality_id;
	public	$nationality;
	public	$smoke_yes_no_id;
	public	$smoke_yes_no;
	public	$smoke_discr;
	public	$hospital;
	public	$doctor;
	public	$comments;
	public	$user;
	public	$insert_date;




	public  function set_date_birth($date_birth){
		$this->date_birth = $date_birth;
		$this->date_birth_sql = parent::getSqlDateFromDate($date_birth);
		$this->date_birth_string=parent::getFormatStringFromDate($date_birth);
	}

	public  function get_date_birth(){
		return $this->date_birth;
	}


	public  function setDateFromSqlDate($input_val){
		$this->set_date_birth(parent::getDateFromSqlDate($input_val));
	}

	public  function setDateFromFormatDate($input_val){
		$this->set_date_birth(parent::getDateFromFormatDate($input_val));
	}

	public  function getYearDateFromRussianString($dateRus){
		if(strlen($dateRus) == 0){
			return "null";
		}
		$parts = explode('/', $dateRus);
		return  "'$parts[2]'";
	}

}

?>