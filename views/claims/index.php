<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo config::getLink('splide.css') ?>">
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="info">
	<div class="infoMenu">
		<div>
			<h4>ІНТЕРНЕТ-МАГАЗИН</h4>
			<ul>
				<?php
					foreach ($infoDataCategory1 as $val) {
						echo "<li><a ";
						if($val['tag']==$activeItem){
							echo "class=\"active\"";
						}else{
							echo "href=\"/info/".$val['tag']."\"";
						}
						echo ">".$val["name"]."</a></li>";
					}
				?>
			</ul>
		</div>
		<div>
			<h4>ПРАВИЛА</h4>
			<ul>
				<?php
					foreach ($infoDataCategory2 as $val) {
						echo "<li><a ";
						if($val['tag']==$activeItem){
							echo "class=\"active\"";
						}else{
							echo "href=\"/info/".$val['tag']."\"";
						}
						echo ">".$val["name"]."</a></li>";
					}
				?>
			</ul>
		</div>
	</div>

	<div class="infoText">

		<h2>ПРЕТЕНЗІЇ</h2>
	<p>Як відправити скаргу в інтернет-магазин?</p>

	<p>Якщо ти отримав товар з вадами, надішли, будь ласка, фотографію товару, опиши ситуацію та номер свого замовлення у листі та відправ на електронну адресу Відділу обслуговування клієнтів: contact.ua@cropp.com. Ми розглянемо твою скаргу та, якщо рішення буде позитивне, замовимо безкоштовного кур'єра, котрий забере у тебе товар. В такому випадку, ти отримаєш повернення коштів за цей товар на свій банківський рахунок IBAN.</p>

	<p>Упакуй товар та додай до нього бланк повернення. Також необхідно заповнити онлайн форму повернення, котра знаходиться в розділі МОЇ ЗАМОВЛЕННЯ - ДЕТАЛІ - ПОВЕРНЕННЯ.</p>

	<p>Якщо тобі потрібні інструкції щодо завантаження рахунку з панелі користувача, вони подані нижче:</p>

	<p>1. Увійди до свого облікового запису, натисни на символ людини (ТВІЙ ОБЛІКОВИЙ ЗАПИС).<br>
2. Вибери вкладку "МОЇ ЗАМОВЛЕННЯ".<br>
3. Розгорни ДЕТАЛІ після переходу до відповідного замовлення.<br>
4. Натисни кнопку Я ХОЧУ ОТРИМАТИ рахунок-фактура.<br>
5. Натисни ЗАВАНТАЖИТИ у вікні, що відображається, з номером документа.<br></p>
	 
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>