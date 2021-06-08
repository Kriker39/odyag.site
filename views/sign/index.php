<!DOCTYPE html>
<html>
<head>
	<?php include(config::getLink("head_tags.php")); ?>
	<script type="text/javascript" src="<?php echo config::getLink('router.js') ?>"></script>
	<script type="text/javascript" src="<?php echo config::getLink('sign.js') ?>"></script>
</head>
<body>
<?php include(config::getLink("header.php")); ?>

<section class="sign">
	<div class= "container_sign container_signIn">
		<div class="signIn">
			<h3>ВХІД</h3>
			<div class="signInInput signInput">
				<p>Логін: </p>
				<input type="text" name="login">
				<p>Пароль: </p><img class="showHidePass" src="/views/_img/hide.png" href="/views/_img/show.png">
				<input type="password" name="password">
				<div class="signButton signInButton">ВХІД</div>
				<p class="forgotPass">Я забув(-ла) свій пароль</p>
			</div>
		</div>
	</div>
	<div class= "container_sign container_signUp">
		<div class="signUp">
			<h3>РЕЄСТРАЦІЯ</h3>
			<div class="signUpInput signInput">
				<p>Електронна пошта: </p>
				<input type="text" name="email">
				<p>Логін: </p>
				<input type="text" name="login">
				<p>Пароль: </p><img class="showHidePass" src="/views/_img/hide.png" href="/views/_img/show.png">
				<input type="password" name="password">
				<div class="signButton signUpButton">РЕЄСТРАЦІЯ</div>
			</div>
		</div>
	</div>
</section>

<div class="boardSign">
	<div class="shadow_boardSign"></div>
	<div class="content_boardSign">
		<h3>Скинути пароль</h3>
		<p>Електронна пошта</p>
		<input type="text" name="email">
		<div class="signButton resetPassButton">НАДІСЛАТИ</div>
	</div>
</div>

<?php include(config::getLink("footer.php")); ?>
</body>
</html>