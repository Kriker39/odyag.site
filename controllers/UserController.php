<?php

class UserController{

	public static function actionSign(){
		if(User::getProfileLink()=="sign"){
			require_once(ROOT.'/views/sign/index.php');
		}else{
			header('Location: /profile/');
			exit();
		}

		return true;
	}

	public static function actionProfile(){
		$link= User::getProfileLink();
		if($link=="profile"){
			$id= User::getIdUser();
			$listOrder= User::getListOrderById($id);
			if($listOrder!="empty"){
				$listProduct= User::encodeInfoProduct($listOrder);
				$listProduct= Product::getDataProductForOrder($listProduct);
			}
			$admin= User::checkAdmin();
			require_once(ROOT.'/views/profile/index.php');
		}else{
			header('Location: /sign/');
			exit();
		}
		
		return true;
	}

	public static function actionInfo(){
		$link= User::getProfileLink();
		if($link=="profile"){
			$id= User::getIdUser();
			$dataUser= User::getListDataUser($id);

			require_once(ROOT.'/views/profile_info/index.php');
		}else{
			header('Location: /sign/');
			exit();
		}
		
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

	public function jsactionUpdateInfo($txt){ // ajax функция для добавления товара в корзину
		$err=true;
		
		$link= User::getProfileLink();
		if($link=="profile"){
			$data= explode("|", $txt);

			$name= array_shift($data);
			$secondname= array_shift($data);
			$lastname= array_shift($data);
			$code= array_shift($data);
			$number= array_shift($data);
			$typepost= array_shift($data);
			$address= array_shift($data);
			$id= User::getIdUser();

			$phone=$code.".".$number;

			User::UpdateUserInfo($id, $name, $secondname, $lastname, $typepost, $address, $phone);
			$err=false;
			echo true;
		}else{
			$err="unsign";
		}


		if($err!=false){
			echo json_encode($err);
		}
		return true;
	}
}