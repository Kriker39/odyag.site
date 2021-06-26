<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('admin-promotion.js') ?>"></script>
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
	<div class="adminPage_addProduct"><div><span>Додати акцію</span><img src="/views/_img/loader2.gif"></div></div>
	<div class="adminPage_listOrder adminPage_listPromotion">
		<table>
			<tr>
				<td></td>
				<td>Номер</td>
				<td>Зображення</td>
				<td>Змінити</td>
				<td>Статус</td>
				<td>Детальніше</td>
			</tr>
			<?php foreach($listPromotion as $promotion): ?>
				<tr>
					<td class="adminPage_listOrder_btn adminPage_btnUpdate"><span>Оновити</span><img src="/views/_img/loader2.gif"></td>
					<td><?php echo $promotion["id"]; ?></td>
					<td><img src="/data/promotion/<?php echo $promotion["id"]; ?>.jpg" class="adminPage_imgPromotion"></td>
					<td><input type="file" name="addimg"></td>
					<td>
						<select  class="select_status">
							<option value="0" <?php if($promotion["status"]==0){echo "selected";} ?>>Сховано</option>
							<option value="1" <?php if($promotion["status"]==1){echo "selected";} ?>>Показано</option>
						</select>
					</td>
					<td class="adminPage_table1_showItem">></td>
				</tr>
				<tr class="adminPage_table2">
					<td colspan="6">
						<table class="adminPage_listProduct">
							<tr class="adminPage_table2_title">
								<td>Код</td>
								<td>Назва</td>
								<td>Зображення</td>
								<td></td>
							</tr>
							<?php foreach($promotion["products"] as $product): ?>
								<tr>
									<td><?php echo $product[0]; ?></td>
									<td><?php echo $product[1]; ?></td>
									<td><img src="/data/product/img/<?php echo $product[0]; ?>/1.jpg" class="adminPage_itemListImg"></td>
									<td class='adminPage_products_btn deleteItemListImg'><span>Видалити</span><img src='/views/_img/loader2.gif'></td>
								</tr>
							<?php endforeach; ?>
						</table>
						<table class="adminPage_addImg">
							<tr class="adminPage_table2_title">
								<td>Код</td>
								<td></td>
							</tr>
							<tr>
								<td><input type="text" name="code"></td>
								<td class='adminPage_products_btn addImg'><span>Додати</span><img src='/views/_img/loader2.gif'></td>
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