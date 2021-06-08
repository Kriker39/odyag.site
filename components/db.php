<?php
	require ROOT.'/components/lib/rb.php';

	$server= config::getDB('server');
	$name_db= config::getDB('name_db');

	R::setup("mysql:host={$server};dbname={$name_db}", config::getDB('name_user'), config::getDB('password'));
?>