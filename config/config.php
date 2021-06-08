<?php
// конфиг файл для php. Есть:
// конфиг подключения к бд

class config{
	private static $config = array(
			"title" => "Valerii Sokolov",
			"db" => array(
				"server" => "localhost",
				"name_user" => "root",
				"password" => "",
				"name_db" => "odyag_db"
			),
			"link" => array(
				"header.php" => ROOT."/views/header.php",
				"footer.php" => ROOT."/views/footer.php",
				"head_tags.php" => ROOT."/views/head_tags.php",
				"style.css" => "/views/_style/style.css",
				"splide.css" => "/views/_javascript/lib/splide-2.4.21/dist/css/splide.min.css",
				"fonts.googleapis.com" => "https://fonts.googleapis.com/css?family=Exo+2&display=swap&subset=cyrillic,latin-ext",
				"jquery.js" => "/components/lib/jquery-3.4.1.min.js",
				"jquery.cookie.js" => "/components/lib/jquery.cookie.js",
				"router.js" => "/components/router.js",
				"header.js" => "/views/_javascript/header.js",
				"main.js" => "/views/_javascript/main.js",
				"categories.js" => "/views/_javascript/categories.js",
				"sign.js" => "/views/_javascript/sign.js",
				"profile.js" => "/views/_javascript/profile.js",
				"product.js" => "/views/_javascript/product.js",
				"constructor.js" => "/views/_javascript/constructor.js",
				"splide.js" => "/views/_javascript/lib/splide-2.4.21/dist/js/splide.min.js",
				"lazyloadxt.js" => "/views/_javascript/lib/lazy-load-xt-master/dist/jquery.lazyloadxt.js",
			),
			"linkimg" => array(
				"favicon.png" => "/views/_img/favicon2.png",
				"logo1.png" => "/views/_img/logo1.png",
				"logo2.png" => "/views/_img/logo2.png",
				"logo3.png" => "/views/_img/logo3.png",
				"logo4.png" => "/views/_img/logo4.png",
				"profile.png" => "/views/_img/profile.png",
				"profile1.png" => "/views/_img/profile1.png",
				"cart.png" => "/views/_img/cart.png",
				"cart1.png" => "/views/_img/cart1.png",
				"search.png" => "/views/_img/search.png",
			),
			"linkspec" => array(
				
			)
		);

	public static function getTitle(){
		return $this->config["title"];
	}

	public static function getDB($name){
		return self::$config['db'][$name];
	}

	public static function getLink($name){
		return self::$config["link"][$name];
	}

	public static function getLinkImg($name){
		return self::$config["linkimg"][$name];
	}

	public static function getLinkSpec($name){
		return self::$config["linkspec"][$name];
	}
}
?>