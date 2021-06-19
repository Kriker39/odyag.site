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

	public static function addOrderInDB($id, $recipient, $phone, $typepost, $address, $sum, $listProduct){
		$order= R::dispense("order");

		$order->id_user=$id;
		$order->recipient=$recipient;
		$order->number=$phone;
		$order->method_delivery=$typepost;
		$order->address_delivery=$address;
		$order->method_pay="cash";
		$order->sum=$sum;
		$order->products=$listProduct;

		R::store($order);

		$listOrder= explode(".", $_COOKIE["Order"]);
		$listId=array();
		foreach($listOrder as $order){
			$masorder=explode("-", $order);
			array_push($listId, $masorder[0]);
		}

		$listProduct= R::getAll("SELECT id,size FROM product WHERE id IN (".R::genSlots($listId).")", $listId);

		foreach($listOrder as $order){
			$masorder=explode("-", $order);
			for($i=0; $i<count($listProduct); $i++){
				if($masorder[0]== $listProduct[$i]["id"]){
					$size= explode("-", $listProduct[$i]["size"]);
					for($j=0; $j<count($size); $j++){
						$sizemas= explode(".", $size[$j]);
						if(count($sizemas)>1 && $masorder[1]==$sizemas[1]){
							$sizemas[0]= $sizemas[0]-$masorder[2];
							$size[$j]= implode(".", $sizemas);
							break;
						}
					}
					$listProduct[$i]["size"]=implode("-", $size);
				}
			}
		}
		$textCase="";
		for($i=0; $i<count($listProduct); $i++){
			$textCase.=" WHEN ? THEN ?";
		}
		$arrayForDb=array();
		foreach($listProduct as $product){
			array_push($arrayForDb, $product["id"], $product["size"]);
		}
		foreach($listId as $id){
			array_push($arrayForDb, $id);
		}

		R::exec("UPDATE product SET size = CASE id ".$textCase." END WHERE id IN(".R::genSlots($listId).")", $arrayForDb);

		setcookie('Order', null, -1, '/'); 
		setcookie('Cart', null, -1, '/'); 
	}

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

	public static function checkDataCartWithCookie($idsizecount, $cook){
		$return= true;

		$idsizecountm= explode(".", $idsizecount);
		$idsizem= explode(".", $cook); 
		for ($i=0; $i < count($idsizem); $i++) { 
			$val1= explode("-", $idsizecountm[$i]);
			$val2= explode("-", $idsizem[$i]);
			if($val1[0]!=$val2[0] || $val1[1]!=$val2[1]){
				$return= false;
				break;
			}
		}

		return $return;
	}

	public static function checkCountProduct(){
		$return= true;

		if(isset($_COOKIE["Order"])){
			$masCookie= explode(".", $_COOKIE["Order"]);
			$listid=array();
			foreach($masCookie as $cookie){
				$cookiemas=explode("-", $cookie);
				array_push($listid, $cookiemas[0]);
			}

			$listProd= R::getAll("SELECT id, size FROM product WHERE id IN (".R::genSlots($listid).")", $listid);

			if($listProd){
				foreach($masCookie as $cookie){
					$cookiemas= explode("-", $cookie);
					foreach($listProd as $product){
						if($product["id"]==$cookiemas[0]){
							$size= explode("-", $product["size"]);
							foreach($size as $sizeitem){
								$massize= explode(".", $sizeitem);
								if(count($massize)>1 && $cookiemas[1]==$massize[1]){
									if($cookiemas[2]>$massize[0]){
										$return= false;
										break 3;
									}
								}
							}
						}
					}
				}
			}
		}

		return $return;
	}

	public static function getListCount($idsizecount, $cook){
		$return= true;
		$listId=array();
		$listCook=explode(".", $cook);
		foreach ($listCook as $val) {
			$val= explode("-", $val);
			array_push($listId, $val[0]);
		}

		$listSize=R::getAll("SELECT id, size FROM product WHERE id IN (".R::genSlots($listId).")", $listId);
		if($listSize){
			$return=array();
			foreach ($listCook as $idsize) {
				$idsize= explode("-", $idsize);
				foreach($listSize as $size){
					if($idsize[0]==$size["id"]){
						$masSize= explode("-", $size["size"]);
						foreach($masSize as $countsize){
							$countsize= explode(".", $countsize);
							if(count($countsize)>1 && $countsize[1]==$idsize[1]){
								$listidsizecount= explode(".", $idsizecount);
								foreach($listidsizecount as $itemidsizecount){
									$itemidsizecount=explode("-", $itemidsizecount);
									if($itemidsizecount[0]==$idsize[0] && $itemidsizecount[1]==$idsize[1]){
										if($itemidsizecount[2]>$countsize[0]){
											$mas=array();
											array_push($mas, $idsize[0], $idsize[1], $countsize[0]);
											array_push($return, $mas);
											break 3;
										}
									}
								}
							}
						}
					}
				}
			}
		}

		return $return;
	}

	public static function getOrderForDb(){
		$return= "";
		
		if(isset($_COOKIE["Order"])){
			$listId=array();
			$cookie=explode(".", $_COOKIE['Order']);
			foreach($cookie as $order){
				$mas= explode("-", $order);
				array_push($listId, $mas[0]);
			}

			$dbprice= R::getAll("SELECT id, price, discount FROM product WHERE id IN (".R::genSlots($listId).")", $listId);

			foreach($cookie as $order){
				$mas= explode("-", $order);
				foreach($dbprice as $price){
					if($mas[0]==$price["id"]){
						if($price["discount"]==0){
							$endprice=$price["price"];
						}else{
							$endprice=round($price["price"]-(($price["price"]*$price["discount"])/100));
						}
						$txt=$mas[0].".".$mas[1].".".$endprice.".".$mas[2];
						if(strlen($return)!=0){
							$return.="-";
						}
						$return.=$txt;
						break;
					}
				}
			}
		}

		return $return;
	}

	public static function getSumOrderByListProduct($listProduct){
		$return= 0;
		
		$list= explode("-", $listProduct);
		foreach($list as $item){
			$masitem= explode(".", $item);
			$return+=($masitem[2]*$masitem[3]);
		}

		return $return;
	}

	public static function getShortDataProductByCookie(){
		$return= array();
		
		if(isset($_COOKIE["Order"])){
			$listOrder=explode(".", $_COOKIE["Order"]);
			$listId=array();
			foreach($listOrder as $order){
				$masOrder=explode("-", $order);
				array_push($listId, $masOrder[0]);
			}

			$listProduct= R::getAll("SELECT id, tag, name, company FROM product WHERE id IN (".R::genSlots($listId).")", $listId);

			foreach($listOrder as $order){
				$masOrder=explode("-", $order);
				foreach($listProduct as $product){
					if($product["id"]==$masOrder[0]){
						$secmas=array($product["name"], $product["company"], $masOrder[1], $masOrder[2], $product["tag"], $product["id"]);
						array_push($return, $secmas);
					}
				}
			}
		}

		return $return;
	}

	public static function getCountProductByListProduct($listProduct){
		$return= 0;
		
		foreach($listProduct as $product){
			$return+=$product[3];
		}

		return $return;
	}
}