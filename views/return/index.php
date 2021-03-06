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

		<h2>ПОВЕРНЕННЯ</h2>
	<p>Для всіх замовлень діє звичайна умова повернення протягом 365 днів. Товари, які повертаються, не повинні бути пошкодженими або зношеними. Усі оригінальні етикетки та ярлики повинні залишитися.</p>

	<p>Повернути товари можна в наш інтернет-магазині, дотримуючись визначеного порядку:<br>
- ЗАПОВНІТЬ форму повернення, яку знаходиться у Вашому профілі клієнта на сайті.<br>
- УПАКУЙТЕ товари, які повертаєте - Ви можете використати упаковку, в якій отримали замовлення.<br>
- Також необхідно вкласти заповнену форму повернення товарів, яку Ви отримали в посилці.<br></p>

	<p>Номер рахунку IBAN – це міжнародний номер рахунку, який можна знайти у реквізитах Вашої картки. Він починається з UA та далі йде 27 знаків. При оформленні форми повернення онлайн необхідно вказати номер рахунку IBAN фізичної особи (на номер рахунку юридичної особи та ФОП грошові кошти повернути неможливо). </p>
	<p>Дані які вказані далі являються вигаданими, тобто не дійсні.</p>

	<p>Далі Ви можете повернути товар разом із заповненим бланком:</p>

	<p>1. За допомогою кур'єрської служби «Мeest Express» на адресу:</p>
	 
	<p>Україна, 15325, м. Київ, вул. Косенка, 96,</p>

	<p>Отримувач - Васильчук Євген (LPP/Odyag),</p>

	<p>телефон +38 068 845 31 98.</p>

	<p>Для відправлення посилки за допомогою Мeest Express, виберіть послугу  "на Склад".</p>

	<p>2. За допомогою «Нової Пошти» на адресу:</p>

	<p>Відділення «Нова Пошта» № 8, Україна, 98461, м. Київ, вул. Кемеровська, 65,</p>
	
	<p>Отримувач - СП ВАСИЛЬЧУК (ПОВЕРНЕННЯ LPP/Odyag),</p>

	<p>Телефон Отримувача: +38 067 622 06 09</p>

	<p>3. За допомогою «Укрпошти» на адресу:</p>

	<p>CП Васильчук а/с 12 (LPP/Odyag), Україна, 98461, м. Київ, вул. Карельський 15,</p>

	<p>Телефон Отримувача: +38 068 845 31 98</p>

	<p>Послугу за повернення товару оплачує клієнт. У разі несплати посилка повернеться відправнику (клієнту). </p>

	<p>Протягом 14 робочих днів після отримання нами посилки Вам буде повернено кошти на Ваш рахунок.</p>

	<p>Повернення в роздрібні магазини Odyag недоступне. Приносимо вибачення за незручності.</p>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>