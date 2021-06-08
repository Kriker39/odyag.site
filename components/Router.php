<?php

class Router{
	private $routes;

	public function __construct(){
		$routesPath= ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	private function getURI(){
		if(!empty($_SERVER['REQUEST_URI'])){
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	public function run(){
		// Строка запроса
		$uri= $this->getURI();

		// Переменная для отслеживания вхождения
		$checkError=true;

		// Проверка наличия строки запроса
		foreach ($this->routes as $uriPattern => $path) {
			if (preg_match("~^$uriPattern$~", $uri)){
				$route= preg_replace("~$uriPattern~", $path, $uri);
				$segments= explode('/', $route);

				$controllerName= ucfirst(array_shift($segments)).'Controller';
				$actionName= 'action'.ucfirst(array_shift($segments));

				$parameters= $segments;

				// Подключение файла класса-контроллера
				$controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

				if(file_exists($controllerFile)){
					include_once($controllerFile);
				}

				// Работа action (обьекты, методы)
				$controllerObject = new $controllerName;
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
				if($result != null){
					$checkError=false;
					break;
				}
			}
		}
		if($checkError){
			require_once(ROOT."/error.php");
		}
	}
}