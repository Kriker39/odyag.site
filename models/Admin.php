<?php

class Admin{

	public static function updateOrderData($listData){ 
		$updateOrder= R::exec("UPDATE `order` SET recipient=?, `number`=?, method_delivery=?, address_delivery=?, sum=?, status_order=?, status=? WHERE id=?", array($listData[1], $listData[2], $listData[3], $listData[4], $listData[5], $listData[6], $listData[7], $listData[0]));

		return $updateOrder;
	}

	public static function updateUserData($id, $status){ 
		$updateUser= R::exec("UPDATE user SET status=? WHERE id=?", array($status, $id));

		return $updateUser;
	}

	public static function updateOrderProduct($id, $rowForDelete, $rowForAdd){ 
		$rowProduct= R::getCell("SELECT products FROM `order` WHERE id=?", array($id));
		$listProduct=explode("-", $rowProduct);

		if($rowForDelete!=""){
			$listForDelete=explode("-", $rowForDelete);
			$listId=array();

			foreach($listForDelete as $forDelete){
				$masForDelete=explode(".", $forDelete);
				array_push($listId, $masForDelete[0]);
			}
			$rowSize=R::getAll("SELECT id, size FROM product WHERE id IN (".R::genSlots($listId).")", $listId);
			$listSizeForChange=array();

			foreach($listProduct as $key=>$product){
				$keyProd = array_search($product, $listForDelete);

				if(is_numeric($keyProd)){
					$masProduct=explode(".", $product);
					
					foreach($rowSize as $idsizekey=>$idsize){

						if($idsize["id"]==$masProduct[0]){
							$listSize= explode("-", $idsize["size"]);

							foreach($listSize as $sizekey=>$size){
								$massize= explode(".", $size);
								if(isset($massize[1]) && $massize[1]==$masProduct[1]){
									$massize[0]+=$masProduct[3];
									unset($listProduct[$key]);
								}
								$listSize[$sizekey]= implode(".", $massize);
							}
							$newSize= implode("-", $listSize);
							array_push($listSizeForChange, $newSize);
							break;
						}
					}
				}
			}
			$textCase="";
			for($i=0; $i<count($listId); $i++){
				$textCase.=" WHEN ? THEN ?";
			}
			$arrayForDb=array();
			for($i=0; $i<count($listId); $i++){
				array_push($arrayForDb, $listId[$i], $listSizeForChange[$i]);
			}
			foreach($listId as $idm){
				array_push($arrayForDb, $idm);
			}
			
			R::exec("UPDATE product SET size = CASE id ".$textCase." END WHERE id IN(".R::genSlots($listId).")", $arrayForDb);
		}
		if($rowForAdd!=""){
			$listForAdd=explode("-", $rowForAdd);
			$listId=array();
			foreach($listForAdd as $forAdd){
				$masForAdd= explode(".", $forAdd);
				array_push($listId, $masForAdd[0]);
			}

			$rowSize=R::getAll("SELECT id, size FROM product WHERE id IN (".R::genSlots($listId).")", $listId);
			$listSizeForChange=array();

			foreach($listForAdd as $forAdd){
				$masForAdd= explode(".", $forAdd);

				foreach($rowSize as $idsize){

					if($idsize["id"]==$masForAdd[0]){
						$listIdsize= explode("-", $idsize["size"]);

						foreach($listIdsize as $sizekey=>$size){
							$masSize=explode(".", $size);

							if($masSize[1]==$masForAdd[1]){
								$masSize[0]-=$masForAdd[3];
							}
							$listIdsize[$sizekey]= implode(".", $masSize);
						}
						$newSize= implode("-", $listIdsize);
						array_push($listSizeForChange, $newSize);
						break;
					}
				}
				array_push($listProduct, $forAdd);
			}

			$textCase="";
			for($i=0; $i<count($listId); $i++){
				$textCase.=" WHEN ? THEN ?";
			}
			$arrayForDb=array();
			for($i=0; $i<count($listId); $i++){
				array_push($arrayForDb, $listId[$i], $listSizeForChange[$i]);
			}
			foreach($listId as $idm){
				array_push($arrayForDb, $idm);
			}

			R::exec("UPDATE product SET size = CASE id ".$textCase." END WHERE id IN(".R::genSlots($listId).")", $arrayForDb);
		}

		$lastRow= implode("-", $listProduct);
		$rslt= R::exec("UPDATE `order` SET products=? WHERE id=?", array($lastRow, $id));

		return $rslt;
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

	public static function getListOrder(){ 
		$listOrder=R::getAll("SELECT * FROM `order` ORDER BY `date` DESC");

		return $listOrder;
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

	public static function checkOrderById($id){
		$return=  R::getRow('SELECT id FROM `order` WHERE id=?', array($id));

		if(!empty($return)){
			$return=true;
		}else{
			$return=false;
		}

		return $return;
	}

}
