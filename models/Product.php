<?php

class Product{

	public static function addView($id){ 
		$views= R::getCell("SELECT views FROM product WHERE id=?", array($id));

		$views+=1;

		$views= R::getCell("UPDATE product SET views=? WHERE id=?", array($views, $id));
	}

	public static function encodeSizeProduct($size){ 
		$listSize= array();
		$size=explode("-", $size);

		foreach ($size as $val) {
			$mas=explode(".", $val);
			if(count($mas)==2){
				array_push($listSize, $mas);
			}
		}

		return $listSize;
	}

	public static function checkEndSize($list){
		$return= true;

		foreach($list as $countsize){
			if($countsize[0]>0){
				$return= false;
				break;
			}
		}

		return $return;
	}

	//--------------GET FUNCTIONS------------

	public static function getProductForPromotionById($id){
		$listReturn=array();
		$listPromotion=  R::getCell( 'SELECT products FROM promotion WHERE status=1 AND id=?', array($id));

		if(!empty($listPromotion)){
			$listId= explode(".", $listPromotion);
			
			$listReturn=  R::getAll( 'SELECT id, tag, name, company, price, discount, size, views, id_third_cat FROM product WHERE status=1 AND id IN ('.R::genSlots($listId).') ORDER BY id DESC', $listId);
		}

		return $listReturn;
	}

	public static function getListPromotion(){
		$listPromotion=  R::getCol( 'SELECT id FROM promotion WHERE status=1 ORDER BY id DESC');

		return $listPromotion;
	}

	public static function getPopularProductForMain(){
		$listProduct=  R::getAll( 'SELECT id, tag, company, price, discount FROM product WHERE status=1 ORDER BY views DESC LIMIT 10');

		foreach($listProduct as $key=>$product){
			if($product["discount"]>0){
				$sum= $product["price"]-(($product["price"]*$product["discount"])/100);
				$listProduct[$key]["discount"]=round($sum);
			}
		}

		return $listProduct;
	}

	public static function getLastProductForMain($firstCat){
		$listId3cat= R::getCol("SELECT id FROM third_category WHERE id_first_cat=?", array($firstCat));

		$listProduct=  R::getAll( 'SELECT id, tag, company, price, discount FROM product WHERE status=1 AND id_third_cat IN ('.R::genSlots($listId3cat).') ORDER BY id DESC LIMIT 10', $listId3cat);

		foreach($listProduct as $key=>$product){
			if($product["discount"]>0){
				$sum= $product["price"]-(($product["price"]*$product["discount"])/100);
				$listProduct[$key]["discount"]=round($sum);
			}
		}

		return $listProduct;
	}

	public static function getDataProductForOrder($listProduct){
		$ids= array();
		foreach($listProduct as $order){
			foreach($order as $product){
				if(!in_array($product[0], $ids)){
					array_push($ids, $product[0]);
				}
			}
		}
		$products= R::getAll("SELECT id, name, company, tag FROM product WHERE id IN (".R::genSlots( $ids ).")", $ids);
		$i=-1;

		foreach($listProduct as $order){
			$i++;
			$j=-1;
			foreach($order as $product){
				$j++;
				foreach($products as $val){
					if($product[0]==$val["id"]){
						array_push($listProduct[$i][$j], $val["name"], $val["company"], $val["tag"]);
						break;
					}
				}
			}
		}

		return $listProduct;
	}

	public static function getProductOrderDescByListCategory($thirdCat){
		$listCat=array();
		foreach ($thirdCat as $value) {
			array_push($listCat, $value["id"]);
		}

		$product=  R::getAll( 'SELECT id, tag, name, company, price, discount, size, views FROM product WHERE status=1 AND id_third_cat IN ('.R::genSlots( $listCat ).') ORDER BY id DESC', $listCat);

		return $product;
	}

	public static function getPopularProduct(){
		$product=  R::getAll( 'SELECT id, tag, name, company, price, discount, size, views, id_third_cat FROM product WHERE status=1 ORDER BY views DESC LIMIT 50');

		return $product;
	}

	public static function getNewProduct(){
		$product=  R::getAll( 'SELECT id, tag, name, company, price, discount, size, views, id_third_cat FROM product WHERE status=1 ORDER BY id DESC LIMIT 50');

		return $product;
	}

	public static function getPopularProductBySecondCat($secondCat){
		$listId3cat= R::getCol("SELECT id FROM third_category WHERE id_second_cat=?", array($secondCat));

		$product=  R::getAll( 'SELECT id, tag, name, company, price, discount, size, views, id_third_cat FROM product WHERE status=1 AND id_third_cat IN ('.R::genSlots($listId3cat).') ORDER BY views DESC LIMIT 50', $listId3cat);

		return $product;
	}

	public static function getNewProductBySecondCat($secondCat){
		$listId3cat= R::getCol("SELECT id FROM third_category WHERE id_second_cat=?", array($secondCat));

		$product=  R::getAll( 'SELECT id, tag, name, company, price, discount, size, views, id_third_cat FROM product WHERE status=1 AND id_third_cat IN ('.R::genSlots($listId3cat).') ORDER BY id DESC LIMIT 50', $listId3cat);

		return $product;
	}

