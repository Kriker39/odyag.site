<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
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
				<li class="active">
					<a>Мої замовлення</a>
				</li>
				<li>
					<a href="/profile/comeback">Мої повернення</a>
				</li>
				<li>
					<a href="/profile/info">Особисті дані</a>
				</li>
				<?php if($admin): ?>
					<li class="profilePage_adminPanel">
						<a href="/admin">Адмін панель</a>
					</li>
				<?php endif; ?>
				<li class="saveSignIn" title="30 днів після включення">
					<div><input type="checkbox"> Зберегати вхід</div>
				</li>
				<li>
					<div class="exitProfile">Вийти</div>
				</li>
			</ul>
		</div>
		<div class="data_profile">
				<?php 
					if($listOrder!="empty"){
						echo "<table>
				<tr><td>Номер</td><td>Дата</td><td>Одержувач</td><td>Сума</td><td>Статус</td><td>Деталі</td></tr>";
						foreach ($listOrder as $key => $order) {
							echo "<tr class=\"main".$key."\"><td>".$order["id"]."</td><td>".$order["date"]."</td><td>".$order["recipient"]."</td><td>".$order["sum"]."</td><td>".$order["status_order"]."</td><td class=\"table_showItem\"> ></td></tr>";
							echo "<tr class=\"table_item item".$key."\">
									<td colspan=\"6\">
										<table>
											<tr class='data_profile_infoOrderMain'><td>Назва</td><td>Колір</td><td>Розмір</td><td>Ціна</td><td>К-сть</td><td>Сума</td></tr>";
							foreach ($listProduct[$key] as $key2 => $product) {
								$sum= (int)$product[2]*(int)$product[3];
								
								echo "<tr><td><a href=\"/product/tp".$product[6]."p".$product[0]."\">".$product[4]." ".$product[5]."</a></td><td><img src=\"/data/product/color/tp".$product[6]."p".$product[0].".jpg\"></td><td>".$product[1]."</td><td>".$product[2]." UAH</td><td>".$product[3]."</td><td>".$sum." UAH</td></tr>";		
							}
							echo "<tr><td colspan='7'><hr></td></tr>";
							echo "<tr><td>Адреса доставки:</td><td colspan='5'>".$order["address_delivery"]."</td></tr>";
							echo "<tr><td>Номер телефону:</td><td colspan='5'>".$order["number"]."</td></tr>";
							echo "<tr><td>Спосіб доствки:</td><td colspan='2'>".$order["method_delivery"]."</td><td>Спосіб оплати:</td><td colspan='2'>".$order["method_pay"]."</td></tr>";
							echo "</table>
									</td>
								</tr>";
						}
						echo "</table>";
					}else{
						echo "<div class='cart_empty_space_text'>Список замовлень пустий</div>";
					}
				?>
			
		</div>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>