<?php

class Category{

	//--------------GET FUNCTIONS------------

	public static function getFirstCategory(){
		$category=  R::getAll( 'SELECT id,name FROM first_category WHERE status=1');

		return $category;
	}

	public static function getSecondCategory(){
		$category=  R::getAll( 'SELECT id,name FROM second_category WHERE status=1');

		return $category;
	}

	public static function getThirdCategory($firstCat, $secondCat){
		$category=  R::getAll( 'SELECT id,name FROM third_category WHERE status=1 AND id_first_cat=? AND id_second_cat=?', array($firstCat, $secondCat));

		return $category;
	}

	public static function getThirdCategoryByFirstCat($id){
		$category= R::getAll( 'SELECT id,name,id_second_cat FROM third_category WHERE status=1 AND id_first_cat=?', array($id));

		return $category;
	}

	public static function getThirdCategoryForSecond($IDfirstCat, $IDsecondCat){
		$category= R::getAll( 'SELECT id,name FROM third_category WHERE status=1 AND id_first_cat=? AND id_second_cat=?', array($IDfirstCat, $IDsecondCat));

		return $category;
	}

	public static function getThirdCategoryForThird($IDfirstCat, $IDsecondCat, $IDthirdCat){
		$category= R::getAll( 'SELECT id,name FROM third_category WHERE status=1 AND id_first_cat=? AND id_second_cat=? AND id=?', array($IDfirstCat, $IDsecondCat, $IDthirdCat));

		return $category;
	}
	
}