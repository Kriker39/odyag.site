<?php

class MainController{

	public static function actionIndex(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);

		require_once(ROOT.'/views/main/index.php');

		return true;
	}
}