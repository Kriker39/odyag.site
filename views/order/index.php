<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('lazyloadxt.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('order.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="orderPage">
	<div class="order_data">
		<div class="order_name"><h2>Оформлення замовлення</h2></div>
		<div class="order_warning"><img src="/views/_img/icon_warning.png">Інтернет-магазин odyag.site не надає ніяких послуг. Даний сайт розроблений для виконання дипломної роботи.</div>
		<div class="deliveryRadio order_data_section">
			<h3>Спосіб доставки</h3>
			<div class="deliveryRadio_name" id="curier"><input type="radio" name="delivery" checked> Кур'єр</div>
			<div class="deliveryRadio_item active">
				Адреса доставки: <input type="text" name="address">
			</div>
			<div class="deliveryRadio_name" id="punktvidachi"><input type="radio" name="delivery"> Пункт видачі</div>
			<div class="deliveryRadio_item">
				<select class="addressSelect_delivery">
					<option value="1">вулиця Михайла Омеляновича-Павленка, 1</option>
					<option value="2">вулиця Митрополита Андрея Шептицького, 4 А</option>
				</select>
				<div class="order_map">
					<iframe class="map1 active" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12086.271319713198!2d30.540851382798746!3d50.444349858803314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x480dab17a69b013f!2z0J3QsNGG0ZbQvtC90LDQu9GM0L3QuNC5INGC0YDQsNC90YHQv9C-0YDRgtC90LjQuSDRg9C90ZbQstC10YDRgdC40YLQtdGC!5e0!3m2!1suk!2sua!4v1623762553881!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					<iframe class="map2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3021.147830447748!2d30.59622147841493!3d50.45092768187771!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xfdfd2434a0f41ec3!2z0KLQoNCmIEtPTU9E!5e0!3m2!1suk!2sua!4v1623768486771!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>
			</div>
			<div class="deliveryRadio_name" id="post"><input type="radio" name="delivery"> Пошта</div>
			<div class="deliveryRadio_item">
				<select>
					<option value="novaposhta">Нова пошта</option>
					<option value="ukrposhta">Укрпошта</option>
				</select>
				<div>Номер відділення: <input type="number" name="delivery_num"></div>
			</div>
		</div>
		<div class="typePay order_data_section">
			<h3>Спосіб оплати</h3>
			<div><input type="radio" name="type_pay" checked> Готівкою</div>
		</div>
		<div class="infoClient order_data_section">
			<h3>Інформація про замовника</h3>
			<div>
				<div class="infoClient_left">
					<div>Ім'я:</div>
					<div>Прізвище:</div>
					<div>По батькові:</div>
					<div>Номер телефону:</div>
				</div>
				<div class="infoClient_right">
					<div><input type="text" name="name"></div>
					<div><input type="text" name="secondname"></div>
					<div><input type="text" name="lastname"></div>
					<div>+380 (<input type="number" name="phoneid" min="0" max="99">) <input type="number" name="phonenumber" min="0" max="9999999"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="order_accept">
		<div class="order_accept_price">
			<div>
				<div class="order_accept_price_left">ЦІНА ТОВАРІВ</div>
				<div class="order_accept_price_right"><span class="order_priceProduct">222</span> UAH</div>
			</div>
			<div>
				<div class="order_accept_price_left">ДОСТАВКА</div>
				<div class="order_accept_price_right"><span class="order_priceDelivery">222</span> UAH</div>
			</div>
			<div class="order_accept_sum">
				<div class="order_accept_price_left">ЗАГАЛЬНА СУМА <span>ІЗ ПДВ</span></div>
				<div class="order_accept_price_right"><span class="order_priceLastPrice">222</span> UAH</div>
			</div>
		</div>
		<div class="btnOrder order_addOrder"><span>ОФОРМИТИ ЗАМОВЛЕННЯ</span><img src="/views/_img/loader2.gif"></div>
		<div class="order_addOrder_error"></div>
		<div class="order_accept_info">
			<p>Оформляючи замовлення на cropp.com, Ви погоджуєтесь з  нашими Умовами і положеннями.</p>
			<p>Попереджаємо, якщо сума замовлення перевищує еквівалент 100 євро (враховуючи відправлення та кошти доставки), - вартість посилки при отриманні буде залежати від додаткової оплати податку.</p>
			<p>Просимо надавати достовірні дані (ім’я та прізвище) для успішного отримання замовлення.</p>
			<div class="shortInfoProducts">
				<div class="btn_shortInfoProducts">ТОВАРИ <span>></span>  <div class="order_count_product"><span>1</span> ТОВАР(-И)</div></div>
				<div class="shortInfoProducts_list">
					<div>
						<div><img src="/data/product/img/tp1p1/1.jpg"></div>
						<div>
							<p>Name company</p>
							<p>Колір: <img src="/data/product/color/tp1p1.jpg"></p>
							<p>Розмір: XL</p>
							<p>К-сть: 1</p>
							<p>Код: tp1p1</p>
						</div>
					</div>
					<div>
						<div><img src="/data/product/img/tp1p1/1.jpg"></div>
						<div>
							<p>Name company</p>
							<p>Колір: <img src="/data/product/color/tp1p1.jpg"></p>
							<p>Розмір: XL</p>
							<p>К-сть: 1</p>
							<p>Код: tp1p1</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>