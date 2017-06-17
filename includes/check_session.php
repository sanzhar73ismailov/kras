<?php
session_start();
if(isset($_SESSION["authorized"])){

	//echo "authorized yes";
	//var_dump($_SESSION["logged_user"]);
	$smarty->assign('authorized',true);

}else{
	//echo "authorized no";
	switch ($page){
		case 'contacts':

			$smarty->display('templates/contacts.tpl');
			break;

		case 'feedback':

			$smarty->display('templates/feedback.tpl');
			break;

		case 'register':

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

			$smarty->display('templates/activation.tpl');
			break;

		default:
			$smarty->display('templates/login.tpl');
			break;
	}
}
?>