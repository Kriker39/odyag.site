<?php

class MainController{

	public static function actionIndex(){
		$listProductPopular= Product::getPopularProductForMain();
		$listProductLastForWoman= Product::getLastProductForMain(2);
		$listProductLastForMan= Product::getLastProductForMain(3);
		$listPromotion= Product::getListPromotion();

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);

		require_once(ROOT.'/views/main/index.php');

		return true;
	}

	public static function actionPromotion($id){
		$listProduct= Product::getProductForPromotionById($id);
		if(!empty($listProduct)){
			$listSize= Product::getSizeByListProduct($listProduct);
		}

		require_once(ROOT.'/views/promotion/index.php');

		return true;
	}
}