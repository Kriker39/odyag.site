<?php 
class User{
	public static function encodeInfoProduct($listOrder){ 
		$listProduct= array();
		$i=-1;

		foreach ($listOrder as $order) {
			$i++;
			$products= $order["products"];
			$products= explode("-", $products);
			array_push($listProduct, array());

			foreach($products as $product){
				array_push($listProduct[$i], explode(".", $product));
			}
		}

		return $listProduct;
	}

	public static function writeUserInDb($email, $login, $pass){ // заносит пользователя в бд
		$user= R::dispense("user");
		$user->email = $email;
		$user->login = $login;
		$user->password = password_hash($pass, PASSWORD_DEFAULT);
		$rslt= R::store($user);
	}

	public static function UpdateUserInfo($id, $name, $secondname, $lastname, $typepost, $address, $phone){ // обновить личную инфу
		R::exec("UPDATE user SET name=?, second_name=?, last_name=?, `number`=?, method_delivery=?, address_delivery=? WHERE id=?", array($name, $secondname, $lastname, $phone, $typepost, $address, $id));
	}

	// ---------------------------SAVE

	public static function saveLoginInCookie($login){ // заносит в куки логин
		$login= password_hash($login, PASSWORD_DEFAULT); // хеширование логина

		$login=substr($login, 0, 8)."of".substr($login,8); // вставлеяет в середину хеша инфу о 

		setcookie('savel', $login, 0, "/"); // занесение в куки до конца сессии
	}

	public static function savePasswordInCookie($login){ // заносит в куки пароль
		$pass=R::getCell("SELECT password FROM user WHERE login=?", array($login)); // получение пароля по логину

		setcookie('savep', $pass, 0, "/"); // занесение в куки до конца сессии
	}

	// ---------------------------CHECK

	public static function checkUser($login, $pass){ // проверка на верность введенных данных
		$result= false;
		$rslt=  R::getCell('SELECT password FROM user WHERE login=?', array($login)); // получает пароль по логину
		if(password_verify($pass, $rslt)){ // если введенный пароль равен хешу из бд
			session_start();
			$_SESSION["user"]=password_hash($login, PASSWORD_DEFAULT); // хеш логина в переменную сессии
			$result= true;
		}

		return $result;
	}

	public static function checkEnterUser(){ // проверка запущенной сессии
		$result=false;
		if(isset($_SESSION["user"])){
			$loginList=R::getCol("SELECT login FROM user"); // список логинов
			foreach ($loginList as $login) {
				if(password_verify($login, $_SESSION["user"])){ // если логин равен хешу
					$result=true;
					break;
				}
			}
		}
		return $result;
	}

	public static function checkSaveUser(){ // проверяет был ла ли включена вечная авторизация
		$result=false;
		if(isset($_COOKIE["savel"]) && isset($_COOKIE["savep"])){ // если хеш логина и пароля есть
			$cookieLogin=$_COOKIE["savel"];
			$cookiePass=$_COOKIE["savep"];

			$cookieLogin=substr($cookieLogin, 0, 8).substr($cookieLogin,10); // удаляет инфу про переключатель вечной авторизации

			$logins= R::getCol('SELECT login FROM user'); // список логинов
			foreach ($logins as $login) {
				if(password_verify($login, $cookieLogin)){ // если логин равен хешу 
					$passwords= R::getCol("SELECT password FROM user"); // список паролей
					foreach ($passwords as $password) {
						if($password==$cookiePass){ // если пароль равен хешу 
							$result=true;
							break;
						}
					}
					break;
				}
			}
		}
		return $result;
	}

	public static function checkAdmin(){ // проверяет являеться ли пользователь админом
		$return=false;
		$id= self::getIdUser();

		if(is_numeric($id)){
			$listAdmin= R::getCell("SELECT user_id FROM admin WHERE id=? AND status=1", array($id));
			if(is_numeric($listAdmin)){
				$return=true;
			}
		}

		return $return;
	}

	public static function checkEnableCookies(){ // проверяет включены ли куки
		setcookie('checkcookie', "1");
		$result=false;
		if (isset($_COOKIE['checkcookie'])){
			$result=true;
		}
		return $result;
	}

	public static function checkStatusUser(){
		$return= true;
		
		if(User::getProfileLink()=="profile"){
			if(isset($_COOKIE["savep"])){	
				$cookiePassword=$_COOKIE["savep"];

				$status= R::getCell("SELECT status FROM user WHERE password=?", array($cookiePassword)); // status
				
				if($status==null || $status!="1"){
					$return=false;
				}
			}
		}

		return $return;
	}

