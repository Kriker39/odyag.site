<?php

class Info{

	public static function getDataInfoByCategory($num){
		$info=  R::getAll( 'SELECT * FROM info WHERE status=1 AND category=?', array($num));

		return $info;
	}

}