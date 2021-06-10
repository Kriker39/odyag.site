<?php

class CartController{

	public static function actionIndex(){
		$updateCart= Cart::updateCartCookie();

		if($updateCart){
			header("Refresh:0");
		}else{
			$check= Cart::checkCart();

			if($check){
				$listCookie= Cart::getListProduct();
				$listProduct= Product::getListProductForCart($listCookie);
				$listSum= Cart::getListSum($listProduct);
				$newList= $listCookie;
			}

			require_once(ROOT.'/views/cart/index.php');
		}

		return true;
	}

	// public static function actionProfile(){
	// 	$link= User::getProfileLink();
	// 	if($link=="profile"){
	// 		$id= User::getIdUser();
	// 		$listOrder= User::getListOrderById($id);
	// 		$listProduct= User::encodeInfoProduct($listOrder);
	// 		$listProduct= Product::getDataProductForOrder($listProduct);
	// 	}
	// 	require_once(ROOT.'/views/'.$link.'/index.php');
	// 	return true;
	// }


	public function jsactionAddProduct($id, $size){ // ajax функция для добавления товара в корзину
		$err=true;
		$id= preg_replace("/tp[0-9]+p/", "", $id);

		if(Product::findProducById($id)){
			$countSize= Product::getCountSizeById($id, $size);
			
			if($countSize>0){
				if(isset($_COOKIE["Cart"])){
					$val= $_COOKIE["Cart"].".".$id."-".$size;
					setcookie('Cart', $val, 0, "/"); // занесение в куки до конца сессии
				}else{
					setcookie('Cart', $id."-".$size, 0, "/"); // занесение в куки до конца сессии
				}
				
				$err=false;
				echo true;
			}else{
				$err= "Не вдалося додати у кошик, обраний розмір закінчився";
			}
		}else{
			$err= "Товар з таким кодом не знайдено";
		}
		if($err!=false){
			echo json_encode($err);
		}
		return true;
	}

	public static function jsactionRegOrder($idcount){ // ajax функция для начала оформления заказа
		$err=true;
		// var_dump($idcount);
		// if(User::findLogin($login)){
		// 	if(User::checkUser($login, $pass)){
		// 		User::saveLoginInCookie($login);
		// 		User::savePasswordInCookie($login);

		// 		$err=false;
		// 		echo true;
		// 	}
		// }
		// if($err){
			echo json_encode("Не вдалося перейти. Кількість деяких товарів змінилась.");
		// }

		return true;
	}
}