	// ---------------------------FIND

	public static function findLogin($login){ // проверка существует ли логин
		$result=  R::findOne( 'user', 'login=?', array($login));
		$return= false;
		
		if($result!=null){
			$return=true;
		}
		return $return;
	}

	public static function findEmail($email){ // проверка существует ли емаил
		$result=  R::findOne( 'user', 'email=?', array($email));
		$return= false;
		
		if($result!=null){
			$return=true;
		}
		return $return;
	}

	// ---------------------------GET

	public static function getProfileLink(){ // получить ссылку для аккаунта в шапке взависимости от выполненого входа
		$profileLink="sign";
		if(self::checkEnterUser() || self::checkSaveUser()){
			$profileLink="profile";
		}
		return $profileLink;
	}

	public static function getIdUser(){ // получить id пользователя
		$id="0";
		
		$cookiePassword=$_COOKIE["savep"];

		$loginList=R::getCell("SELECT login FROM user WHERE password=?", array($cookiePassword)); // список логинов
		
		if($loginList!=null){ // если логин найден
			$id= R::getCell("SELECT id FROM user WHERE login=?", array($loginList));
		}

		return $id;
	}

	public static function getListOrderById($id){ // получить список заказов авторизованого пользователя
		$listOrder= array();
		
		$listOrder=R::getAll("SELECT * FROM `order` WHERE id_user=? AND status=1 ORDER BY id DESC", array($id));

		if(!empty($listOrder)){
			for($i=0; $i<count($listOrder); $i++){
				$date= trim($listOrder[$i]["date"]);
				$date= explode(" ", $date);
				$date= explode("-", $date[0]);
				$listOrder[$i]["date"]= $date[2].".".$date[1].".".$date[0];
				
				$status="Помилка";
				switch ($listOrder[$i]["status_order"]) {
					case '2': $status="В обробці"; break;
					case '3': $status="Відправлено"; break;
					case '4': $status="Отримано"; break;
					case '5': $status="Скасовано"; break;
					default: $status="Нове"; break;
				}
				$listOrder[$i]["status_order"]=$status;
	
				if($listOrder[$i]["method_delivery"]=="post"){
					$updAdres= explode(".", $listOrder[$i]["address_delivery"]);
					$status="Помилка";
					switch ($updAdres) {
						case 'novaposhta': $status="Нова пошта"; break;
						default: $status="Укрпошта"; break;
					}
					$listOrder[$i]["address_delivery"]=$status.", віділення №".$updAdres[1];
				}
	
				$status="Помилка";
				switch ($listOrder[$i]["method_delivery"]) {
					case 'punktvidachi': $status="Самовивіз"; break;
					case 'post': $status="Пошта"; break;
					default: $status="Кур'єр"; break;
				}
				$listOrder[$i]["method_delivery"]=$status;
	
				$updNumber= explode("-", $listOrder[$i]["number"]);
				$listOrder[$i]["number"]= "+380 (".$updNumber[0].") ".substr($updNumber[1], 0,3)."-".substr($updNumber[1], 3,2)."-".substr($updNumber[1], 5,2);
	
				$listOrder[$i]["method_pay"]= "Готівка";
	
			}
		}else{
			$listOrder="empty";
		}
		
		return $listOrder;
	}

	public static function getListDataUser($id){ // получить данные пользователя
		$listData= false;
		
		$userInfo=R::getRow("SELECT name, second_name, last_name, `number`, method_delivery, address_delivery FROM user WHERE id=?", array($id));

		if($userInfo){
			if($userInfo["method_delivery"]==""){
				$userInfo["method_delivery"]="curier";
			}else if($userInfo["method_delivery"]=="post"){
				if($userInfo["address_delivery"]==""){
					$userInfo["address_delivery"]="novaposhta";
				}else{
					$mas= explode(".", $userInfo["address_delivery"]);
					if(isset($mas[1])){
						$userInfo["numpost"]=$mas[1];
					}
					$userInfo["address_delivery"]=$mas[0];
				}
			}
			if($userInfo["number"]!=""){
				$mas=explode(".", $userInfo["number"]);
				if(isset($mas[0])){
					$userInfo["codenumber"]=$mas[0];
				}
				if(isset($mas[1])){
					$userInfo["number"]=$mas[1];
				}else{
					unset($userInfo["number"]);
				}
			}
			$listData=$userInfo;
		}
		
		return $listData;
	}

	
}