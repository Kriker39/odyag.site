<?php

class UserController{

	public static function actionSign(){

		require_once(ROOT.'/views/'.User::getProfileLink().'/index.php');

		return true;
	}

	public static function actionProfile(){
		$link= User::getProfileLink();
		if($link=="profile"){
			$id= User::getIdUser();
			$listOrder= User::getListOrderById($id);
			$listProduct= User::encodeInfoProduct($listOrder);
			$listProduct= Product::getDataProductForOrder($listProduct);
		}
		require_once(ROOT.'/views/'.$link.'/index.php');
		return true;
	}


	public function jsactionSignIn($login, $pass){ // ajax функция для проверки введенных данных
		$err=true;
		if(User::findLogin($login)){
			if(User::checkUser($login, $pass)){
				User::saveLoginInCookie($login);
				User::savePasswordInCookie($login);

				$err=false;
				echo true;
			}
		}
		if($err){
			echo json_encode("Логін або пароль введено не вірно");
		}
		return true;
	}

	public function jsactionSignUp($email, $login, $pass){ // ajax функция для проверки введенных данных
		$err=array();
		if(!User::findEmail($email)){
			if(!User::findLogin($login)){
				User::writeUserInDb($email, $login, $pass);

				User::saveLoginInCookie($login);
				User::savePasswordInCookie($login);

				echo true;
			}else{
				array_push($err, "login", "Логін вже зайнятий");
			}
		}
		else{
			array_push($err, "email", "Пошта вже зареєстрована");
		}
		if(count($err)>0){
			echo json_encode($err);
		}
		return true;
	}
}