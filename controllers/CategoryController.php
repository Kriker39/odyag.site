<?php

class CategoryController{

	public static function actionConstructor(){

		$updateCart= Cart::updateCartCookie();

		if(!$updateCart){
			$check= Cart::checkCart();

			if($check){
				$listCookie= Cart::getListProduct();
				$listProduct= Constructor::getListProductForConstructor($listCookie);
				$newList= $listCookie;
			}
		}

		require_once(ROOT.'/views/constructor/index.php');

		return true;
	}

	public static function actionThirdcat($firstCat, $secondCat, $thirdCat){

		if($firstCat==1){
			return false;
		}else if($firstCat==4){
			return false;
		}else if($firstCat==5){
			header('Location: /constructor/');
			exit();
		}else{
			$listCategory= Category::getThirdCategoryByFirstCat($firstCat);
			$secondCategory= Category::getSecondCategory();
			$listCategoryForThirdCat= Category::getThirdCategoryForThird($firstCat, $secondCat, $thirdCat);

			$listLastProduct= Product::getProductOrderDescByListCategory($listCategoryForThirdCat);
			$listSize= Product::getSizeByListCategory($listCategoryForThirdCat);
			require_once(ROOT.'/views/thirdcat/index.php');
		}

		return true;
	}

	public static function actionSecondcat($firstCat, $secondCat){

		if($firstCat==1){
			$secondCategory= Category::getSecondCategory();

			$listNewProduct= Product::getNewProductBySecondCat($secondCat);
			if(!empty($listNewProduct)){
				$listSize= Product::getSizeByListProduct($listNewProduct);
			}

			require_once(ROOT.'/views/secondcat_new/index.php');
		}else if($firstCat==4){
			$secondCategory= Category::getSecondCategory();

			$listPopularProduct= Product::getPopularProductBySecondCat($secondCat);
			if(!empty($listPopularProduct)){
				$listSize= Product::getSizeByListProduct($listPopularProduct);
			}

			require_once(ROOT.'/views/secondcat_popular/index.php');
		}else if($firstCat==5){
			header('Location: /constructor/');
			exit();
		}else{
			$listCategory= Category::getThirdCategoryByFirstCat($firstCat);
			$secondCategory= Category::getSecondCategory();
			$listCategoryForSecondCat= Category::getThirdCategoryForSecond($firstCat, $secondCat);

			$listLastProduct= Product::getProductOrderDescByListCategory($listCategoryForSecondCat);
			$listSize= Product::getSizeByListCategory($listCategoryForSecondCat);
			require_once(ROOT.'/views/secondcat/index.php');
		}

		return true;
	}

	public static function actionFirstcat($firstCat){

		if($firstCat==1){
			$secondCategory= Category::getSecondCategory();

			$listNewProduct= Product::getNewProduct();
			if(!empty($listNewProduct)){
				$listSize= Product::getSizeByListProduct($listNewProduct);
			}

			require_once(ROOT.'/views/firstcat_new/index.php');
		}else if($firstCat==4){
			$secondCategory= Category::getSecondCategory();

			$listPopularProduct= Product::getPopularProduct();
			if(!empty($listPopularProduct)){
				$listSize= Product::getSizeByListProduct($listPopularProduct);
			}

			require_once(ROOT.'/views/firstcat_popular/index.php');
		}else if($firstCat==5){
			header('Location: /constructor/');
			exit();
		}else{
			$listCategory= Category::getThirdCategoryByFirstCat($firstCat);
			$secondCategory= Category::getSecondCategory();

			$listLastProduct= Product::getProductOrderDescByListCategory($listCategory);
			$listSize= Product::getSizeByListCategory($listCategory);
			require_once(ROOT.'/views/firstcat/index.php');
		}

		return true;
	}

	public static function actionWoman(){

		$listCategory= Category::getThirdCategoryByFirstCat(2);
		$secondCategory= Category::getSecondCategory();

		$listLastProduct= Product::getProductOrderDescByListCategory($listCategory);
		$listSize= Product::getSizeByListCategory($listCategory);

		require_once(ROOT.'/views/woman/index.php');

		return true;
	}

	public static function actionMan(){
		$linkProfile='/'.User::getProfileLink();
		

		require_once(ROOT.'/views/man/index.php');

		return true;
	}

	public static function actionNew(){
		$linkProfile='/'.User::getProfileLink();
		

		require_once(ROOT.'/views/new/index.php');

		return true;
	}

	public static function actionBest(){
		$linkProfile='/'.User::getProfileLink();
		

		require_once(ROOT.'/views/best/index.php');

		return true;
	}

	public function jsactionUpdateConstructor(){ // ajax функция для обновления списка товаров
		$list=array();

		$listCookie= Cart::getListProduct();
		$listProduct= Constructor::getListProductForConstructor($listCookie);
		$newList= $listCookie;

		
		array_push($list, $listCookie);
		array_push($list, $listProduct);

		echo json_encode($list);

		return true;
	}
}