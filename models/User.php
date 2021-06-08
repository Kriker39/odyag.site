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

	public static function checkEnableCookies(){ // проверяет включены ли куки
		setcookie('checkcookie', "1");
		$result=false;
		if (isset($_COOKIE['checkcookie'])){
			$result=true;
		}
		return $result;
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
		
		return $listOrder;
	}
}