<?php

class InfoController{

	public static function actionHowBuy(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "howbuy";

		require_once(ROOT.'/views/howbuy/index.php');

		return true;
	}
	public static function actionCovid(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "covid";

		require_once(ROOT.'/views/covid/index.php');

		return true;
	}
	public static function actionQuestion(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "question";

		require_once(ROOT.'/views/question/index.php');

		return true;
	}
	public static function actionDelivery(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "delivery";

		require_once(ROOT.'/views/delivery/index.php');

		return true;
	}
	public static function actionPay(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "pay";

		require_once(ROOT.'/views/pay/index.php');

		return true;
	}
	public static function actionReturn(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "return";

		require_once(ROOT.'/views/return/index.php');

		return true;
	}
	public static function actionClaims(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "claims";

		require_once(ROOT.'/views/claims/index.php');

		return true;
	}
	public static function actionTablesize(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "tablesize";

		require_once(ROOT.'/views/tablesize/index.php');

		return true;
	}
	public static function actionConstructor(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "constructor";

		require_once(ROOT.'/views/constructorinfo/index.php');

		return true;
	}
	public static function actionTermsofuse(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "termsofuse";

		require_once(ROOT.'/views/termsofuse/index.php');

		return true;
	}
	public static function actionPrivacypolicy(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "privacypolicy";

		require_once(ROOT.'/views/privacypolicy/index.php');

		return true;
	}
	public static function actionPrice(){

		$infoDataCategory1= Info::getDataInfoByCategory(1);
		$infoDataCategory2= Info::getDataInfoByCategory(2);
		$activeItem= "price";

		require_once(ROOT.'/views/price/index.php');

		return true;
	}

}