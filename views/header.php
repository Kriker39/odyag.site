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
						</div>
						</li>";
				}
			?>
			<!-- <li><a href="/category/1">НОВИНКИ</a>	
				<div class="containerCategoryItems">
					<ul class="categoryMenu2">
						<li><a href="/category/1/1">Одяг</a></li>	
						<li><a href="/category/1/2">Взуття</a></li>
						<li><a href="/category/1/3">Аксесуари</a></li>	
					</ul>
				</div>
				<div class="categoryItemShadow">
				</div>
			</li>
			<li><a href="/category/2">ЖІНКАМ</a>	
				<div class="containerCategoryItems">
					<ul class="categoryMenu2">
						<li><a href="/category/2/1">Одяг</a>	
							<ul class="categoryMenu3">
								<li><a href="/category/2/1/1">Футболки</a></li>	
								<li><a href="/category/2/1/2">Сукні</a></li>	
								<li><a href="/category/2/1/3">Джинси</a></li>	
								<li><a href="/category/2/1/4">Шорти</a></li>	
							</ul>
						</li>
						<li><a href="/category/2/2">Взуття</a>	
							<ul class="categoryMenu3">
								<li><a href="/category/2/2/1">Сандалі</a></li>	
								<li><a href="/category/2/2/2">Кросівки</a></li>	
								<li><a href="/category/2/2/3">Черевики</a></li>	
								<li><a href="/category/2/2/4">Кеди</a></li>		
							</ul>
						</li>
						<li><a href="/category/2/3">Аксесуари</a>	
							<ul class="categoryMenu3">
								<li><a href="/category/2/3/1">Сумки</a></li>	
								<li><a href="/category/2/3/2">Рюкзаки</a></li>	
								<li><a href="/category/2/3/3">Шкарпетки</a></li>	
								<li><a href="/category/2/3/4">Шапки</a></li>	
							</ul>
						</li>
					</ul>
				</div>
				<div class="categoryItemShadow">
				</div>
			</li>
			<li><a href="/category/3">ЧОЛОВІКАМ</a>		
				<div class="containerCategoryItems">
					<ul class="categoryMenu2">
						<li><a href="/category/3/1">Одяг</a></li>	
						<li><a href="/category/3/2">Взуття</a></li>	
						<li><a href="/category/3/3">Аксесуари</a></li>	
					</ul>
				</div>
				<div class="categoryItemShadow">
				</div>
			</li>
			<li><a href="/category/5">ПОПУЛЯРНЕ</a>		
				<div class="containerCategoryItems">
					<ul class="categoryMenu2">
						<li><a href="/category/3/1">Одяг</a></li>	
						<li><a href="/category/3/2">Взуття</a></li>	
						<li><a href="/category/3/3">Аксесуари</a></li>	
					</ul>
				</div>
				<div class="categoryItemShadow">
				</div>
			</li>
			<li><a href="/constructor/">КОНСТРУКТОР</a>		
			</li> -->
		</ul>
	</div>
</header>
<div class="emptySpace"></div>