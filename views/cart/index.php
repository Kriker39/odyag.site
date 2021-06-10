<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('lazyloadxt.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('cart.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<?php if($check): ?>
<section class="cart">
	<div class="cart_list">
		<div class="cart_name"><h2>Кошик</h2><div><span class="cart_count_product"><?php echo count($listProduct); ?></span> ТОВАР(-И)</div></div>
		<div class="cart_info"><img src="/views/_img/icon_info.png">Не відкладайте купування. Додавання товарів у кошик не є бронюванням</div>
		<div class="cart_warning"><img src="/views/_img/icon_warning.png">Інтернет-магазин odyag.site не надає ніяких послуг. Даний сайт розроблений для виконання дипломної роботи.</div>
		<div>
			<ul class="cart_product_list">
				<?php 
					foreach($listProduct as $product){
						$size=0;
						foreach($newList as $idsize){
							if($idsize[0]==$product["id"]){
								$size= $idsize[1];
								unset($newList[array_search(array($idsize[0], $idsize[1]),$newList)]);
								break;
							}
						}
						echo "<li data-disc=\"";
						if($product["discount"]>0){
							echo $product["discount"];
						}else{
							echo $product["price"];
						}
						echo "\" data-price=\"".$product["price"]."\" data-count=\"1\" data-id=\"".$product["id"]."\" data-size=\"".$size."\"><div><img data-src=\"/data/product/img/tp".$product["tag"]."p".$product["id"]."/1.jpg\"></div>";
						echo "<div class=\"container_details\">
							<div class=\"cart_item_details\">
								<div class=\"cart_item_details_left\">
									<p class=\"cart_item_details_code\">Код: tp".$product["tag"]."p".$product["id"]."</p>
									<p>".$product["name"]." ".$product["company"]."</p>
									<p>Колір: <img src=\"/data/product/color/tp".$product["tag"]."p".$product["id"].".jpg\"></p>
									<p>Розмір: ".$size."</p>
								</div>
								<div class=\"cart_item_details_right\">
									<img src=\"/views/_img/cart_delete.png\" class=\"cart_icon_delete\">
								</div>
							</div>
							<div class=\"cart_item_sum\">
								<div class=\"cart_item_sum_left\">
									<input type=\"number\" min=\"1\" max=\"".$product["size"]."\" value=\"1\">
									<div class=\"cart_item_sum_error\">Вказана кількість товару наразі не доступна</div>	
								</div>
								<div class=\"cart_item_sum_right\">";
						if($product["discount"]>0){
							echo "<b>".$product["discount"]." UAH</b> <s>".$product["price"]." UAH</s>";
						}else{
							echo "<span>".$product["price"]." UAH</span>";
						}		
									
						echo "</div>
							</div><hr>
						</div></li>";
					}
				?>
			</ul>
		</div>
	</div>
	<div class="cart_accept">
		<div class="cart_accept_economy">Ви економите <span><?php echo $listSum["price"]-$listSum["discount"];?></span> UAH</div>
		<div class="cart_accept_price">
			<div>
				<div class="cart_accept_price_left">ЦІНА ТОВАРІВ</div>
				<div class="cart_accept_price_right"><span class="cart_priceProduct"><?php echo $listSum["discount"];?></span> UAH</div>
			</div>
			<div>
				<div class="cart_accept_price_left">ДОСТАВКА</div>
				<div class="cart_accept_price_right"><span class="cart_priceDelivery"><?php if($listSum["discount"]>=850){echo "0";}else{echo "125";}?></span> UAH</div>
			</div>
			<div class="cart_accept_sum">
				<div class="cart_accept_price_left">ЗАГАЛЬНА СУМА <span>ІЗ ПДВ</span></div>
				<div class="cart_accept_price_right"><span class="cart_priceLastPrice"><?php if($listSum["discount"]>=850){echo $listSum["discount"];}else{echo $listSum["discount"]+125;}?></span> UAH</div>
			</div>
		</div>
		<div class="btnCart cart_regOrder"><span>ПЕРЕЙТИ ДО ОФОРМЛЕННЯ</span><img src="/views/_img/loader2.gif"></div>
		<div class="cart_regOrder_error"></div>
		<div class="cart_accept_info">
			<h4>СПОСОБИ ОПЛАТИ</h4>
			<div><img src="/views/_img/icon_wallet.png"> Готівка</div>
			<div><img src="/views/_img/mastercard.png"><img src="/views/_img/visa.png"></div>
			<p>Замовлення  можуть бути повернені протягом 365 днів від моменту отримання.</p>
			<p>Безкоштовна доставка від 950 UAH</p>
			<p>Попереджаємо, якщо сума замовлення перевищує еквівалент 100 євро (враховуючи відправлення та кошти доставки), вартість посилки при отриманні буде залежати від додаткової оплати податку.</p>
		</div>
	</div>
</section>
<?php else: ?>
<div class="cart_empty_space_text">Кошик пустий</div>

<?php endif; ?>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>