	public static function getSizeByListCategory($thirdCat){
		$listCat=array();
		foreach ($thirdCat as $value) {
			array_push($listCat, $value["id"]);
		}

		$size=  R::getAll( 'SELECT size FROM product WHERE id_third_cat IN ('.R::genSlots( $listCat ).') GROUP BY size', $listCat);
		$listSize= array();
		foreach ($size as $val) {
			$mas= explode("-", $val["size"]);
			foreach ($mas as $onesize){
				$sum_size=explode(".", $onesize);
				if($sum_size[0]!=""){
					if(!in_array($sum_size[1], $listSize)){
						array_push($listSize, $sum_size[1]);
					}
				}
			}
		}
		return $listSize;
	}

	public static function getSizeByListProduct($listPopularProduct){
		$listID=array();
		foreach ($listPopularProduct as $value) {
			array_push($listID, $value["id_third_cat"]);
		}

		$size=  R::getAll( 'SELECT size FROM product WHERE id_third_cat IN ('.R::genSlots( $listID ).') GROUP BY size', $listID);
		$listSize= array();
		foreach ($size as $val) {
			$mas= explode("-", $val["size"]);
			foreach ($mas as $onesize){
				$sum_size=explode(".", $onesize);
				if($sum_size[0]!=""){
					if(!in_array($sum_size[1], $listSize)){
						array_push($listSize, $sum_size[1]);
					}
				}
			}
		}
		return $listSize;
	}

	public static function getListIdByTag($tag){
		$listId=array();

		$rslt=  R::getAll( 'SELECT id FROM product WHERE tag=? AND status=1', array($tag));
		
		foreach ($rslt as $val) {
			array_push($listId, $val["id"]);
		}
		return $listId;
	}

	public static function getProductById($id){
		$rslt=  R::getRow( 'SELECT name, company, price, discount, description, material, size, constructor_status FROM product WHERE id=?', array($id));
		
		if($rslt["discount"]!=0){
			$sum= round($rslt["price"]-($rslt["discount"]*$rslt["price"]/100));
			$rslt["discount"]=$sum;
		}

		return $rslt;
	}

	public static function getCountSizeById($id, $size){
		$listSize=  R::getCell( 'SELECT size FROM product WHERE id=?', array($id));
		$listSize= explode("-", $listSize);

		$count=0;
		foreach ($listSize as $item) {
			$val= explode(".", $item);

			if(isset($val[1]) && $val[1]==$size){
				$count=$val[0];
				break;
			}
		}

		return $count;
	}
	
	public static function getCountImg($tag, $id){
		$link= 'data/product/img/tp'.$tag.'p'.$id;
		$dir = opendir($link);
		$count = 0;
		while($file = readdir($dir)){
			if($file == '.' || $file == '..' || is_dir($link . $file)){
				continue;
			}
			if(strpos($file, ".jpg") != false){
				$count++;
			}
		}

		return $count;
	}

	public static function getListProductForCart($listIdSize){
		$listId= array();
		$newListIdSize= $listIdSize;
		foreach($listIdSize as $item){
			if(count($item)>0){
				array_push($listId, $item[0]);
			}
		}

		$rslt= R::getAll("SELECT id, tag, name, company, price, discount, size FROM product WHERE id IN (".R::genSlots($listId).")", $listId);

		$newRslt= array();

		foreach ($listId as $value) {
			foreach($rslt as $val){
				if(in_array($value, $val)){
					if($val["discount"]>0){
						$sum= round($val["price"]-($val["discount"]*$val["price"]/100));
						$val["discount"]=$sum;
					}
					array_push($newRslt, $val);
					break;
				}
			}
		}
		

		for($i=0; $i<count($newRslt); $i++){
			$listSize= explode("-", $newRslt[$i]["size"]);
			foreach($listSize as $size){
				$countsize= explode(".", $size);
				if(count($countsize)>0){
					foreach($newListIdSize as $idsize){
						if($idsize[0]==$newRslt[$i]["id"] && $idsize[1]==$countsize[1]){
							$newRslt[$i]["size"]= $countsize[0];
							unset($newListIdSize[array_search($idsize, $newListIdSize)]);
							break 2;
						}
					}
				}
			}
		}

		return $newRslt;
	}

	public static function getStatusById($id){
		$rslt= R::getCell("SELECT status FROM product WHERE id=?", array($id));

		return $rslt;
	}

	public static function checkExistSizeById($id, $size){
		$return= false;
		$rslt= R::getCell("SELECT size FROM product WHERE id=?", array($id));

		$listSize= explode("-", $rslt);
		foreach($listSize as $sizeitem){
			$masSize= explode(".", $sizeitem);
			if(isset($masSize[1]) && $size==$masSize[1]){
				$return=true;
				break;
			}
		}

		return $return;
	}
	
	//--------------FIND FUNCTIONS------------

	public static function findProjectScreensByName($nameProject){
		$screens=  R::getRow( 'SELECT id FROM screens WHERE project_name IN ('.R::genSlots( $nameProject ).') AND status=1');

		if(!empty($screens)){
			$screens=true;
		}else{
			$screens=false;
		}

		return $screens;
	}

	public static function findProducById($id){
		$product=  R::getRow( 'SELECT id FROM product WHERE id=?', array($id));

		if(!empty($product)){
			$product=true;
		}else{
			$product=false;
		}

		return $product;
	}

	public static function findPromotionById($id){
		$product=  R::getRow( 'SELECT id FROM promotion WHERE id=?', array($id));

		if(!empty($product)){
			$product=true;
		}else{
			$product=false;
		}

		return $product;
	}
}