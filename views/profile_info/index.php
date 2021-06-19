<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('profile.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('lazyloadxt.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="profilePage">
	<div class="container_profileInfo">
		<div class="menu_profile">
			<h3>ПРОФІЛЬ</h3>
			<ul>
				<li>
					<a href="/profile">Мої замовлення</a>
				</li>
				<li>
					<a href="/profile/comeback">Мої повернення</a>
				</li>
				<li class="active">
					<a>Особисті дані</a>
				</li>
				<li class="saveSignIn" title="30 днів після включення">
					<div><input type="checkbox"> Зберегати вхід</div>
				</li>
				<li>
					<div class="exitProfile">Вийти</div>
				</li>
			</ul>
		</div>
		<div class="info_profile">
			<div class="info_profile_updateInfoError">
				<div class="info_profile_left"></div>
				<div class="info_profile_right">Gjverror</div>
			</div>
			<div>
				<div class="info_profile_left"></div>
				<div class="info_profile_right"><div class="btrSaveUserInfo"><span>ЗБЕРЕГТИ ЗМІНИ</span><img src="/views/_img/loader2.gif"></div><img src="/views/_img/accept_add.png" class="product_updateInfo_accept"></div>
			</div>
			<div>
				<div class="info_profile_left">Ім'я:</div>
				<div class="info_profile_right"><input type="text" name="name" value="<?php echo $dataUser["name"]; ?>"></div>
			</div>
			<div>
				<div class="info_profile_left">Прізвище:</div>
				<div class="info_profile_right"><input type="text" name="secondname" value="<?php echo $dataUser["second_name"]; ?>"></div>
			</div>
			<div>
				<div class="info_profile_left">По батькові:</div>
				<div class="info_profile_right"><input type="text" name="lastname" value="<?php echo $dataUser["last_name"]; ?>"></div>
			</div>
			<div class="info_profile_hr">
				<div class="info_profile_left"><hr></div>
				<div class="info_profile_right"><hr></div>
			</div>
			<div>
				<div class="info_profile_left">Номер телефону:</div>
				<div class="info_profile_right">+380 (<input type="number" name="phoneid" min="0" max="99"  value="<?php if(isset($dataUser["codenumber"])){echo $dataUser["codenumber"];} ?>">) <input type="number" name="phonenumber" min="0" max="9999999"  value="<?php if(isset($dataUser["number"])){echo $dataUser["number"];} ?>"></div>
			</div>
			<div class="info_profile_hr">
				<div class="info_profile_left"><hr></div>
				<div class="info_profile_right"><hr></div>
			</div>
			<div>
				<div class="info_profile_left">Спосіб доставки:</div>
				<div class="info_profile_right">
					<select class="select_methodDelivery">
						<option value="curier" <?php if($dataUser["method_delivery"]=="curier"){echo "selected";} ?>>Кур'єр</option>
						<option value="punktvidachi" <?php if($dataUser["method_delivery"]=="punktvidachi"){echo "selected";} ?>>Самовивіз</option>
						<option value="post" <?php if($dataUser["method_delivery"]=="post"){echo "selected";} ?>>Пошта</option>
					</select>
				</div>
			</div>
			<div class="info_profile_delivery" name="curier">
				<div class="info_profile_left">Адреса доставки:</div>
				<div class="info_profile_right"><input type="text" name="address_delivery"></div>
			</div>
			<div class="info_profile_delivery" name="punktvidachi">
				<div class="info_profile_left">Пункт видачі:</div>
				<div class="info_profile_right">
					<select class="addressSelect_delivery">
						<option value="1" <?php if($dataUser["address_delivery"]=="вулиця Михайла Омеляновича-Павленка, 1" ){echo "selected";} ?>>вулиця Михайла Омеляновича-Павленка, 1</option>
						<option value="2" <?php if($dataUser["address_delivery"]=="вулиця Митрополита Андрея Шептицького, 4 А" ){echo "selected";} ?>>вулиця Митрополита Андрея Шептицького, 4 А</option>
					</select>
				</div>
			</div>
			<div class="info_profile_delivery" name="punktvidachi">
				<div class="info_profile_left"></div>
				<div class="info_profile_right order_map">
					<iframe class="map1 active" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12086.271319713198!2d30.540851382798746!3d50.444349858803314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x480dab17a69b013f!2z0J3QsNGG0ZbQvtC90LDQu9GM0L3QuNC5INGC0YDQsNC90YHQv9C-0YDRgtC90LjQuSDRg9C90ZbQstC10YDRgdC40YLQtdGC!5e0!3m2!1suk!2sua!4v1623762553881!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					<iframe class="map2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3021.147830447748!2d30.59622147841493!3d50.45092768187771!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xfdfd2434a0f41ec3!2z0KLQoNCmIEtPTU9E!5e0!3m2!1suk!2sua!4v1623768486771!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>
			</div>
			<div class="info_profile_delivery" name="post">
				<div class="info_profile_left">Пошта:</div>
				<div class="info_profile_right">
					<select>
						<option value="novaposhta" <?php if($dataUser["method_delivery"]=="post" && $dataUser["address_delivery"]=="novaposhta"){echo "selected";} ?>>Нова пошта</option>
						<option value="ukrposhta" <?php if($dataUser["method_delivery"]=="post" && $dataUser["address_delivery"]=="ukrposhta"){echo "selected";} ?>>Укрпошта</option>
					</select>
				</div>
			</div>
			<div class="info_profile_delivery" name="post">
				<div class="info_profile_left">Номер відділення:</div>
				<div class="info_profile_right"><input type="number" name="delivery_num" min="0" max="9999999999" <?php if(isset($dataUser["numpost"])){echo "value='".$dataUser["numpost"]."'";} ?>></div>
			</div>

			
			<!-- <div class="info_profile_left">
				<p><div></div></p>
				<p>Ім'я: </p>
				<p>Прізвище: </p>
				<p>По батькові: </p>
				<hr>
				<p>Номер: </p>
				<p>Спосіб доставки: </p>
				<p class="info_profile_delivery" name="curier">Адрес доставки: </p>
				<p class="info_profile_delivery" name="punktvidachi">Пункт видачі: </p>
				<p class="info_profile_delivery" name="post">Пошта: </p>
				<p class="info_profile_delivery" name="post">Номер відділення: </p>
			</div>
			<div class="info_profile_right">

				<div><div class="btrSaveUserInfo"><span>ЗБЕРЕГТИ ЗМІНИ</span><img src="/views/_img/loader2.gif"></div></div>
				<div><input type="text" name="name"></div>
				<div><input type="text" name="secondname"></div>
				<div><input type="text" name="lastname"></div>
				<hr>
				<div>+380 (<input type="number" name="phoneid" min="0" max="99">) <input type="number" name="phonenumber" min="0" max="9999999"></div>
				<div>
					<select class="select_methodDelivery">
						<option value="curier">Кур'єр</option>
						<option value="punktvidachi">Самовивіз</option>
						<option value="post">Пошта</option>
					</select>
				</div>
				<div class="info_profile_delivery" name="curier"><input type="text" name="address_delivery"></div>
				<div class="info_profile_delivery" name="punktvidachi">
					<select class="addressSelect_delivery">
						<option value="1">вулиця Михайла Омеляновича-Павленка, 1</option>
						<option value="2">вулиця Митрополита Андрея Шептицького, 4 А</option>
					</select>
				</div>
				<div class="order_map info_profile_delivery" name="punktvidachi">
						<iframe class="map1 active" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12086.271319713198!2d30.540851382798746!3d50.444349858803314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x480dab17a69b013f!2z0J3QsNGG0ZbQvtC90LDQu9GM0L3QuNC5INGC0YDQsNC90YHQv9C-0YDRgtC90LjQuSDRg9C90ZbQstC10YDRgdC40YLQtdGC!5e0!3m2!1suk!2sua!4v1623762553881!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
						<iframe class="map2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3021.147830447748!2d30.59622147841493!3d50.45092768187771!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xfdfd2434a0f41ec3!2z0KLQoNCmIEtPTU9E!5e0!3m2!1suk!2sua!4v1623768486771!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					</div>
				<div class="info_profile_delivery" name="post">
					<select >
						<option value="novaposhta">Нова пошта</option>
						<option value="ukrposhta">Укрпошта</option>
					</select>
				</div>
				<div class="info_profile_delivery" name="post"><input type="number" name="delivery_num"></div>
			</div> -->
		</div>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>