<?php
include_once 'includes/global.php';

$from = ADMIN_EMAIL;
$subject = "Активация учетной записи";

$title = "Регистрация не прошла";

$username = trim($_REQUEST['email']);
$password = trim($_REQUEST['password']);
$admin_code = trim($_REQUEST['code']);




$activation_link = 'http://'.$_SERVER['HTTP_HOST']. folder_host($_SERVER['REQUEST_URI']) . "/index.php?page=activate_account&username_email=". $username;

$text_message = 'Уважаемый(ая) %1$s,<br><br>
Ваша учетная запись на <b>%2$s</b> успешно создана.<br><br>
Детализация:<br>
<ul><li>Логин  : <b>%3$s</b></li><li>Пароль : <введенный вами пароль></li></ul>
[ <a href="%4$s">Ссылка</a> ] на страницу активации учетной записи.<br><br>

С уважением Администрация %2$s ';



if($admin_code == ADMIN_CODE){

	if(!$dao->is_user_exist($username)){



		if($username && $password){

			$object = new User();

			$object->username_email=$username;
			$object->password=md5($password);

			$inserted_id = $dao->insert_user($object);
			$result = false;

			if($inserted_id){
				$text_message = sprintf($text_message, $object->username_email, SITE_NAME, $object->username_email, $activation_link);
					
				$result = mail_utf8($object->username_email, $from, $subject, $text_message);

				if($result){

					$text_message = "Регистрация прошла успешно, на ваш email отпровлено письмо для активации учетной записи" ;
					$title = "Регистрация прошла успешно";

				}else{
					$text_message =  "Сообщение не было отправлено, проверьте правильно ли указана Ваша почта, обратитесь к администратору.";
				}
			}else{
				$text_message =  "Регистрация не прошла, обратитесь к администратору.". '</div>';
			}



		}else{
			$text_message = "Регистрация не прошла, проверьте все ли поля заполнены.";
		}

	}else{
		$text_message = "Регистрация не прошла, такой пользователь уже существует.";
	}}
	else{
		$result = false;
		$text_message = "Регистрация не прошла, код доступа неверный.";
	}



	$smarty->assign('title',$title);
	$smarty->assign('result',$result);
	$smarty->assign('message',$text_message);
	$smarty->assign('authorized',0);
	$smarty->display('templates/register.tpl');


	?>
