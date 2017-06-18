<?php
//session_start();

include_once 'includes/config.php';
include_once 'includes/class_entity.php';
include_once 'includes/class_patient.php';
include_once 'includes/class_investigation.php';

class Dao{

	private 	$pdo;
	private 	$user;


	function __construct(){
		$this->connect();
		//$this->user = $_SESSION["user"]['username_email'];
		$this->user = "test_user";
	}

	function __destruct(){
		//$this->pdo = null;
	}

	public function connect(){
		if($this->pdo == null){
			$connect_string = sprintf('mysql:host=%s;dbname=%s', HOST, DB_NAME);
			$this->pdo = new PDO($connect_string, DB_USER, DB_PASS,	array(PDO::ATTR_PERSISTENT => true));
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->query("SET NAMES 'utf8'");
				
		}
	}
	
	public function getDicValues($dic_name){
		$results = array();
		$query =  "SELECT * FROM " . DB_PREFIX . $dic_name;
		try {
			$stmt = $this->pdo->query($query);
			foreach($stmt as $row) {
				$results[] = new Dictionary($row['id'], $row['name']);
			}
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $results;
	}

	public function addDicValue($dic_name, $value){
		$results = array();

		$query =  sprintf("INSERT INTO %s (id, name) VALUE(null, '%s') ", DB_PREFIX . $dic_name, $value);
		//echo "1:" . $query . "\n<br>";
		try {
			$result = $this->pdo->exec($query);


			$dic = new Dictionary($this->pdo->lastInsertId(), $value);
			//echo $query . "\n<br>";
		} catch(PDOException $ex) {
			//echo "Ошибка:" . $ex->getMessage();
			return new Dictionary(0, "Такой вариант уже есть");
		}
		return $dic;
	}

	public function getPatients(){
		$results = array();
		$query =  "SELECT
				  kras_patient.id,
				  kras_patient.last_name,
				  kras_patient.first_name,
				  kras_patient.patronymic_name,
				  kras_sex.name as sex,
				  kras_patient.date_birth,
				  kras_patient.year_birth,
				  kras_patient.hospital,
				  kras_patient.doctor,
				  DATE_FORMAT(kras_patient.insert_date,'%d/%m/%y') as insert_date
				  FROM
				  kras_patient 
				  left JOIN kras_sex ON (kras_patient.sex_id = kras_sex.id)";
		try {
			$stmt = $this->pdo->query($query);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if(count($results) == 0){
			return null;
		}
		return $results;
	}

	public function getPatient($id){
		$row = array();
		$query =  "SELECT
					  p.id,
					  p.last_name,
					  p.first_name,
					  p.patronymic_name,
					  p.sex_id,
					  s.name as sex,
					  p.date_birth,
					  p.year_birth,
					  p.weight_kg,
					  p.height_sm,
					  p.prof_or_other_hazards_yes_no_id,
					  yn1.name as prof_or_other_hazards_yes_no,
					  p.prof_or_other_hazards_discr,
					  p.nationality_id,
					  n.name as nationality,
					  p.smoke_yes_no_id,
					  yn2.name as smoke_yes_no,
					  p.smoke_discr,
					  p.hospital,
					  p.doctor,
					  p.comments,
					  p.user,
					  p.insert_date
					FROM
					  kras_patient p
					  INNER JOIN kras_sex s ON (p.sex_id = s.id)
					  INNER JOIN kras_yes_no yn1 ON (p.prof_or_other_hazards_yes_no_id = yn1.id)
					  INNER JOIN kras_yes_no yn2 ON (p.smoke_yes_no_id = yn2.id)
					  INNER JOIN kras_nationality n ON (p.nationality_id = n.id)
					  WHERE p.id = :id";
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			//$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}

		if(count($row) == 0){
			return null;
		}

		$patient = new Patient();
		$patient->id=$row[0]['id'];
		$patient->last_name=$row[0]['last_name'];
		$patient->first_name=$row[0]['first_name'];
		$patient->patronymic_name=$row[0]['patronymic_name'];
		$patient->sex_id=$row[0]['sex_id'];
		$patient->sex=$row[0]['sex'];
		$patient->setDateFromSqlDate($row[0]['date_birth']);
		$patient->year_birth=$row[0]['year_birth'];
		$patient->weight_kg=$row[0]['weight_kg'];
		$patient->height_sm=$row[0]['height_sm'];
		$patient->prof_or_other_hazards_yes_no_id=$row[0]['prof_or_other_hazards_yes_no_id'];
		$patient->prof_or_other_hazards_yes_no=$row[0]['prof_or_other_hazards_yes_no'];
		$patient->prof_or_other_hazards_discr=$row[0]['prof_or_other_hazards_discr'];
		$patient->nationality_id=$row[0]['nationality_id'];
		$patient->nationality=$row[0]['nationality'];
		$patient->smoke_yes_no_id=$row[0]['smoke_yes_no_id'];
		$patient->smoke_yes_no=$row[0]['smoke_yes_no'];
		$patient->smoke_discr=$row[0]['smoke_discr'];
		$patient->hospital=$row[0]['hospital'];
		$patient->doctor=$row[0]['doctor'];
		$patient->comments=$row[0]['comments'];
		$patient->user=$row[0]['user'];
		$patient->insert_date=$row[0]['insert_date'];


		return $patient;
	}

	public function getInvestigation($id){
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
				  `status_gene_kras3_id`,
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
				   WHERE i.id = :id";

		return $this->getInvestigationWithQuery($query, $id);

	}

	public function getAllData(){
		$results = array();
		$query =  "SELECT 
  kras_patient.id,
  kras_patient.last_name,
  kras_patient.first_name,
  kras_patient.patronymic_name,
  kras_patient.sex_id,
  kras_patient.date_birth,
  kras_patient.year_birth,
  kras_patient.weight_kg,
  kras_patient.height_sm,
  kras_patient.prof_or_other_hazards_yes_no_id,
  kras_patient.prof_or_other_hazards_discr,
  kras_patient.nationality_id,
  kras_patient.smoke_yes_no_id,
  kras_patient.smoke_discr,
  kras_patient.hospital,
  kras_patient.doctor,
  kras_patient.comments,
  kras_investigation.id,
  kras_investigation.tumor_another_existence_yes_no_id,
  kras_investigation.tumor_another_existence_discr,
  kras_investigation.diagnosis,
  kras_investigation.intestinum_crassum_part_id,
  kras_investigation.colon_part_id,
  kras_investigation.rectum_part_id,
  kras_investigation.treatment_discr,
  kras_investigation.status_gene_kras_id,
  kras_investigation.status_gene_kras3_id,
  kras_investigation.status_gene_kras4_id,
  kras_investigation.status_gene_nras2_id,
  kras_investigation.status_gene_nras3_id,
  kras_investigation.status_gene_nras4_id,
  kras_investigation.date_invest,
  kras_investigation.depth_of_invasion_id,
  kras_investigation.stage_id,
  kras_investigation.metastasis_regional_lymph_nodes_yes_no_id,
  kras_investigation.metastasis_regional_lymph_nodes_discr,
  kras_investigation.tumor_histological_type_id,
  kras_investigation.tumor_differentiation_degree_id,
  kras_investigation.block,
  kras_investigation.comments

FROM
  kras_patient
  LEFT OUTER JOIN kras_investigation ON (kras_patient.id = kras_investigation.patient_id)";
		try {
			$stmt = $this->pdo->query($query);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if(count($results) == 0){
			return null;
		}
		return $results;
		
	}
	
	public function getInvestigationByPatientId($patient_id){
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
				  `status_gene_kras3_id`,
				  `status_gene_kras4_id`,
				  `status_gene_nras2_id`,
				  `status_gene_nras3_id`,
				  `status_gene_nras4_id`,
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
				   WHERE i.patient_id = :id";
			
		return $this->getInvestigationWithQuery($query, $patient_id);
	}

	public function getInvestigationWithQuery($query, $id){
		$row = array();
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			//$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if(count($row) == 0){
			return null;
		}
		$investigation = new Investigation();
		$investigation->id=$row[0]['id'];
		$investigation->patient_id=$row[0]['patient_id'];
		$investigation->tumor_another_existence_yes_no_id=$row[0]['tumor_another_existence_yes_no_id'];
		$investigation->tumor_another_existence_discr=$row[0]['tumor_another_existence_discr'];
		$investigation->diagnosis=$row[0]['diagnosis'];
		$investigation->intestinum_crassum_part_id=$row[0]['intestinum_crassum_part_id'];
		$investigation->colon_part_id=$row[0]['colon_part_id'];
		$investigation->rectum_part_id=$row[0]['rectum_part_id'];
		$investigation->treatment_discr=$row[0]['treatment_discr'];
		$investigation->status_gene_kras_id=$row[0]['status_gene_kras_id'];
		$investigation->status_gene_kras3_id=$row[0]['status_gene_kras3_id'];
		$investigation->status_gene_kras4_id=$row[0]['status_gene_kras4_id'];
		$investigation->status_gene_nras2_id=$row[0]['status_gene_nras2_id'];
		$investigation->status_gene_nras3_id=$row[0]['status_gene_nras3_id'];
		$investigation->status_gene_nras4_id=$row[0]['status_gene_nras4_id'];
		$investigation->setDateFromSqlDate($row[0]['date_invest']);
		$investigation->depth_of_invasion_id=$row[0]['depth_of_invasion_id'];
		$investigation->stage_id=$row[0]['stage_id'];
		$investigation->metastasis_regional_lymph_nodes_yes_no_id=$row[0]['metastasis_regional_lymph_nodes_yes_no_id'];
		$investigation->metastasis_regional_lymph_nodes_discr=$row[0]['metastasis_regional_lymph_nodes_discr'];
		$investigation->tumor_histological_type_id=$row[0]['tumor_histological_type_id'];
		$investigation->tumor_differentiation_degree_id=$row[0]['tumor_differentiation_degree_id'];
		$investigation->block=$row[0]['block'];
		$investigation->comments=$row[0]['comments'];
		return $investigation;
	}

	private  function getNullIfStringEmpty($str){
		$str = strval($str);
		//echo strlen ($str) . "<br>";
		if(strlen ($str) == 0){
			return 'null';
		}
		return 	"'" . $str . "'";
	}

	private  function getNullForObjectFieldIfStringEmpty($val){
		if(!isset($val)){
			return null;
		}
		if($val == null){
			return null;
		}
		//$val = trim(mysql_real_escape_string($val));
		$val = trim($val);
		$val = strval($val);
		//echo strlen ($str) . "<br>";
		if(strlen ($val) == 0){
			return null;
		}
		return 	$val;
	}

	public function parse_form_to_patient($request){
		$patient = new Patient();
		$patient->id= $this->getNullForObjectFieldIfStringEmpty(isset($request['id'])==true ? $request['id'] : null);
		$patient->last_name= $this->getNullForObjectFieldIfStringEmpty($request['last_name']);
		$patient->first_name= $this->getNullForObjectFieldIfStringEmpty($request['first_name']);
		$patient->patronymic_name= $this->getNullForObjectFieldIfStringEmpty($request['patronymic_name']);
		$patient->sex_id=intval($request['sex_id']);
		$patient->setDateFromFormatDate($request['date_birth']);

		$db = $patient->get_date_birth();
		if($db != null){
			$patient->year_birth = intval($db["year"]);
		}elseif ($request['year_birth'] != null){
			$patient->year_birth = intval($request['year_birth']);
		}

		$patient->weight_kg= $this->getNullForObjectFieldIfStringEmpty($request['weight_kg']);
		$patient->height_sm= $this->getNullForObjectFieldIfStringEmpty($request['height_sm']);
		$patient->prof_or_other_hazards_yes_no_id= intval($request['prof_or_other_hazards_yes_no_id']);
		$patient->prof_or_other_hazards_discr= $this->getNullForObjectFieldIfStringEmpty($request['prof_or_other_hazards_discr']);
		$patient->nationality_id= intval($request['nationality_id']);
		$patient->smoke_yes_no_id=intval($request['smoke_yes_no_id']);
		$patient->smoke_discr= $this->getNullForObjectFieldIfStringEmpty($request['smoke_discr']);
		$patient->hospital= $this->getNullForObjectFieldIfStringEmpty($request['hospital']);
		$patient->doctor= $this->getNullForObjectFieldIfStringEmpty($request['doctor']);
		$patient->comments= $this->getNullForObjectFieldIfStringEmpty($request['comments']);
		$patient->user=$this->user;
		return $patient;

	}

	public function parse_form_to_investigation($request){
		$investigation = new Investigation();
		$investigation->id= $this->getNullForObjectFieldIfStringEmpty(isset($request['id'])==true ? $request['id'] : null);
		$investigation->patient_id= intval($request['patient_id']);
		$investigation->tumor_another_existence_yes_no_id= intval($request['tumor_another_existence_yes_no_id']);
		$investigation->tumor_another_existence_discr= $this->getNullForObjectFieldIfStringEmpty($request['tumor_another_existence_discr']);
		$investigation->diagnosis= $this->getNullForObjectFieldIfStringEmpty($request['diagnosis']);
		$investigation->intestinum_crassum_part_id= intval($request['intestinum_crassum_part_id']);
		$investigation->colon_part_id= intval($request['colon_part_id']);
		$investigation->rectum_part_id= intval($request['rectum_part_id']);
		$investigation->treatment_discr= $this->getNullForObjectFieldIfStringEmpty($request['treatment_discr']);
		$investigation->status_gene_kras_id= intval($request['status_gene_kras_id']);
		$investigation->status_gene_kras3_id= intval($request['status_gene_kras3_id']);
		$investigation->status_gene_kras4_id= intval($request['status_gene_kras4_id']);
		$investigation->status_gene_nras2_id= intval($request['status_gene_nras2_id']);
		$investigation->status_gene_nras3_id= intval($request['status_gene_nras3_id']);
		$investigation->status_gene_nras4_id= intval($request['status_gene_nras4_id']);
		$investigation->setDateFromFormatDate($request['date_invest']);
		$investigation->depth_of_invasion_id= intval($request['depth_of_invasion_id']);
		$investigation->stage_id= intval($request['stage_id']);
		$investigation->metastasis_regional_lymph_nodes_yes_no_id= intval($request['metastasis_regional_lymph_nodes_yes_no_id']);
		$investigation->metastasis_regional_lymph_nodes_discr= $this->getNullForObjectFieldIfStringEmpty($request['metastasis_regional_lymph_nodes_discr']);
		$investigation->tumor_histological_type_id= intval($request['tumor_histological_type_id']);
		$investigation->tumor_differentiation_degree_id= intval($request['tumor_differentiation_degree_id']);
		$investigation->block= $this->getNullForObjectFieldIfStringEmpty($request['block']);
		$investigation->comments= $this->getNullForObjectFieldIfStringEmpty($request['comments']);
		$investigation->user=$this->user;;
		return $investigation;
	}

	public function save_patient($patient){
		if($patient->id == null){
			return $this->insert_patient($patient);
		}else{
			return $this->update_patient($patient);
		}

	}

	public function save_investigation($investigation){
		if($investigation->id == null){
			return $this->insert_investigation($investigation);
		}else{
			return $this->update_investigation($investigation);
		}

	}

	public function getUserByLogin($username){
		$row = array();
		$query = "SELECT * FROM kras_user WHERE username_email = :username_email";


		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->bindValue(':username_email', $username, PDO::PARAM_STR);

			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if($stmt->rowCount() == 0){
			return null;
		}

		$object = new User();

		$object->id = $row[0]['id'];
		$object->username_email = $row[0]['username_email'];
		$object->password = $row[0]['password'];
		$object->last_name = $row[0]['last_name'];
		$object->first_name = $row[0]['first_name'];
		$object->patronymic_name = $row[0]['patronymic_name'];
		$object->sex_id = $row[0]['sex_id'];
		$object->date_birth = $row[0]['date_birth'];
		$object->project = $row[0]['project'];
		$object->comments = $row[0]['comments'];




		return $object;
	}

	public function is_user_exist($username, $pass=null){
		$row = array();
		$query = "SELECT * FROM kras_user WHERE username_email = :username_email AND active=1";
		if($pass !=null){
			//echo "<h1>asdasd</h1>";
			$query .= " AND password = :password";
		}

		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->bindValue(':username_email', $username, PDO::PARAM_STR);
			if($pass !=null){
				$stmt->bindValue(':password', $pass, PDO::PARAM_STR);
			}

			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if($stmt->rowCount() == 0){
			return false;
		}
		return true;
	}

	public function activate_user($user_name){
		$query = "UPDATE
			  `kras_user`  
			SET 
			  `active` = 1
			  WHERE 
			  `username_email` = :username_email
			;";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':username_email', $user_name, PDO::PARAM_STR);

		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//echo $affected_rows.' строка добавлена';
			if($affected_rows > 0){
				return true;
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
			

		return false;

	}

	public function insert_user($object){

		$query = "INSERT INTO
		  `kras_user`
		(
		  `id`,
		  `username_email`,
		   `password`,
		  `last_name`,
		  `first_name`,
		  `patronymic_name`,
		  `sex_id`,
		  `date_birth`,
		  `project`,
		  `comments`
		  ) 
		VALUE (
		  null,
		  :username_email,
		  :password,
		  :last_name,
		  :first_name,
		  :patronymic_name,
		  :sex_id,
		  :date_birth,
		  :project,
		  :comments
		);";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':username_email', $object->username_email, PDO::PARAM_STR);
		$stmt->bindValue(':password', $object->password, PDO::PARAM_STR);
		$stmt->bindValue(':last_name', $object->last_name, PDO::PARAM_STR);
		$stmt->bindValue(':first_name', $object->first_name, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name', $object->patronymic_name, PDO::PARAM_STR);
		$stmt->bindValue(':sex_id', $object->sex_id, PDO::PARAM_STR);
		$stmt->bindValue(':date_birth', $object->date_birth, PDO::PARAM_STR);
		$stmt->bindValue(':project', $object->project, PDO::PARAM_STR);
		$stmt->bindValue(':comments', $object->comments, PDO::PARAM_STR);


		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				die("Ошибка, объект не сохранен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
			

		return $this->pdo->lastInsertId();

	}
	
public function insert_user_visit($object){

		$query = "INSERT INTO
		  `kras_user_visit`
		(
		  `id`,
		  `username`
		   		  ) 
		VALUE (
		  null,
		  :username
		);";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':username', $object->username_email, PDO::PARAM_STR);
		

		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				die("Ошибка, объект не сохранен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
			

		return $this->pdo->lastInsertId();

	}

	public function insert_patient($patient){



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
		$stmt->bindValue(':last_name', $patient->last_name, PDO::PARAM_STR);
		$stmt->bindValue(':first_name', $patient->first_name, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name', $patient->patronymic_name, PDO::PARAM_STR);
		$stmt->bindValue(':sex_id', $patient->sex_id, PDO::PARAM_STR);
		$stmt->bindValue(':date_birth', $patient->date_birth_sql, PDO::PARAM_STR);
		$stmt->bindValue(':year_birth', $patient->year_birth, PDO::PARAM_STR);
		$stmt->bindValue(':weight_kg', $patient->weight_kg, PDO::PARAM_STR);
		$stmt->bindValue(':height_sm', $patient->height_sm, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_yes_no_id', $patient->prof_or_other_hazards_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_discr', $patient->prof_or_other_hazards_discr, PDO::PARAM_STR);
		$stmt->bindValue(':nationality_id', $patient->nationality_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_yes_no_id', $patient->smoke_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_discr', $patient->smoke_discr, PDO::PARAM_STR);
		$stmt->bindValue(':hospital', $patient->hospital, PDO::PARAM_STR);
		$stmt->bindValue(':doctor', $patient->doctor, PDO::PARAM_STR);
		$stmt->bindValue(':comments', $patient->comments, PDO::PARAM_STR);
		$stmt->bindValue(':user', $patient->user, PDO::PARAM_STR);




		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				die("Ошибка, объект не сохранен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
			

		return $this->pdo->lastInsertId();

	}

	public function insert_investigation($investigation){



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
				  `status_gene_kras3_id`,
				  `status_gene_kras4_id`,
				  `status_gene_nras2_id`,
				  `status_gene_nras3_id`,
				  `status_gene_nras4_id`,
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
				  :status_gene_kras3_id,
				  :status_gene_kras4_id,
				  :status_gene_nras2_id,
				  :status_gene_nras3_id,
				  :status_gene_nras4_id,
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
		$stmt->bindValue(':status_gene_kras3_id', $investigation->status_gene_kras3_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_kras4_id', $investigation->status_gene_kras4_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_nras2_id', $investigation->status_gene_nras2_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_nras3_id', $investigation->status_gene_nras3_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_nras4_id', $investigation->status_gene_nras4_id, PDO::PARAM_INT);
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




		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//echo $affected_rows.' исследований добавлено';
			//			if($affected_rows < 1){
			//				die("Ошибка, объект не сохранен");
			//			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
			

		return $this->pdo->lastInsertId();

	}

	public function update_patient($patient){
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
		$stmt->bindValue(':id', $patient->id, PDO::PARAM_INT);
		$stmt->bindValue(':last_name', $patient->last_name, PDO::PARAM_STR);
		$stmt->bindValue(':first_name', $patient->first_name, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name', $patient->patronymic_name, PDO::PARAM_STR);
		$stmt->bindValue(':sex_id', $patient->sex_id, PDO::PARAM_STR);
		$stmt->bindValue(':date_birth', $patient->date_birth_sql, PDO::PARAM_STR);
		$stmt->bindValue(':year_birth', $patient->year_birth, PDO::PARAM_STR);
		$stmt->bindValue(':weight_kg', $patient->weight_kg, PDO::PARAM_STR);
		$stmt->bindValue(':height_sm', $patient->height_sm, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_yes_no_id', $patient->prof_or_other_hazards_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':prof_or_other_hazards_discr', $patient->prof_or_other_hazards_discr, PDO::PARAM_STR);
		$stmt->bindValue(':nationality_id', $patient->nationality_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_yes_no_id', $patient->smoke_yes_no_id, PDO::PARAM_STR);
		$stmt->bindValue(':smoke_discr', $patient->smoke_discr, PDO::PARAM_STR);
		$stmt->bindValue(':hospital', $patient->hospital, PDO::PARAM_STR);
		$stmt->bindValue(':doctor', $patient->doctor, PDO::PARAM_STR);
		$stmt->bindValue(':comments', $patient->comments, PDO::PARAM_STR);
		$stmt->bindValue(':user', $patient->user, PDO::PARAM_STR);




		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				//die("Ошибка, объект не обновлен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
			

		return $patient->id;

	}

	public function update_investigation($investigation){
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
				  `status_gene_kras3_id` = :status_gene_kras3_id,
				  `status_gene_kras4_id` = :status_gene_kras4_id,
				  `status_gene_nras2_id` = :status_gene_nras2_id,
				  `status_gene_nras3_id` = :status_gene_nras3_id,
				  `status_gene_nras4_id` = :status_gene_nras4_id,
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
				  `id` = :id
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
		$stmt->bindValue(':status_gene_kras3_id', $investigation->status_gene_kras3_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_kras4_id', $investigation->status_gene_kras4_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_nras2_id', $investigation->status_gene_nras2_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_nras3_id', $investigation->status_gene_nras3_id, PDO::PARAM_INT);
		$stmt->bindValue(':status_gene_nras4_id', $investigation->status_gene_nras4_id, PDO::PARAM_INT);
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




		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				//die("Ошибка, объект не обновлен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
			

		return $investigation->id;

	}

	public  function getYearDateFromRussianString($dateRus){
		if(strlen($dateRus) == 0){
			return "null";
		}
		$parts = explode('/', $dateRus);
		return  "'$parts[2]'";
	}

public function getUniqueDoctorNames(){
		return $this->getUniqueNames("doctor");
}
public function getUniqueHospitalNames(){
		return $this->getUniqueNames("hospital");
}
public function getUniqueNames($column){
		$results = array();
		$arrayReturn = array();
		$query =  sprintf('SELECT DISTINCT(%1$s) as name from kras_patient WHERE %1$s is not null ORDER BY %1$s', $column);
		try {
			$stmt = $this->pdo->query($query);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if(count($results) == 0){
			return "";
		}
		foreach ($results as $key => $value) {
			$arrayReturn[]= $value['name'];
		}
		
		return $arrayReturn;
	}

}

?>