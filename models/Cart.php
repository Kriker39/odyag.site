<?php 
class Cart{
	// public static function startSession(){
	// 	if (!session_id()){
	// 		session_start();
	// 	}
	// 	if(!isset($_SESSION["cart"])){
	// 		$_SESSION["cart"]= array();
	// 	}
	// }

	public static function updateCartCookie(){
		$update= false;
		if(isset($_COOKIE["Cart"])){
			$list= self::getListProduct();
			$masId=array();
			foreach($list as $val){
				if(count($val)>1){
					array_push($masId, $val[0]);
				}
			}

			$listForDelete=array();
			$listId= R::getCol("SELECT id FROM product WHERE status=1 AND id IN (".R::genSlots($masId).")", $masId);

			foreach($masId as $id){
				if(!in_array($id, $listId)){
					foreach ($list as $val) {
						if($val[0]==$id){
							array_push($listForDelete, $val[0]."-".$val[1]);
							unset($list[array_search($val,$list)]);
							unset($masId[array_search($val[0],$masId)]);
						}
					}
				}
			}
			if(count($list)>0){
				$listSize= R::getAll("SELECT id,size FROM product WHERE id IN (".R::genSlots( $masId ).")", $masId);

				foreach($listSize as $dbsize){ // проверка если товар закончился
					$listDbSize= explode("-", $dbsize["size"]);
					foreach($listDbSize as $size){
						$sizesum= explode(".", $size);
						if(count($sizesum)>1){
							foreach($list as $val){
								if($val[0]==$dbsize["id"] && $val[1]==$sizesum[1] && $sizesum[0]<=0){
									array_push($listForDelete, $val[0]."-".$val[1]);
								}
							}
						}
					}
				}
			}

			if(count($listForDelete)>0){
				$update=true;
				$cookie= explode(".", $_COOKIE['Cart']);
				$editcookie= $cookie;
				foreach($cookie as $val){
					if(in_array($val, $listForDelete)){
						unset($editcookie[array_search($val,$editcookie)]);
					}
				}
				setcookie('Cart', implode(".", $editcookie), 0, "/"); // занесение в куки до конца сессии
			}

		}

		return $update;
	}

	public static function getListProduct(){
		$list= array();

		if(isset($_COOKIE["Cart"])){
			$cookie= $_COOKIE["Cart"];
			$mas= explode(".", $cookie);
			foreach($mas as $val){
				$msa= explode("-", $val);
				if(count($msa)>1){
					array_push($list, $msa);
				}
			}
		}

		return $list;
	}

	public static function getListSum($listProduct){
		$sumDiscount= 0;
		$sumPrice= 0;

		foreach($listProduct as $product){
			$sumPrice+=$product["price"];
			if($product["discount"]>0){
				$sumDiscount+=$product["discount"];
			}else{
				$sumDiscount+=$product["price"];
			}
		}

		$list= array("discount"=>$sumDiscount, "price"=>$sumPrice);

		return $list;
	}

	public static function checkCart(){
		$return= false;

		if(isset($_COOKIE["Cart"])){
			$cookie= $_COOKIE["Cart"];
			$mas= explode(".", $cookie);
			if(count($mas)>0){
				$return=true;
			}
		}

		return $return;
	}
}