<?php 
class Constructor{
	public static function getListProductForConstructor($listIdSize){
		$listId= array();
		$newListIdSize= $listIdSize;
		foreach($listIdSize as $item){
			if(count($item)>0){
				array_push($listId, $item[0]);
			}
		}

		$rslt= R::getAll("SELECT id, tag, name, company, size, length FROM product WHERE id IN (".R::genSlots($listId).")", $listId);

		$newRslt= array();

		foreach ($listId as $value) {
			foreach($rslt as $val){
				if(in_array($value, $val)){
					array_push($newRslt, $val);
					break;
				}
			}
		}

		for($i=0; $i<count($newRslt); $i++){
			$listSize= explode("-", $newRslt[$i]["length"]);

			foreach($newListIdSize as $idsize){
				if($idsize[0]==$newRslt[$i]["id"]){
					foreach($listSize as $size){
						$countsize= explode(".", $size);
						if(count($countsize)>1 && $idsize[1]==$countsize[1]){
							$newRslt[$i]["length"]= $countsize[0];
							unset($newListIdSize[array_search($idsize, $newListIdSize)]);
							break 2;
						}
					}
				}
			}
		}

		return $newRslt;
	}
	
}