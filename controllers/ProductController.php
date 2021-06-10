<?php

class ProductController{

	public static function actionIndex($tag, $id){

		if(Product::findProducById($id)){
			Product::addView($id);
			$listIdConnectByTag= Product::getListIdByTag($tag);
			$dataProduct= Product::getProductById($id);
			$countImg= Product::getCountImg($tag, $id);
			$listSize= Product::encodeSizeProduct($dataProduct["size"]);
			$checkEndSize= Product::checkEndSize($listSize);
			$status= Product::getStatusById($id);

			require_once(ROOT.'/views/product/index.php');
		}else{
			require_once(ROOT.'/error.php');
		}

		return true;
	}

}