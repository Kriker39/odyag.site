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

<section class="adminpanel">
	<h2>Адмін панель</h3>
	<a href="/admin/1" target="_blank">Замовлення</a>
	<a href="/admin/2" target="_blank">Товари</a>
	<a href="/admin/3" target="_blank">Акції</a>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>