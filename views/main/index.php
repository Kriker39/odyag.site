<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo config::getLink('splide.css') ?>">
	<script type="text/javascript" src="<?php echo config::getLink('main.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('splide.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="promotion">			
	<div class="splide slider1">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach($listPromotion as $id){
					echo "<li class='splide__slide'><a href='/promotion/".$id."'><img src='/data/promotion/".$id.".jpg'></a></li>";
				} ?>
			</ul>
		</div>
		
		<div class="splide__progress">
			<div class="splide__progress__bar">
			</div>
		</div>
	</div>
</section>

<section class="productPopular">
	<p>Популярне</p>
	<div class="splide slider2">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach($listProductPopular as $product): ?>
					<li class="splide__slide">
						<div class="splide__slide__container">
							<a href="/product/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>">
								<div><img src="/data/product/img/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>/1.jpg"></div>
								<span><?php 
									if($product["discount"]>0){
										echo "<b>".$product["discount"]." UAH</b> <s>".$product["price"]." UAH</s>";
									}else{
										echo $product["price"];
									}
								?></span>
								<span><?php echo $product["company"]; ?></span>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<div class="splide__progress">
			<div class="splide__progress__bar">
			</div>
		</div>
	</div>
</section>

<section class="productNewForWoman">
	<p>Новинки для жінок</p>
	<div class="splide slider3">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach($listProductLastForWoman as $product): ?>
					<li class="splide__slide">
						<div class="splide__slide__container">
							<a href="/product/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>">
								<div><img src="/data/product/img/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>/1.jpg"></div>
								<span><?php 
									if($product["discount"]>0){
										echo "<b>".$product["discount"]." UAH</b> <s>".$product["price"]." UAH</s>";
									}else{
										echo $product["price"];
									}
								?></span>
								<span><?php echo $product["company"]; ?></span>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<div class="splide__progress">
			<div class="splide__progress__bar">
			</div>
		</div>
	</div>
</section>

<section class="productNewForMan">
	<p>Новинки для чоловіків</p>
	<div class="splide slider4">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach($listProductLastForMan as $product): ?>
					<li class="splide__slide">
						<div class="splide__slide__container">
							<a href="/product/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>">
								<div><img src="/data/product/img/<?php echo "tp".$product["tag"]."p".$product["id"]; ?>/1.jpg"></div>
								<span><?php 
									if($product["discount"]>0){
										echo "<b>".$product["discount"]." UAH</b> <s>".$product["price"]." UAH</s>";
									}else{
										echo $product["price"];
									}
								?></span>
								<span><?php echo $product["company"]; ?></span>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<div class="splide__progress">
			<div class="splide__progress__bar">
			</div>
		</div>
	</div>
</section>

<?php include(config::getLink("footer.php")); ?>

<script>
	document.addEventListener( 'DOMContentLoaded', function () {
		new Splide( '.splide' ).mount();
	} );
</script>
</body>
</html>