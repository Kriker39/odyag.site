<?php

class CartController{

	public static function actionIndex(){

		

		require_once(ROOT.'/views/cart/index.php');

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
}