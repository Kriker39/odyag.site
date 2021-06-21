<?php

class Admin{

	public static function getListOrder(){ 
		$listOrder=R::getAll("SELECT * FROM `order` ORDER BY `date` DESC");

		return $listOrder;
	}

	public static function implodeLists($listOrder, $listProduct, $listUser){ 
		$listReturn=array();

		for($i=0; $i<count($listOrder); $i++){
			$mas=array();
			array_push($mas, $listOrder[$i], $listProduct[$i], $listUser[$i]);
			$listReturn[$i]= $mas;
		}

		return $listReturn;
	}

	public static function getListProductOrder($listProduct){ 
		$listReturn=array();
		if(is_array($listProduct)){
			$listId=array();
			foreach($listProduct as $product){
				$masProduct= explode("-", $product);
				foreach($masProduct as $itemProduct){
					$explodeProduct=explode(".", $itemProduct);
					if(!in_array($explodeProduct[0], $listId)){
						array_push($listId, $explodeProduct[0]);
					}
				}
			}

			$listDB=R::getAll("SELECT id, tag, name, company FROM product WHERE id IN (".R::genSlots($listId).")", $listId);

			foreach($listProduct as $product){
				$masProduct= explode("-", $product);
				$mas=array();
				foreach($masProduct as $itemProduct){
					$explodeProduct=explode(".", $itemProduct);
					foreach($listDB as $dbitem){
						if($dbitem["id"]==$explodeProduct[0]){
							$mas2=array();
							$mas2["id"]=$explodeProduct[0];
							$mas2["size"]=$explodeProduct[1];
							$mas2["price"]=$explodeProduct[2];
							$mas2["count"]=$explodeProduct[3];
							$mas2["tag"]=$dbitem["tag"];
							$mas2["name"]=$dbitem["name"];
							$mas2["company"]=$dbitem["company"];
							array_push($mas, $mas2);
						}
					}
				}
				array_push($listReturn, $mas);
			}
		}

		return $listReturn;
	}

	public static function getListUserOrder($listUser){ 
		$listReturn=array();
		if(is_array($listUser)){
			$listId=array();
			foreach($listUser as $user){
				array_push($listId, $user);
			}

			$listDB= R::getAll("SELECT id, name, second_name, last_name, `number`, login, email, status FROM user WHERE id IN (".R::genSlots($listId).")", $listId);
			foreach($listUser as $id){
				foreach($listDB as $user){
					if($user["id"]==$id){
						array_push($listReturn, $user);
					}
				}
			}
		}

		return $listReturn;
	}

	public static function getProductForAdminById($id){
		$rslt=  R::getRow( 'SELECT name, company, price, discount FROM product WHERE id=? AND status=1', array($id));
		
		if($rslt["discount"]!=0){
			$sum= round($rslt["price"]-($rslt["discount"]*$rslt["price"]/100));
			$rslt["price"]=$sum;
		}

		return $rslt;
	}

	public static function cutListProduct($listOrder){ 
		$listProduct=array();
		if(is_array($listOrder)){
			foreach($listOrder as $order){
				array_push($listProduct, $order["products"]);
			}
		}

		return $listProduct;
	}

	public static function cutListUser($listOrder){ 
		$listProduct=array();
		if(is_array($listOrder)){
			foreach($listOrder as $order){
				array_push($listProduct, $order["id_user"]);
			}
		}

		return $listProduct;
	}

}
