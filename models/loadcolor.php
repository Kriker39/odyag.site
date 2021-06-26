<?php 
$error = "true";
// Название <input type="file">
if(!isset($_POST['imgname'])){
	$error = 'Назва не завантажена.';
} else {
	// Разрешенные расширения файлов.
	$allow = array("jpg");
	 
	// Запрещенные расширения файлов.
	$deny = array(
		'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp', 
		'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html', 
		'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi', 'exe'
	);
	$code=$_POST['imgname'];

	// Директория куда будут загружаться файлы.
	$path = realpath(dirname(__FILE__) . '/..').'/data/product/color';

	if (!isset($_FILES["img"])) {
		$error = 'Файл не завантажений.';
	} else {
		$file = $_FILES["img"];
	 
		// Проверим на ошибки загрузки.
		if (!empty($file['error']) || empty($file['tmp_name'])) {
			$error = 'Не вдалося завантажити файл.';
		} elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
			$error = 'Не вдалося завантажити файл.';
		} else {
			// Оставляем в имени файла только буквы, цифры и некоторые символы.
			$pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
			$name = mb_eregi_replace($pattern, '-', $file['name']);
			$name = mb_ereg_replace('[-]+', '-', $name);
			$parts = pathinfo($name);
	 
			if (empty($name) || empty($parts['extension'])) {
				$error = 'Недоступний тип файлу';
			} elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
				$error = 'Недоступний тип файлу';
			} elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
				$error = 'Недоступний тип файлу';var_dump("3");
			} else {
				// Перемещаем файл в директорию.
				if (move_uploaded_file($file['tmp_name'], $path."/".$code.".jpg")) {
					// Далее можно сохранить название файла в БД и т.п.
					$success = '<p style="color: green">Файл успішно завантажений.</p>';
				} else {
					$error = 'Не вдалося завантажити файл.';
				}
			}
		}
	}
 
}

echo $error;
exit();