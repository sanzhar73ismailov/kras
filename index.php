<?php
session_start();



// exit("exit on index.php");

include_once 'includes/global.php';



$page = isset($_REQUEST['page'])== true ? $_REQUEST['page'] : null ;



$nav_obj = FabricaNavigate::createNavigate($page, $_SESSION);

$nav_obj->display();
//var_dump($nav_obj);

/*

if(!isset($_SESSION["authorized"]) || $_SESSION["authorized"] != 1){
	$page = "login";
	//header("Location: login.php");
    //exit;
}
//include_once 'includes/check_session.php';
$smarty->assign('message',"");


switch ($page){


	case 'contacts':
        
		$smarty->assign('title',"Контакты");
		$smarty->display('templates/contacts.tpl');
		break;

	case 'feedback':

		$smarty->assign('title',"Обратная связь");
		$smarty->display('templates/feedback.tpl');
		
		break;

	case 'register':
		
        $smarty->assign('result',0);
        $smarty->assign('title',"Регистрация");
		$smarty->display('templates/register.tpl');
		
		break;

	case 'activate_account':

		if($dao->activate_user($_REQUEST['username_email'])){
			$smarty->assign('result',true);
			$smarty->assign('message',"Уважаемый " . $_REQUEST['username_email'] . ", ваша учетная запись активирована!");
		}else{
			$smarty->assign('result',false);
			$smarty->assign('message',"Уважаемый " . $_REQUEST['username_email'] . ", ваша учетная запись не активирована, обратитесь а администратору");
		}
		$smarty->assign('title',"Активация учетной записи");

		$smarty->display('templates/general_message.tpl');
		break;

	case 'login':
		
		$smarty->assign('title',"Вход");
		$smarty->display('templates/login.tpl');
		break;

	case 'logout':

	 $_SESSION = array(); //Очищаем сессию
	 session_destroy(); //Уничтожаем
	 //    session_unregister('authorized');
	 //    session_unregister('logged_user');
	 $smarty->assign('message',"До встречи!");
	 $smarty->assign('title',"Выход");
	 $smarty->assign('authorized',false);
	 $smarty->assign('result',true);
	 $smarty->display('templates/general_message.tpl');
	 
	 break;

	case 'list_abs_data':

		$id_trans='Код';
		$last_name_trans='Фамилия';
		$first_name_trans='Имя';
		$patronymic_name_trans='Отчество';
		$sex_id_trans='Пол';
		$sex_trans='';
		$date_birth_string_trans='Дата рождения';
		$year_birth_trans='Год рождения';
		$weight_kg_trans='Вес (кг)';
		$height_sm_trans='Рост (см)';
		$prof_or_other_hazards_yes_no_id_trans='Проф или иные вредности (да, нет)';
		$prof_or_other_hazards_yes_no_trans='';
		$prof_or_other_hazards_discr_trans='Проф или иные вредности (описание)';
		$nationality_id_trans='Национальность';
		$nationality_trans='';
		$smoke_yes_no_id_trans='';
		$smoke_yes_no_trans='';
		$smoke_discr_trans='';
		$hospital_trans='';
		$doctor_trans='';
		$comments_trans='';
		$user_trans='';
		$insert_date_trans='';

        $smarty->assign('title',"Отсутсвующие данные");
		$smarty->assign('patients',$dao->getPatients());
		$smarty->display('templates/list_abs_data.tpl');
		
     break;
	case "list":
		$smarty->assign('title',"Список пациентов");
		$smarty->assign('patients',$dao->getPatients());
		$smarty->display('templates/list.tpl');
		
		break;
	default:
		//echo "nothing";
		//$smarty->assign('patients',$dao->getPatients());
		$smarty->assign('title',"Главная страница");
		$smarty->display('templates/index.tpl');
		
		break;
}

*/
?>