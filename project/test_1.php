<?php
session_start();
include_once 'includes/global.php';



$str_path = "contacts";
$str_path = "list";
$session = $_SESSION;


$nav_obj = FabricaNavigate::createNavigate($str_path, $session);
$nav_obj->init();

var_dump($nav_obj);
