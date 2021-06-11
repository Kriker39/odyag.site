<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('categories.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('lazyloadxt.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="products">
	<div class="category">
		<ul>
			<?php 
				foreach ($secondCategory as $val) {
					echo "<li><a href=\"/category/2/".$val["id"]."\">".mb_strtoupper($val["name"])."</a><ul>";
					foreach ($listCategory as $val2) {
						if( $val2["id_second_cat"]==$val["id"]){
							echo "<li><a href=\"/category/2/".$val["id"]."/".$val2["id"]."\">".$val2["name"]."</a></li>";
						}
					}
					echo "</ul></li>";
				}
			?>
		</ul>
	</div>

	<div class="product">
		<div class="container_filter">
			<div>
				Сортувати за:
				<div class="multiselect filter1">	
					<div class="container_select">
						<select>
							<option>Новизною</option>
						</select>
						<div class="overSelect"></div>
					</div>
					<ul class="checkboxes">
						<li><input type="radio" checked="checked" name="main"> <p>Новизною</p></li>
						<li><input type="radio"> <p>Популярністю</p></li>
						<li><input type="radio"> <p>Зростанням ціни</p></li>
						<li><input type="radio"> <p>Спаданням ціни</p></li>
					</ul>
				</div>
				Розмір:
				<div class="multiselect filter2">	
					<div class="container_select">
						<select>
							<option>Виберіть розмір</option>
						</select>
						<div class="overSelect"></div>
					</div>
					<ul class="checkboxes">
						<?php 
							foreach ($listSize as $val) {
								echo "<li><input type=\"checkbox\"> <p>".$val."</p></li>";
							}
						?>
					</ul>
				</div>
				<div class="reset_filter button_filter">
					СКИНУТИ ФІЛЬТР
				</div>
				<div class="submit_filter button_filter">
					ФІЛЬТРУВАТИ
				</div>
				<div class="empty_filter button_filter">
					|
				</div>
			</div>
		</div>
		<ul id="listProduct">
			<?php
				foreach ($listLastProduct as $val) {
					$price= intval($val["price"]);
					$discount= intval($val["discount"]);
					$endPrice= 0;

					if($discount==0){
						$endPrice=$price;	
					}else{
						$endPrice= round($price-($price*$discount/100));
					}

					echo "<li data-id=\"".$val["id"]."\" data-size=\"".$val["size"]."\" data-price=\"".$endPrice."\" data-views=\"".$val["views"]."\"> <a href=\"/product/tp".$val["tag"]."p".$val["id"]."\"> <img data-src=\"/data/product/img/tp".$val["tag"]."p".$val["id"]."/1.jpg\">";
					echo "<img class=\"secondImg\" data-src=\"/data/product/img/tp".$val["tag"]."p".$val["id"]."/2.jpg\">";
					echo "<p>".$val["name"]." ".$val["company"]."</p>";
					if($discount==0){
						echo "<p style=\"font-weight:bold;\">".$endPrice." UAH</p>";
					}else{
						echo "<p><s>".$price." UAH</s> <b style=\"color: red;\">".$endPrice." UAH</b></p>";
					}
					echo "</a></li>";
					
				}
			?>
		</ul>
	</div>
</section>
<div class="scrollup">
	<span>^</span>
</div>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>