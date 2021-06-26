<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('admin-product.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>
<section class="adminPage_showImg">
	<div>
		<img src="/data/product/img/tp1p1/1.jpg">
	</div>
</section>
<section class="adminPage">
	<div class="adminPage_filterOrder"><h2>ТОВАРИ</h2></div>
	<div class="adminPage_addProduct"><div><span>Додати товар</span><img src="/views/_img/loader2.gif"></div></div>
	<div class="adminPage_listOrder adminPage_listProduct">
		<table>
			<tr>
				<td></td>
				<td>Номер</td>
				<td>Тег</td>
				<td>Назва</td>
				<td>Компанія</td>
				<td>Ціна, UAH</td>
				<td>Знижка, %</td>
				<td>Опис</td>
				<td>Матеріали</td>
				<td>Категорія</td>
				<td>Кноструктор</td>
				<td>Статус</td>
				<td>Перегляди</td>
				<td>Детальніше</td>
			</tr>
			<?php foreach($listProduct as $product): ?>
				<tr>
					<td class="adminPage_listOrder_btn adminPage_btnUpdate"><span>Оновити</span><img src="/views/_img/loader2.gif"></td>
					<td><?php echo $product["id"]; ?></td>
					<td><input type="number" name="tag" value="<?php echo $product["tag"]; ?>"></td>
					<td><textarea><?php echo $product["name"]; ?></textarea></td>
					<td><textarea><?php echo $product["company"]; ?></textarea></td>
					<td><input type="number" name="price" value="<?php echo $product["price"]; ?>"></td>
					<td><input type="number" min="1" max="100" name="discount" value="<?php echo $product["discount"]; ?>"></td>
					<td><textarea><?php echo $product["description"]; ?></textarea></td>
					<td><textarea><?php echo $product["material"]; ?></textarea></td>
					<td>
						<select>
							<?php foreach($listCategory as $category){
								echo "<option value=".$category[0];
								if($product["id_third_cat"]==$category[0]){
									echo " selected ";
								}
								echo ">".$category[1]."</option>";
							}?>
						</select>
					</td>
					<td data-input="0" data-img="0">
						<select  class="select_statusconstructor">
							<option value="0" <?php if($product["constructor_status"]==0){echo "selected";}?>>Недоступно</option>
							<option value="1" <?php if($product["constructor_status"]==1){echo "selected";}?>>Доступно</option>
						</select>
					</td>
					<td>
						<select  class="select_status">
							<option value="0" <?php if($product["status"]==0){echo "selected";}?>>Сховано</option>
							<option value="1" <?php if($product["status"]==1){echo "selected";}?>>Показано</option>
						</select>
					</td>
					<td><?php echo $product["views"]; ?></td>
					<td class="adminPage_table1_showItem">></td>
				</tr>
				<tr class="adminPage_table2">
					<td colspan="14">
						<table class="adminPage_listColor">
							<tr class="adminPage_table2_title">
								<td>Використовується</td>
								<td>Шаблон</td>
								<td>Зображення</td>
							</tr>
							<tr>
								<td class="adminPage_loadColor"><img <?php 
									$path= realpath(dirname(__FILE__) . '/../..')."/data/product/color/tp".$product["tag"]."p".$product["id"].".jpg";
									if(file_exists($path)){
										echo "src='/data/product/color/tp".$product["tag"]."p".$product["id"].".jpg'";
									}
								?>></td>
								<td class="adminPage_templateColor"><img src="/views/_img/templateColor.jpg"></td>
								<td><input type="file" name="addcolor"></td>
							</tr>
						</table>
						<table class="adminPage_listSize">
							<tr class="adminPage_table2_title">
								<td>Розмір</td>
								<td>Кількість</td>
								<td>Висота товару, см</td>
								<td></td>
							</tr>
							<?php foreach($product["size"] as $key=>$size):?>
								<tr>
									<td><?php echo $size[1]; ?></td>
									<td><input type="number" name="sizeimg" value="<?php echo $size[0]; ?>"></td>
									<td><input type="number" name="lengthimg" value="<?php echo $product["length"][$key][0]; ?>"></td>
									<td class="adminPage_products_btn deleteItemListSize">Видалити</td>
								</tr>
							<?php endforeach;?>
						</table>
						<table class="adminPage_addSize">
							<tr class="adminPage_table2_title">
								<td>Розмір</td>
								<td>Кількість</td>
								<td></td>
							</tr>
							<tr>
								<td><input type="text" name="namesize"></td>
								<td><input type="number" name="countsize"></td>
								<td class="adminPage_products_btn addItemListSize"><span>Додати</span></td>
							</tr>
						</table>
						<table class="adminPage_listImg">
							<tr class="adminPage_table2_title">
								<td>Зображення</td>
								<td></td>
							</tr>
							<?php 
								$path= realpath(dirname(__FILE__) . '/../..')."/data/product/img/tp".$product["tag"]."p".$product["id"];
								if(file_exists($path)){
									$dir = opendir($path);
									while($file = readdir($dir)){
									    if($file == '.' || $file == '..' || is_dir($path . $file) || preg_match("/.jpg$/", $file)!=1){
									        continue;
									    }else{
									    	echo "<tr>
												<td><img src='/data/product/img/tp".$product["tag"]."p".$product["id"]."/".$file."' data-num=".preg_replace("/.jpg$/", "", $file)."></td>
												<td class='adminPage_products_btn deleteItemListImg'><span>Видалити</span><img src='/views/_img/loader2.gif'></td>
											</tr>";
									    }
									}
								}
							?>
						</table>
						<table class="adminPage_table2_addImg">
							<tr class="adminPage_table2_title">
								<td>Шаблон</td>
								<td>Зображення</td>
							</tr>
							<tr>
								<td><img src="/views/_img/templateImg.jpg"></td>
								<td><input type="file" name="addimg"></td>
							</tr>
						</table>
						<table class="adminPage_table2_constructorImg">
							<tr class="adminPage_table2_title">
								<td>Використовується</td>
								<td>Шаблон</td>
								<td>Зображення</td>
							</tr>
							<tr>
								<td><img class="adminPage_constructorImg" <?php 
								$path= realpath(dirname(__FILE__) . '/../..')."/data/product/constructor/tp".$product["tag"]."p".$product["id"];
								if(file_exists($path)){
									$dir = opendir($path);
									while($file = readdir($dir)){
									    if($file == '.' || $file == '..' || is_dir($path . $file) || preg_match("/.png$/", $file)!=1){
									        continue;
									    }else{
									    	echo " src='/data/product/constructor/tp".$product["tag"]."p".$product["id"]."/".$file."'";
									    }
									}
								}
							?>></td>
								<td><img src="/views/_img/templateImg.jpg"></td>
								<td><input type="file" name="addimg"></td>
							</tr>
						</table>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>