<?php
session_start();
include_once 'includes/global.php';

//$id = (int) $_REQUEST["id"];

$object = new User();


//$object->username_email="asd@mail.ru";
//$object->password=md5("111");

$object = $dao->getUserByLogin("asd@mail.ru");
var_dump($object);

//$arr = array("a"=>$object);

$_SESSION["u"] = $object;

//var_dump($arr);
$obj2 = $_SESSION["u"];
var_dump($obj2);

print($obj2->username_email);
//var_dump(($object));


//echo folder_host($_SERVER['REQUEST_URI']);




//var_dump($_SERVER);

//var_dump($_SESSION);

//$test = array("111","222","333");
////echo json_encode($test);
//
//$value = array('first' => 'Steven', 'last' => 'Spielberg', 'address' => '1234 Unlisted Drive');
//$value = new Dictionary(12, "asd");
//$value = $dao->addDicValue("nationality", "mongol222777");
////var_dump($value);
//
//echo json_encode($value);



?>