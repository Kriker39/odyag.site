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
				$status=User::checkStatusUser();
			}

			require_once(ROOT.'/views/cart/index.php');
		}

		return true;
	}

	public static function actionOrder(){
		if(isset($_COOKIE["Order"])){
			if(isset($_COOKIE["savel"]) && isset($_COOKIE["savep"]) && User::getProfileLink()=="profile"){
				$listProduct= Cart::getShortDataProductByCookie();
				$countItem=Cart::getCountProductByListProduct($listProduct);

				$userid= User::getIdUser();
				$dataUser= User::getListDataUser($userid);
				require_once(ROOT.'/views/order/index.php');
			}else{
				header('Location: /sign/');
			}
		}else{
			header('Location: /cart/');
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

	public static function jsactionRegOrder($idsizecount){ // ajax функция для начала оформления заказа
		$err="error";

		if (isset($_COOKIE['Cart'])) {
			$cookie= $_COOKIE['Cart'];
			if(Cart::checkDataCartWithCookie($idsizecount, $cookie)){
				$error=Cart::getListCount($idsizecount, $cookie);
				if(is_array($error) && count($error)>0){
					$err=[];
					foreach($error as $val){
						array_push($err, $val);
					}
				}else{
					$err=false;
					echo true;
					setcookie('Order', $idsizecount, 0, "/"); // занесение в куки до конца сессии
				}
			}
		}


		
		if($err!=false){
			echo json_encode($err);
		}

		return true;
	}

	public static function jsactionAddOrder($idsizecount){ // ajax функция для оформления заказа
		$err="error";

		$listProduct= Cart::getOrderForDb();
		if(strlen($listProduct)>0){
			if(Cart::checkCountProduct()){
				$data= explode("|", $idsizecount);

				$name= array_shift($data);
				$secondname= array_shift($data);
				$lastname= array_shift($data);
				$code= array_shift($data);
				$number= array_shift($data);
				$typepost= array_shift($data);
				$address= array_shift($data);
				$sum=Cart::getSumOrderByListProduct($listProduct);
				$id= User::getIdUser();

				$recipient= $secondname." ".$name." ".$lastname;
				$phone=$code."-".$number;

				Cart::addOrderInDB($id, $recipient, $phone, $typepost, $address, $sum, $listProduct);
				$err=false;
				echo true;
			}
			else{
				$err= "Неможливо оформити замовлення. Кількість товарів змінилась. Поверніться у кошик.";
			}
		}else{
			$err="Невідома помилка. Не вдалось оформити замовлення.";
		}
		
		if($err!=false){
			echo json_encode($err);
		}

		return true;
	}
}