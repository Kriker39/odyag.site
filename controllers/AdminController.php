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
				$listProduct= Admin::getDataProduct();
				$listCategory=Admin::getListCategory();
				$listProduct=Admin::encodeListSize($listProduct);
				$listProduct=Admin::encodeListLength($listProduct);

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
				$listPromotion= Admin::getDataPromotion();
				$listPromotion= Admin::encodeProductsPromo($listPromotion);

				require_once(ROOT.'/views/admin-promotion/index.php');
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

	public static function jsactionUpdateOrder($dataForUpdate){
		$err=true;
		$listData=explode("|", $dataForUpdate);
		
		if(Admin::checkOrderById($listData[0])){
			$rslt= Admin::updateOrderData($listData);
			
			if($rslt==1 || $rslt==0){
				$rslt= Admin::updateUserData($listData[8], $listData[9]);
				if($rslt==1 || $rslt==0){
					$rslt= Admin::updateOrderProduct($listData[0], $listData[10], $listData[11]);
					if($rslt==1 || $rslt==0){
						$err=false;
						echo true;
					}else{
						$err="Не вдалось редагувати список товарів.<br>Дані замовлення і користувача редаговано.";
					}
				}else{
					$err="Не вдалось редагувати статус користувача.<br>Дані замовлення редаговано.";
				}
			}else{
				$err="Не вдалось редагувати замовлення";
			}
		}else{
			$err="Замовлення з таким кодом не знайдено";
		}

		if($err!=false){
			echo json_encode($err);
		}
		
		return true;
	}

	public static function jsactionUpdateProduct($dataForUpdate){
		$err=true;
		$listData=explode("|", $dataForUpdate);
		
		if(Admin::checkProductById($listData[0])){
			$rslt= Admin::updateProductData($listData);
			
			if($rslt==1 || $rslt==0){
				$err=false;
				echo true;
			}else{
				$err="Не вдалось редагувати товар";
			}
		}else{
			$err="Товар з таким кодом не знайдено";
		}

		if($err!=false){
			echo json_encode($err);
		}
		
		return true;
	}

	public static function jsactionDeleteImg($code, $num){
		$err=true;
		$filename = realpath(dirname(__FILE__) . '/..')."/data/product/img/".$code."/".$num.".jpg";
		if (file_exists($filename)) {
			if(unlink($filename)){
				if(Admin::renameImgInDir(realpath(dirname(__FILE__) . '/..')."/data/product/img/".$code."/", $num)){
					$err=false;
					echo true;
				}else{
					$err="Сталась помилка у дерикторії. Треба перезавантажити сторінку.";
				}
			}else{
				$err="Не вдалося видалити зображення";
			}
		} else {
			$err="Файл не знайдено";
		}

		if($err!=false){
			echo json_encode($err);
		}
		
		return true;
	}

	public static function jsactionAddProduct(){
		$err=true;
		
		if(Admin::addNewProject()){
			$err=false;
			echo true;
		} else {
			$err="Не вдалось додати товар";
		}

		if($err!=false){
			echo json_encode($err);
		}
		
		return true;
	}

	public static function jsactionGetProductForPromo($id){
		$err=true;
		
		if(Product::findProducById($id)){
			$err=Admin::getShortInfoProductForPromo($id);
		} else {
			$err="Товар з таким кодом не знайдено";
		}

		if($err!=false){
			echo json_encode($err);
		}
		
		return true;
	}

	public static function jsactionUpdatePromotion($dataForUpdate){
		$err=true;
		$listData=explode("|", $dataForUpdate);
		
		if(Product::findPromotionById($listData[0])){
			$rslt= Admin::updatePromotionData($listData);
			
			if($rslt==1 || $rslt==0){
				$err=false;
				echo true;
			}else{
				$err="Не вдалось редагувати акцію";
			}
		}else{
			$err="Акцію з таким номером не знайдено";
		}

		if($err!=false){
			echo json_encode($err);
		}
		
		return true;
	}
}