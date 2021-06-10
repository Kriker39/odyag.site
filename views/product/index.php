<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('product.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="productPage">
	<div class="product_slider">
		<div class="product_slider_up">
			<div class="product_slider_list">
				<?php
					for($i=1; $i<=$countImg; $i++){
						echo "<img src=\"/data/product/img/tp".$tag."p".$id."/".$i.".jpg\" class=\"product_slider_listItem ";
						if($i==1){
							echo "active";
						}
						echo "\">";
					}
				?>
			</div>
			<div class="product_slider_image">
				<img src="/data/product/img/tp<?php echo $tag."p".$id; ?>/1.jpg" class="product_slider_showimg">
				<img src="/views/_img/left.png" class="product_slider_left product_slider_button">
				<img src="/views/_img/right.png" class="product_slider_right product_slider_button">
			</div>
		</div>
		<div class="product_slider_down">
			<div class="product_shortInfo">
				<h3>ОПИС</h3>
				<pre><?php echo $dataProduct["description"]; ?></pre>
			</div>
			<div class="product_shortInfo">
				<h3>СКЛАД</h3>
				<pre><?php echo $dataProduct["material"]; ?></pre>
			</div>
		</div>
	</div>
	<div class="product_info">
		<div class="product_code">Код: <?php echo "tp".$tag."p",$id;?></div>
		<div class="product_name"><?php echo $dataProduct["name"];?></div>
		<div class="product_company"><?php echo $dataProduct["company"];?></div>
		<div class="product_price"><?php 
			if($dataProduct["discount"]!=0){
				echo "<b>".$dataProduct["discount"]." UAH</b> <s>".$dataProduct["price"]." UAH</s>";
			}else{
				echo "<span>".$dataProduct["price"]." UAH</span>";
			}
		?></div>
		<div>Колір:
			<div class="product_listColor">
				<?php 
					foreach($listIdConnectByTag as $idval){
						echo "<a ";
						if($idval==$id){
							echo "class=\"active\"";
						}else{
							echo "href=\"/product/tp".$tag."p".$idval."\"";
						}
						echo "><img src=\"/data/product/color/tp".$tag."p".$idval.".jpg\"></a>";
					}
				?>
			</div>
		</div>
		<div>Розмір:
			<div class="multiselect filterSize">	
				<div class="container_select">
					<select>
						<option>Виберіть розмір</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<ul class="checkboxes">
					<?php 
						foreach($listSize as $val){
							echo "<li data-count=\"".$val[0]."\"><p>".$val[1];
							if($val[0]==0){
								echo "<span>немає в наявності</span>";
							}
							echo "</p></li>";
						}
					?>
				</ul>
			</div>
		</div>
		<div class="container_product_addProduct">
			<?php if($status==1 && !$checkEndSize): ?>
			<img src="/views/_img/accept_add.png" class="product_addProduct_accept">
			<div class="product_addProduct"><p>ДОДАТИ У КОШИК</p><img src="/views/_img/loader2.gif"></div>
			<?php elseif($status==0 || $checkEndSize): ?>
			<div class="product_addProduct 	product_btnEnd"><p>НЕ МАЄ В НАЯВНОСТІ</p></div>
			<?php endif; ?>
			<div class="product_addProduct_error">Не вдалося додати у кошик</div>
		</div>
		<?php 
			if($dataProduct["constructor_status"]==1){
				echo "<div class=\"product_constructorIcon\"><img src=\"/views/_img/icon_constructor.png\"></div>";
			}
		?>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>