<header class="header">
	<a class="headerLogo" href="http://odyag.site" title="Головна"><img src="<?php echo config::getLinkImg("logo3.png"); ?>"></a>

	<div class="search">
		<div class="searchImg" title="Пошук"><a href="/search/"><img src="<?php echo config::getLinkImg("search.png"); ?>"></a></div>
		<div class="searchInput"><input type="text" name="searchTxt" onchange="changeLinkSearch(this)"></div>
		<hr>
	</div>

	<div class="profile">
		<div title="Вхід/реєстрація"><a href="/<?php echo User::getProfileLink(); ?>"><img src="<?php $linkimg=""; if(User::getProfileLink()=="profile"){$linkimg="1";} echo config::getLinkImg("profile".$linkimg.".png"); ?>"></a></div>
		<div title="<?php 
			if(!isset($_COOKIE["Cart"])){
				echo "Кошик";
			}else{
				echo "У кошику: ".count(explode(".",$_COOKIE["Cart"]));
			} 
		?>"><a href="/cart/"><img src="<?php 
			$linkimg=""; 
			if(isset($_COOKIE["Cart"])){
				$linkimg="1";
			} 
			echo config::getLinkImg("cart".$linkimg.".png"); 
		?>"></a></div>
	</div>

	<div class="categories">
		<ul class="categoryMenu1">

			<?php
				$firstCategory=Category::getFirstCategory();
				$secondCategory=Category::getSecondCategory();
				

				foreach ($firstCategory as $value) {
					echo "<li><a href=\"/category/".$value["id"]."\">".mb_strtoupper($value["name"])."</a>";
					if($value["name"]!="Конструктор"){
						echo "<div class=\"containerCategoryItems\">";
						echo "<ul class=\"categoryMenu2\">";
						foreach ($secondCategory as $value2) {
							echo "<li><a href=\"/category/".$value["id"]."/".$value2["id"]."\">".$value2["name"]."</a>";
							echo "<ul class=\"categoryMenu3\">";
							$thirdCategory=Category::getThirdCategory($value["id"], $value2["id"]);
							foreach ($thirdCategory as $value3){
								echo "<li><a href=\"/category/".$value["id"]."/".$value2["id"]."/".$value3["id"]."\">".$value3["name"]."</a></li>";
							}
							echo "</ul></li>";
						}
						echo "</ul>
							</div>
							<div class=\"categoryItemShadow\">
							</div>";
						}
						echo "</li>";
				}
			?>
		</ul>
	</div>
</header>
<div class="emptySpace"></div>