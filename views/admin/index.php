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
	<a href="/admin/1">Замовлення</a>
	<a href="/admin/2">Товари</a>
	<a href="/admin/3">Акції</a>
	<a href="/admin/4">Користувачі</a>
	<a href="/admin/5">Категорії</a>
</section>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>