<?php

class CategoryController{

	public static function actionConstructor(){

		$listCategory= Category::getThirdCategoryByFirstCat(2);
		$secondCategory= Category::getSecondCategory();

		$listLastProduct= Product::getProductOrderDescByListCategory($listCategory);
		$listSize= Product::getSizeByListCategory($listCategory);

		require_once(ROOT.'/views/constructor/index.php');

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
}