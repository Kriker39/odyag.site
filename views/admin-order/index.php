<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('jquery.cookie.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('admin.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="adminPage">
	<div class="adminPage_filterOrder">
		Пошук: <input type="text" name="searchOrder">
	</div>
	<div class="adminPage_listOrder">
		<table>
			<tr>
				<td></td>
				<td>Номер</td>
				<td>Дата</td>
				<td>Отримувач</td>
				<td>Номер телефону</td>
				<td>Спосіб доставки</td>
				<td>Адреса доставки</td>
				<td>Спосіб оплати</td>
				<td>Сума</td>
				<td>Статус замовлення</td>
				<td>Детальніше</td>
			</tr>
			<?php foreach($listFullDataOrder as $order): ?>
			<tr>
				<td class="adminPage_listOrder_btn">Оновити</td>
				<td><?php echo $order[0]["id"]; ?></td>
				<td><?php echo explode(" ", $order[0]["date"])[0]."<br>".explode(" ", $order[0]["date"])[1]; ?></td>
				<td><textarea><?php echo $order[0]["recipient"]; ?></textarea></td>
				<td>+380 (<input type="number" name="phoneid" min="0" max="99"  value="<?php if(isset(explode("-", $order[0]["number"])[0])){echo explode("-", $order[0]["number"])[0];} ?>">) <input type="number" name="phonenumber" min="0" max="9999999"  value="<?php if(isset(explode("-", $order[0]["number"])[1])){echo explode("-", $order[0]["number"])[1];} ?>"></td>
				<td>
					<select  class="select_type_delivery">
						<option value="curier" <?php if($order[0]["method_delivery"]=="curier"){echo "selected";} ?>>Кур'єр</option>
						<option value="punktvidachi" <?php if($order[0]["method_delivery"]=="punktvidachi"){echo "selected";} ?>>Самовивіз</option>
						<option value="post" <?php if($order[0]["method_delivery"]=="post"){echo "selected";} ?>>Пошта</option>
					</select>
				</td>
				<td  class="type_delivery <?php if($order[0]["method_delivery"]=="curier"){echo "active";} ?>"><input type="text" name="address_post" value="<?php if($order[0]["method_delivery"]=="curier"){echo $order[0]["address_delivery"];} ?>"></td>
				<td class="type_delivery <?php if($order[0]["method_delivery"]=="punktvidachi"){echo "active";} ?>">
					<select>
						<option value="1" <?php if($order[0]["method_delivery"]=="punktvidachi" && $order[0]["address_delivery"]=="вулиця Михайла Омеляновича-Павленка, 1"){echo "selected";} ?>>вулиця Михайла Омеляновича-Павленка, 1</option>
						<option value="2" <?php if($order[0]["method_delivery"]=="punktvidachi" && $order[0]["address_delivery"]=="вулиця Митрополита Андрея Шептицького, 4 А"){echo "selected";} ?>>вулиця Митрополита Андрея Шептицького, 4 А</option>
					</select>
				</td>
				<td class="type_delivery <?php if($order[0]["method_delivery"]=="post"){echo "active";} ?>">
					<select>
						<option value="novaposhta" <?php if($order[0]["method_delivery"]=="post" && explode(".",  $order[0]["address_delivery"])[0]=="novaposhta"){echo "selected";} ?>>Нова пошта</option>
						<option value="ukrposhta" <?php if($order[0]["method_delivery"]=="post" && explode(".",  $order[0]["address_delivery"])[0]=="ukrposhta"){echo "selected";} ?>>Укрпошта</option>
					</select>
					 № <input type="number" name="post_number" value="<?php if($order[0]["method_delivery"]=="post"){echo explode(".",  $order[0]["address_delivery"])[1];} ?>">
				</td>
				<td>
					<select>
						<option>Готівка</option>
					</select>
				</td>
				<td><?php echo $order[0]["sum"]; ?> UAH</td>
				<td>
					<select>
						<option value="1" <?php if($order[0]["status_order"]=="1"){echo "selected";} ?>>Нове</option>
						<option value="2" <?php if($order[0]["status_order"]=="2"){echo "selected";} ?>>В обробці</option>
						<option value="3" <?php if($order[0]["status_order"]=="3"){echo "selected";} ?>>Відправлене</option>
						<option value="4" <?php if($order[0]["status_order"]=="4"){echo "selected";} ?>>Отримане</option>
						<option value="5" <?php if($order[0]["status_order"]=="5"){echo "selected";} ?>>Скасовано</option>
					</select>
				</td>
				<td>
					<select>
						<option value="1"  <?php if($order[0]["status"]=="1"){echo "selected";} ?>>Показано</option>
						<option value="0"  <?php if($order[0]["status"]=="0"){echo "selected";} ?>>Сховано</option>
					</select>
				</td>
				<td class="adminPage_table1_showItem">></td>
			</tr>
			<tr class="adminPage_table2">
				<td colspan="12">
					<table>
						<tr class="adminPage_table2_title">
							<td>Номер клієнта</td>
							<td>Ім'я</td>
							<td>Прізвище</td>
							<td>По батькові</td>
							<td>Номер телефону</td>
							<td>Логін</td>
							<td>Електронна пошта</td>
							<td>Статус</td>
						</tr>
						<tr>
							<td><?php echo $order[2]["id"]; ?></td>
							<td><?php echo $order[2]["name"]; ?></td>
							<td><?php echo $order[2]["second_name"]; ?></td>
							<td><?php echo $order[2]["last_name"]; ?></td>
							<td><?php
								$code="";
								$number="";
								if(isset(explode(".", $order[2]["number"])[0])){
									$code=explode(".", $order[2]["number"])[0];
								}
								if(isset(explode(".", $order[2]["number"])[1])){
									$number=explode(".", $order[2]["number"])[1];
								}
							 echo "+380 (".$code.") ".$number; 
							?></td>
							<td><?php echo $order[2]["login"]; ?></td>
							<td><?php echo $order[2]["email"]; ?></td>
							<td>
								<select>
									<option value="1" <?php if($order[2]["status"]=="1"){echo "selected";} ?>>Активний</option>
									<option value="0" <?php if($order[2]["status"]=="0"){echo "selected";} ?>>Заблокований</option>
								</select>
							</td>
						</tr>
					</table>
					<table class="adminPage_listProduct">
						<tr class="adminPage_table2_title">
							<td>Код</td>
							<td>Назва</td>
							<td>Колір</td>
							<td>Розмір</td>
							<td>Ціна</td>
							<td>К-сть</td>
							<td>Сума</td>
							<td></td>
						</tr>
						<?php foreach($order[1] as $product): ?>
							<tr data-delete="false" data-code="<?php echo "tp".$product["tag"]."p".$product["id"]; ?>" data-size="<?php echo $product["size"]; ?>" data-origin="1">
								<td><?php echo "tp".$product["tag"]."p".$product["id"]; ?></td>
								<td><a href="/product/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>"><?php echo $product["name"]." ".$product["company"]; ?></a></td>
								<td><img src="/data/product/color/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>.jpg"></td>
								<td><?php echo $product["size"]; ?></td>
								<td><?php echo $product["price"]; ?> UAH</td>
								<td><?php echo $product["count"]; ?></td>
								<td><?php echo $product["price"]*$product["count"]; ?> UAH</td>
								<td class="adminPage_listOrder_btn adminPage_btnDelete">Видалити</td>
							</tr>
						<?php endforeach; ?>
					</table>
					<table class="adminPage_table2_updateListProduct">
						<tr class="adminPage_table2_title">
							<td>Код</td>
							<td>Розмір</td>
							<td>Кількість</td>
							<td></td>
						</tr>
						<tr>
							<td><input type="text" name="update_code"></td>
							<td><input type="text" name="update_size"></td>
							<td><input type="number" name="update_count"></td>
							<td class="adminPage_listOrder_btn adminPage_btnAdd"><span>Додати</span><img src="/views/_img/loader2.gif"></td>
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