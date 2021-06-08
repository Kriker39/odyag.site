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

		<h2>ОПЛАТА</h2>
	<p>У нашому інтернет-магазині Ви можете оплатити замовлення готівкою при отриманні.</p>

	<p>Вартiсть доставки: 110 UAH (з ПДВ)</p>

	<p>Замовлення на суму від 950 UAH доставляються стандартною кур’єрською службою безкоштовно.</p>

	<p>У випадку, якщо кількість замовлень є рівним або перевищує суму, еквівалентну 100 євро (враховуючи відправлення та кошти доставки), та країною призначення є Україна, тоді продавець зобов'язаний попередити покупця (до розміщення замовлення), що вартість при отриманні посилки може залежати від додаткової оплати податку на території одержувача. За детальнішою інформацією покупець повинен зв'язатися із Національним податковим органом, який є компетентним у даному питанні.</p>

	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>