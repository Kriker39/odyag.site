<?php

class AdminController{

	public static function actionIndex(){
		$link= User::getProfileLink();
		if($link=="profile"){
			if(User::checkAdmin()){

				require_once(ROOT.'/views/admin/index.php');
			}else{
				header('Location: /profile/');
				exit();
			}
		}else{
			header('Location: /sign/');
			exit();
		}

		return true;
	}

	public static function actionOrder(){
		$link= User::getProfileLink();
		if($link=="profile"){
			if(User::checkAdmin()){
				$listOrder= Admin::getListOrder();
				$listProduct= Admin::cutListProduct($listOrder);
				$listProduct= Admin::getListProductOrder($listProduct);
				$listUser= Admin::cutListUser($listOrder);
				$listUser= Admin::getListUserOrder($listUser);

				$listFullDataOrder= Admin::implodeLists($listOrder, $listProduct, $listUser);

				require_once(ROOT.'/views/admin-order/index.php');
			}else{
				header('Location: /profile/');
				exit();
			}
		}else{
			header('Location: /sign/');
			exit();
		}
		
		return true;
	}

	public static function actionProduct(){
		$link= User::getProfileLink();
		if($link=="profile"){
			if(User::checkAdmin()){

				require_once(ROOT.'/views/admin-product/index.php');
			}else{
				header('Location: /profile/');
				exit();
			}
		}else{
			header('Location: /sign/');
			exit();
		}
		
		return true;
	}

	public static function actionPromotion(){
		$link= User::getProfileLink();
		if($link=="profile"){
			if(User::checkAdmin()){

				require_once(ROOT.'/views/admin-profile/index.php');
			}else{
				header('Location: /profile/');
				exit();
			}
		}else{
			header('Location: /sign/');
			exit();
		}
		
		return true;
	}

	public static function actionUser(){
		$link= User::getProfileLink();
		if($link=="profile"){
			if(User::checkAdmin()){

				require_once(ROOT.'/views/admin-user/index.php');
			}else{
				header('Location: /profile/');
				exit();
			}
		}else{
			header('Location: /sign/');
			exit();
		}
		
		return true;
	}

	public static function actionCategory(){
		$link= User::getProfileLink();
		if($link=="profile"){
			if(User::checkAdmin()){

				require_once(ROOT.'/views/admin-category/index.php');
			}else{
				header('Location: /profile/');
				exit();
			}
		}else{
			header('Location: /sign/');
			exit();
		}
		
		return true;
	}

	public static function jsactionReturnProductData($code, $size, $count){
		$err=true;
		$id= preg_replace("/tp[0-9]+p/", "", $code);

		if(Product::findProducById($id)){
			if(Product::getStatusById($id)){
				if(Product::checkExistSizeById($id, $size)){
					$countSize= Product::getCountSizeById($id, $size);
			
					if($countSize>0){
						if($countSize>=$count){
							$dataProduct= Admin::getProductForAdminById($id);
							if(!empty($dataProduct)){
								$err=false;
								echo json_encode($dataProduct);
							}else{
								$err="Не вдалося знайти товар";
							}
						}else{
							$err="Доступна к-сть товарів: ".$countSize;
						}
					}else{
						$err= "Вказаний розмір закінчився";
					}
				}else{
					$err= "Вказаний розмір не існує";
				}
			}else{
				$err="Доступ до товару закритий.";
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