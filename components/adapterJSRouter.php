<?php
define('ROOT', dirname(__FILE__, 2));
require_once(ROOT.'/components/Autoload.php');
require_once(ROOT.'/components/db.php');

$action=$_POST["action"];
$controller=$_POST["controller"];
$args=$_POST["args"];

// Подключение файла класса-контроллера
$controllerFile = '../controllers/'.$controller.'.php';

if(file_exists($controllerFile)){
	include_once($controllerFile);
}

// Работа action (обьекты, методы)
$controllerObject = new $controller;
$result = call_user_func_array(array($controllerObject, $action), $args);

if($result == null){
	echo json_encode("Error 01.");
}
