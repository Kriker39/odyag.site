<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('lazyloadxt.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('constructor.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="constructorPage">
	<div class="constructor_infoLoadCart"><img src="/views/_img/icon_info.png"> Щоб більш точніше приміряти товар, фото потрібно обрізати вгорі і знизу впритул до голови і ніг відповідно</div>
	<div class="container_display">
		<div class="display">
			<img src="/views/_img/maniken_woman.png" class="display_background" alt="Зображення не завантажилось">
			<!-- <div class="displayitem" data-id="tp1p1-XL"><img src="/data/product/constructor/tp1p1/1.png"></div> -->
		</div>
		<div class="showMenu">
			<h3>Список виведених товарів</h3>
			<ul>
			</ul>
		</div>
	</div>
	<div class="container_settings">
		<div class="settings">
			<h3>Налаштування</h3>
			<div>
				<div>Зріст (від 100 до 250 см): </div>
				<div><input type="number" min="100" max="250" value="170" class="input_height"><div class="constructor_submitHeight constr_btn">Змінити</div></div>
			</div>
			<div class="constructor_radio sett_gender">
				<div>Стать:	</div>
				<div><input type="radio" class="input_gender" name="gender" checked id="woman">Жіноча</div>
				<div><input type="radio" class="input_gender" name="gender" id="man">Чоловіча</div>
				<div><input type="radio" class="input_gender" name="gender" id="womanmore">Жіноча(x3)</div>
				<div><input type="radio" class="input_gender" name="gender" id="manmore">Чоловіча(x3)</div>
			</div>
			<div class="constructor_radio sett_photo disabled">
				<div>Фото:	</div>
				<div><input type="radio" class="input_photo" name="photo" id="maniken" checked>Манікен</div>
				<div><input type="radio" class="input_photo" name="photo" id="loaded">Завантажене</div>
			</div>
			<div>
				<div>Завантажити фото:	</div>
				<div><input type="file" name="downloadPhoto"></div>
				<div><input type="text" name="linkPhoto" title="http://example.com"><div class="constructor_loadPhoto constr_btn">Посилання</div></div>
			</div>
			<div>
				<div>Оновити:	</div>
				<div><div class="constructor_updateListProduct constr_btn"><div class="upd_timer"></div><span>Cписок обраних товарів</span><img class="btnLoadUpdate" src="/views/_img/loader2.gif"><img class="btnDone" src="/views/_img/accept_add.png"></div></div>
			</div>
		</div>
		<div class="list_product">
			<h3>Список обраних товарів 
				<?php if($check):?>
					<div><span><?php echo count($listProduct); ?></span> ТОВАР(-И)</div>
				<?php endif;?>
			</h3>
			<div class="list_selectProduct">
				<ul>
					<?php 
						if(!$check){
							echo "<div class=\"constructor_emptyCart\"><img src=\"/views/_img/icon_info.png\"> У кошику порожньо</div>";
						}else{
							foreach($listProduct as $product){
								$size=0;
								foreach($newList as $idsize){
									if($idsize[0]==$product["id"]){
										$size= $idsize[1];
										unset($newList[array_search(array($idsize[0], $idsize[1]),$newList)]);
										break;
									}
								}
								echo "<li data-id=\"tp".$product["tag"]."p".$product["id"]."-".$size."\" data-length=\"".$product["length"]."\" data-lenimg=\"1\">
									<img data-src=\"/data/product/img/tp".$product["tag"]."p".$product["id"]."/1.jpg\" class=\"constructor_imgItem2\">
									<div>
										<p>".$product["name"]."</p>
										<p>Колір: <img src=\"/data/product/color/tp".$product["tag"]."p".$product["id"].".jpg\"></p>
										<p>Розмір: ".$size."</p>
										<p>Код: tp".$product["tag"]."p".$product["id"]."</p>
									</div>
									<div class=\"list_product_plus\">
										<div class=\"plus_symbol\">+</div>
										<div class=\"plus_shadow\"></div>
									</div>
								</li>";
							}
						}
					?>
				</ul>
			</div>
		</div>
		<div class="constructor_info">
			<h3>Інформація</h3>
			<h4>Завантаження фото</h4>
			<p>У конструкторі є можливість завантажити зображення або вказати посилання на нього. Завантажені зображення не зберігаються. Щоб більш точніше приміряти товар, фото потрібно обрізати вгорі і знизу впритул до голови і ніг відповідно.</p>
			<h4>Вікно примірки</h4>
			<p>У цьому вікні можна переміщати одяг який був доданий в конструктор.</p>
			<h4>Список виведених товарів</h4>
			<p>У списку знаходяться товари які були зображені у <i>вікні примірки</i>. Щоб сховати товар, потрібно натиснути на нього у списку.</p>
			<h4>Налаштування</h4>
			<p>Деякі можливості змінювати налаштування конструктора. Серед них можливість: змінити ріст моделі у <i>вікні примірки</i>, обрати стать манікену, переключатись між манікеном і завантаженим зображенням і кнопка оновлення <i>списку обраних товарів</i>.</p>
			<h4>Список обраних товарів</h4>
			<p>У списку знаходяться товари які можна додати у <i>список виведених товарів</i>. Щоб у цьому списку з'явились товари, їх потрібно додати у кошик. Тобто, у даному списку знаходяться товари із кошику.</p>
			<h4>Інформація</h4>
			<p>Розділ з коротким поясненням елементів конструктора одягу. Для більше детальної інформації у <a href="/info/constructor">FAQ Конструктор</a></p>
		</div>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>