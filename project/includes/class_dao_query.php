<?php
interface DaoQuery{



	public  function insertQuery();

	public  function updateQuery($by_column=null);

	public  function selectQueryAll($order=null);

	public  function selectQueryManyByCondition($condition, $order=null);

	public  function selectQueryOneById();

	public  function selectQueryNative($colums, $condition, $order);


}

class PatientQuery implements DaoQuery{
	private $pdo;
	private $object;

	public function __construct($pdo, $object){
		$this->pdo = $pdo;
		$this->object = $object;
	}

	public  function insertQuery(){
		$query = "INSERT INTO
				  `kras_patient`
				(
				  `last_name`,
				  `first_name`,
				  `patronymic_name`,
				  `sex_id`,
				  `date_birth`,
				  `year_birth`,
				  `weight_kg`,
				  `height_sm`,
				  `prof_or_other_hazards_yes_no_id`,
				  `prof_or_other_hazards_discr`,
				  `nationality_id`,
				  `smoke_yes_no_id`,
				  `smoke_discr`,
				  `hospital`,
				  `doctor`,
				  `comments`,
				  `user`
				) 
				VALUE (
				:last_name,
				:first_name,
				:patronymic_name,
				:sex_id,
				:date_birth,
				:year_birth,
				:weight_kg,
				:height_sm,
				:prof_or_other_hazards_yes_no_id,
				:prof_or_other_hazards_discr,
				:nationality_id,
				:smoke_yes_no_id,
				:smoke_discr,
				:hospital,
				:doctor,
				:comments,
				:user)";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':last_name', $object->last_name, PDO::PARAM_STR);
		$stmt->bindValue(':first_name', $object->first_name, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name', $object->patronymic_name, PDO::PARAM_STR);
		$stmt->bindValue(':sex_id', $object->sex_id, PDO::PARAM_STR);
		$stmt->bindValue(':date_birth', $object->date_birth_sql, PDO::PARAM_STR);
		$stmt->bindValue(':year_birth', $object->year_birth, PDO::PARAM_STR);
		$stmt->bindValue(':weight_kg', $object->weight_kg, PDO::PARAM_STR);
		$stmt->bindValue(':height_sm', $object->height_sm, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_yes_no_id', $object->prof_or_other_hazards_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_discr', $object->prof_or_other_hazards_discr, PDO::PARAM_STR);
		$stmt->bindValue(':nationality_id', $object->nationality_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_yes_no_id', $object->smoke_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_discr', $object->smoke_discr, PDO::PARAM_STR);
		$stmt->bindValue(':hospital', $object->hospital, PDO::PARAM_STR);
		$stmt->bindValue(':doctor', $object->doctor, PDO::PARAM_STR);
		$stmt->bindValue(':comments', $object->comments, PDO::PARAM_STR);
		$stmt->bindValue(':user', $object->user, PDO::PARAM_STR);
		return $stmt;
	}

	public  function updateQuery($by_column=null){
		$query = "UPDATE
				  `kras_patient`  
				SET 
				  `last_name` = :last_name,
				  `first_name` = :first_name,
				  `patronymic_name` = :patronymic_name,
				  `sex_id` = :sex_id,
				  `date_birth` = :date_birth,
				  `year_birth` = :year_birth,
				  `weight_kg` = :weight_kg,
				  `height_sm` = :height_sm,
				  `prof_or_other_hazards_yes_no_id` = :prof_or_other_hazards_yes_no_id,
				  `prof_or_other_hazards_discr` = :prof_or_other_hazards_discr,
				  `nationality_id` = :nationality_id,
				  `smoke_yes_no_id` = :smoke_yes_no_id,
				  `smoke_discr` = :smoke_discr,
				  `hospital` = :hospital,
				  `doctor` = :doctor,
				  `comments` = :comments,
				  `user` = :user
				 
				WHERE 
				  `id` = :id
				;";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $object->id, PDO::PARAM_INT);
		$stmt->bindValue(':last_name', $object->last_name, PDO::PARAM_STR);
		$stmt->bindValue(':first_name', $object->first_name, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name', $object->patronymic_name, PDO::PARAM_STR);
		$stmt->bindValue(':sex_id', $object->sex_id, PDO::PARAM_STR);
		$stmt->bindValue(':date_birth', $object->date_birth_sql, PDO::PARAM_STR);
		$stmt->bindValue(':year_birth', $object->year_birth, PDO::PARAM_STR);
		$stmt->bindValue(':weight_kg', $object->weight_kg, PDO::PARAM_STR);
		$stmt->bindValue(':height_sm', $object->height_sm, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_yes_no_id', $object->prof_or_other_hazards_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_discr', $object->prof_or_other_hazards_discr, PDO::PARAM_STR);
		$stmt->bindValue(':nationality_id', $object->nationality_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_yes_no_id', $object->smoke_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_discr', $object->smoke_discr, PDO::PARAM_STR);
		$stmt->bindValue(':hospital', $object->hospital, PDO::PARAM_STR);
		$stmt->bindValue(':doctor', $object->doctor, PDO::PARAM_STR);
		$stmt->bindValue(':comments', $object->comments, PDO::PARAM_STR);
		$stmt->bindValue(':user', $object->user, PDO::PARAM_STR);
		return $stmt;
	}

	public  function selectQueryAll($order=null){
		return selectQueryManyByCondition(null, $order);
	}

	public  function selectQueryManyByCondition($condition, $order){
		$query =  "SELECT
				  kras_patient.id as id,
				  kras_patient.last_name,
				  kras_patient.first_name,
				  kras_patient.patronymic_name,
				  kras_sex.name as sex,
				  kras_patient.date_birth,
				  kras_patient.year_birth,
				  kras_patient.hospital,
				  kras_patient.doctor
				  FROM
				  kras_patient 
				  left JOIN kras_sex ON (kras_patient.sex_id = kras_sex.id)
				  WHERE 1=1   
				  " . $condition == null ? "" : " AND ".$condition
		. $order == null ? " ORDER BY id" : (" ORDER BY " . $order)
		;
		try {
			$stmt = $this->pdo->query($query);
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $stmt;
	}

	public  function selectQueryOneById(){
		selectQueryManyByCondition($this->object->id);
	}

	public  function selectQueryNative($colums, $condition, $order){
		$query =  "SELECT
		$colums
				  FROM
				  kras_patient 
				  left JOIN kras_sex ON (kras_patient.sex_id = kras_sex.id)
				  WHERE 1=1   
				  " . $condition == null ? "" : " AND ".$condition
		. $order == null ? " ORDER BY id" : (" ORDER BY " . $order)
		;
		try {
			$stmt = $this->pdo->query($query);
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $stmt;
	}
}


class InvestigationQuery implements DaoQuery{
	private $pdo;
	private $object;

	public function __construct($pdo, $object){
		$this->pdo = $pdo;
		$this->object = $object;
	}

	public  function insertQuery(){

		$query = "INSERT INTO
				  `kras_investigation`
				(
				   `patient_id`,
				  `tumor_another_existence_yes_no_id`,
				  `tumor_another_existence_discr`,
				  `diagnosis`,
				  `intestinum_crassum_part_id`,
				  `colon_part_id`,
				  `rectum_part_id`,
				  `treatment_discr`,
				  `status_gene_kras_id`,
				  `date_invest`,
				  `depth_of_invasion_id`,
				  `stage_id`,
				  `metastasis_regional_lymph_nodes_yes_no_id`,
				  `metastasis_regional_lymph_nodes_discr`,
				  `tumor_histological_type_id`,
				  `tumor_differentiation_degree_id`,
				  `block`,
				  `comments`,
				  `user`
				) 
				VALUE (
				  :patient_id,
				  :tumor_another_existence_yes_no_id,
				  :tumor_another_existence_discr,
				  :diagnosis,
				  :intestinum_crassum_part_id,
				  :colon_part_id,
				  :rectum_part_id,
				  :treatment_discr,
				  :status_gene_kras_id,
				  :date_invest,
				  :depth_of_invasion_id,
				  :stage_id,
				  :metastasis_regional_lymph_nodes_yes_no_id,
				  :metastasis_regional_lymph_nodes_discr,
				  :tumor_histological_type_id,
				  :tumor_differentiation_degree_id,
				  :block,
				  :comments,
				  :user
				  
				)";

		$stmt = $this->pdo->prepare($query);

		$stmt->bindValue(':patient_id', $investigation->patient_id, PDO::PARAM_INT);
		$stmt->bindValue(':tumor_another_existence_yes_no_id', $investigation->tumor_another_existence_yes_no_id, PDO::PARAM_INT);
		$stmt->bindValue(':tumor_another_existence_discr', $investigation->tumor_another_existence_discr, PDO::PARAM_STR);
		$stmt->bindValue(':diagnosis', $investigation->diagnosis, PDO::PARAM_STR);
		$stmt->bindValue(':intestinum_crassum_part_id', $investigation->intestinum_crassum_part_id, PDO::PARAM_INT);
		$stmt->bindValue(':colon_part_id', $investigation->colon_part_id, PDO::PARAM_INT);
		$stmt->bindValue(':rectum_part_id', $investigation->rectum_part_id, PDO::PARAM_INT);
		$stmt->bindValue(':treatment_discr', $investigation->treatment_discr, PDO::PARAM_STR);
		$stmt->bindValue(':status_gene_kras_id', $investigation->status_gene_kras_id, PDO::PARAM_INT);
		$stmt->bindValue(':date_invest', $investigation->date_invest_sql, PDO::PARAM_STR);
		$stmt->bindValue(':depth_of_invasion_id', $investigation->depth_of_invasion_id, PDO::PARAM_INT);
		$stmt->bindValue(':stage_id', $investigation->stage_id, PDO::PARAM_INT);
		$stmt->bindValue(':metastasis_regional_lymph_nodes_yes_no_id', $investigation->metastasis_regional_lymph_nodes_yes_no_id, PDO::PARAM_INT);
		$stmt->bindValue(':metastasis_regional_lymph_nodes_discr', $investigation->metastasis_regional_lymph_nodes_discr, PDO::PARAM_STR);
		$stmt->bindValue(':tumor_histological_type_id', $investigation->tumor_histological_type_id, PDO::PARAM_INT);
		$stmt->bindValue(':tumor_differentiation_degree_id', $investigation->tumor_differentiation_degree_id, PDO::PARAM_INT);
		$stmt->bindValue(':block', $investigation->block, PDO::PARAM_STR);
		$stmt->bindValue(':comments', $investigation->comments, PDO::PARAM_STR);
		$stmt->bindValue(':user', $investigation->user, PDO::PARAM_STR);

		return $stmt;
	}

	public  function updateQuery($id, $by_column=null){
		$by_column = $by_column==null ? "id":$by_column;
		$query = "UPDATE
				  `kras_investigation`  
				SET 
				  `patient_id` = :patient_id,
				  `tumor_another_existence_yes_no_id` = :tumor_another_existence_yes_no_id,
				  `tumor_another_existence_discr` = :tumor_another_existence_discr,
				  `diagnosis` = :diagnosis,
				  `intestinum_crassum_part_id` = :intestinum_crassum_part_id,
				  `colon_part_id` = :colon_part_id,
				  `rectum_part_id` = :rectum_part_id,
				  `treatment_discr` = :treatment_discr,
				  `status_gene_kras_id` = :status_gene_kras_id,
				  `date_invest` = :date_invest,
				  `depth_of_invasion_id` = :depth_of_invasion_id,
				  `stage_id` = :stage_id,
				  `metastasis_regional_lymph_nodes_yes_no_id` = :metastasis_regional_lymph_nodes_yes_no_id,
				  `metastasis_regional_lymph_nodes_discr` = :metastasis_regional_lymph_nodes_discr,
				  `tumor_histological_type_id` = :tumor_histological_type_id,
				  `tumor_differentiation_degree_id` = :tumor_differentiation_degree_id,
				   `comments` = :comments,
				  `block` = :block,
				  `user` = :user
				 
				WHERE 
				$by_column = $id
				";
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':id', $investigation->id, PDO::PARAM_INT);
				$stmt->bindValue(':patient_id', $investigation->patient_id, PDO::PARAM_INT);
				$stmt->bindValue(':tumor_another_existence_yes_no_id', $investigation->tumor_another_existence_yes_no_id, PDO::PARAM_INT);
				$stmt->bindValue(':tumor_another_existence_discr', $investigation->tumor_another_existence_discr, PDO::PARAM_STR);
				$stmt->bindValue(':diagnosis', $investigation->diagnosis, PDO::PARAM_STR);
				$stmt->bindValue(':intestinum_crassum_part_id', $investigation->intestinum_crassum_part_id, PDO::PARAM_INT);
				$stmt->bindValue(':colon_part_id', $investigation->colon_part_id, PDO::PARAM_INT);
				$stmt->bindValue(':rectum_part_id', $investigation->rectum_part_id, PDO::PARAM_INT);
				$stmt->bindValue(':treatment_discr', $investigation->treatment_discr, PDO::PARAM_STR);
				$stmt->bindValue(':status_gene_kras_id', $investigation->status_gene_kras_id, PDO::PARAM_INT);
				$stmt->bindValue(':date_invest', $investigation->date_invest_sql, PDO::PARAM_STR);
				$stmt->bindValue(':depth_of_invasion_id', $investigation->depth_of_invasion_id, PDO::PARAM_INT);
				$stmt->bindValue(':stage_id', $investigation->stage_id, PDO::PARAM_INT);
				$stmt->bindValue(':metastasis_regional_lymph_nodes_yes_no_id', $investigation->metastasis_regional_lymph_nodes_yes_no_id, PDO::PARAM_INT);
				$stmt->bindValue(':metastasis_regional_lymph_nodes_discr', $investigation->metastasis_regional_lymph_nodes_discr, PDO::PARAM_STR);
				$stmt->bindValue(':tumor_histological_type_id', $investigation->tumor_histological_type_id, PDO::PARAM_INT);
				$stmt->bindValue(':tumor_differentiation_degree_id', $investigation->tumor_differentiation_degree_id, PDO::PARAM_INT);
				$stmt->bindValue(':comments', $investigation->comments, PDO::PARAM_STR);
				$stmt->bindValue(':block', $investigation->block, PDO::PARAM_STR);
				$stmt->bindValue(':user', $investigation->user, PDO::PARAM_STR);

				return $stmt;
	}

	public  function selectQuery($condition=null, $order){
		$query =  "SELECT
				  `id`,
				  `patient_id`,
				  `tumor_another_existence_yes_no_id`,
				  `tumor_another_existence_discr`,
				  `diagnosis`,
				  `intestinum_crassum_part_id`,
				  `colon_part_id`,
				  `rectum_part_id`,
				  `treatment_discr`,
				  `status_gene_kras_id`,
				  `date_invest`,
				  `depth_of_invasion_id`,
				  `stage_id`,
				  `metastasis_regional_lymph_nodes_yes_no_id`,
				  `metastasis_regional_lymph_nodes_discr`,
				  `tumor_histological_type_id`,
				  `tumor_differentiation_degree_id`,
				  `comments`,
				  `block`,
				  `user`,
				  `insert_date`
				FROM 
				  `kras_investigation` i
				  WHERE 1=1   
				  " . $condition == null ? "" : $condition
		. $order == null ? " ORDER BY id" : (" ORDER BY " . $order)
		;
		try {
			$stmt = $this->pdo->query($query);
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $stmt;
	}
}


