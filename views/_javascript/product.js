var listImg= [];
var activeImg= 1;
var expanded = false; // мульти селектор

jQuery(document).ready(function(){
	startEvents();
	startCheckboxes();

	if(jQuery(".container_product_addProduct>div").is(".product_btnEnd")){
		jQuery(".checkboxes>li").unbind();
		jQuery(".checkboxes>li").css("cursor", "auto");
		jQuery(".product_addProduct").unbind();
	}
});

function startEvents(){
	jQuery(".product_slider_listItem").each(function(id, val){
		listImg.push(jQuery(this).attr("src"));
	});
	jQuery(".product_slider_listItem").on("click", function(){
		var elem= jQuery(this).attr("src"); 
		var re = new RegExp(activeImg+".jpg$");
		var re2= /([0-9])+.jpg$/;

		if(!elem.match(re)){
			jQuery(".product_slider_showimg").attr("src", elem);
			jQuery(".product_slider_list>.active").removeClass("active");
			jQuery(this).addClass("active");
			activeImg= re2.exec(jQuery(this).attr("src"))[1];
		}
	});

	jQuery(".product_slider_left").on("click", function(){
		var elem= jQuery(".product_slider_showimg");
		var re= /([0-9])+.jpg$/;
		var num= activeImg;
		
		if((Number(num)-Number(1)) <= 0){num=listImg.length;}else{num--;}

		jQuery(".product_slider_list>img[src$='"+num+".jpg'").trigger("click");
	});

	jQuery(".product_slider_right").on("click", function(){
		var elem= jQuery(".product_slider_showimg");
		var re= /([0-9])+.jpg$/;
		var num= activeImg;
		
		if((Number(num)+Number(1)) > listImg.length){num=1;}else{num++;}

		jQuery(".product_slider_list>img[src$='"+num+".jpg'").trigger("click");
	});

	startEventBtnAdd();
}

function startCheckboxes() {
	jQuery(".container_select").on("click", function(){
		var elem= jQuery(this).parent();
		var checkboxes = elem.children(".checkboxes");
		if (!expanded) {
			checkboxes.css("display", "block");
			expanded = true;
			jQuery(document).on("mouseup", function(e){
				if(!elem.is(e.target)&& elem.has(e.target).length === 0){
					checkboxes.css("display", "none");
					expanded = false;
					jQuery(document).unbind("mouseup");
				}
			});
		} else {
			checkboxes.css("display", "none");
			expanded = false;
			jQuery(document).unbind("click");
		}
	});
	
	jQuery(".checkboxes>li").on("click", function(){
		var text= jQuery(this).children("p").html();

		jQuery(".container_select>select>option").html(text);
		jQuery(".checkboxes").css("display", "none");
		expanded = false;
		jQuery(document).unbind("click");
	});
}

function startEventBtnAdd(){
	jQuery(".product_addProduct").on("click", function(){
		var valSize= jQuery(".container_select>select").val();
		if(valSize=="Виберіть розмір"){
			jQuery(".container_select>select").css("border-color", "red");
			jQuery(".container_select").trigger("click");
		}else{
			jQuery(".container_select>select").css("border-color", "");
			var pathname = window.location.pathname.split("/");
			var id= 0;

			pathname.forEach(function(value){
				if(/tp[0-9]+p[0-9]+$/.test(value)){
					var re= new RegExp("^tp[0-9]+p");
					id= value.replace(re, "");

				}
			});

			var check=!isNaN(id);

			if(check && jQuery.cookie("Cart")!=null){
				var cookie= jQuery.cookie("Cart").split(".");
				var txt= id+"-"+valSize;
				cookie.forEach(function(val){
					if(txt==val){
						check=false;
					}
				});
			}
			if(check){
				doAddProductInCart(id, valSize);
			}else{
				hishBtnAddError("Даний розмір вже додано у кошик");
			}
		}
	});
}

function showBtrAddMsg(){
	jQuery(".product_addProduct_accept").css("right", "-44px");
	setTimeout(function(){
		jQuery(".product_addProduct_accept").css("background-color", "green");
		setTimeout(function(){
			jQuery(".product_addProduct_accept").css("right", "0");
			setTimeout(function(){
				jQuery(".product_addProduct_accept").css("background", "white");
			}, 100);
		}, 1000);
	}, 500);
}

function hishBtnAddError(text=null){
	if(text==null){
		jQuery(".product_addProduct_error").css("display", "none");
		jQuery(".product_addProduct_error").html();
	}else{
		jQuery(".product_addProduct_error").css("display", "inline-block");
		jQuery(".product_addProduct_error").html(text);
	}
}

function hishBtnAddInside(num){
	if(num==0){
		jQuery(".product_addProduct img").css("display", "none");
		jQuery(".product_addProduct p").css("display", "inline-block");
	}else if(num==1){
		jQuery(".product_addProduct p").css("display", "none");
		jQuery(".product_addProduct img").css("display", "inline-block");
	}
}

function doAddProductInCart(id, size){
	jQuery(".product_addProduct").unbind();
	hishBtnAddInside(1);
	hishBtnAddError();
	Router("addincart", id, size);
	backsignin();
}

function backsignin(){
	if(resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		hishBtnAddInside(0);
		hishBtnAddError();
		showBtrAddMsg();
		startEventBtnAdd();
	}else{ // если данные не совплаи
		hishBtnAddInside(0);
		hishBtnAddError(resultRouter);

		startEventBtnAdd();

		resultRouter=false;
	}
}