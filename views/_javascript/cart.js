var errorSignIn=[];
var errorSignUp=[];
var tmr=0;
var stts;

jQuery(document).ready(function(){
	stts=jQuery(".cart").attr("data-status");
	startSignEvent();
});

function startSignEvent(){
	jQuery(".cart_icon_delete").on("click", function(){
		var elemLI= jQuery(this).parent().parent().parent().parent();

		var id= elemLI.attr("data-id");
		var size= elemLI.attr("data-size");
		var cookiId= id+"-"+size;
		var mas= jQuery.cookie("Cart").split(".");
		var newCookie=[];
		mas.forEach(function(val){
			if(val!=cookiId){
				newCookie.push(val);
			}
		});
		if(newCookie.length>0){
			$.cookie("Cart",newCookie.join("."), { path : '/'});
		}else{
			jQuery.removeCookie("Cart", { path: '/' });
		}

		elemLI.remove();

		if(jQuery(".cart_product_list>li").length>0){
			changeCount();
			changeSum();
			setTimeout(function() {
				$(window).lazyLoadXT();
			}, 50);
		}else{
			jQuery(".cart").replaceWith("<div class=\"cart_empty_space_text\">Кошик пустий</div>");
		}
	});

	jQuery(".cart_item_sum_left>input").on("change", function(){
		changeCount();
		jQuery(this).parent().parent().parent().parent().attr("data-count", jQuery(this).val());
		changeSum();
	});

	jQuery(".cart_item_sum_left>input").on("keypress", function (e) {
	  return false;
	});

	eventBtnRegOrder();
}

function hishBtnRegOrder(int){
	if(int==0){
		jQuery(".cart_regOrder span").css("display", "none");
		jQuery(".cart_regOrder img").css("display", "inline-block");
		jQuery(".cart_regOrder").unbind("click");
	}else if(int==1){
		jQuery(".cart_regOrder img").css("display", "none");
		jQuery(".cart_regOrder span").css("display", "inline-block");
		eventBtnRegOrder();
	}
}

function hishBtnRegOrderError(text=null){
	if(text==null){
		jQuery(".cart_regOrder_error").html();
		jQuery(".cart_regOrder_error").css("opacity", "0");
		jQuery(".cart_product_list>li .cart_item_sum_error").each(function(id,val){
			jQuery(this).css("display","none");
			jQuery(this).parent().children("input").css({"border-color":"", "background-color":""});
		});
	}else{
		jQuery(".cart_regOrder_error").html(text);
		jQuery(".cart_regOrder_error").css("opacity", "1");
	}
}

function eventBtnRegOrder(){
	if(stts!="0"){
		jQuery(".cart_regOrder").on("click", function(){
			var elemLi= jQuery(".cart_product_list>li");
			var mas=[];
			elemLi.each(function(id, val){
				if(!isNaN(jQuery(val).attr("data-count"))){
					var txt= jQuery(val).attr("data-id")+"-"+jQuery(val).attr("data-size")+"-"+jQuery(val).attr("data-count");
					mas.push(txt);
				}
			});
			var idsizecount= mas.join(".");
			doRegOrder(idsizecount);
		});
	}else{
		hishBtnRegOrderError("Профіль заблоковано. Неможливо перейти до оформлення.");
	}
}

function changeCount(){
	var list=jQuery(".cart_item_sum_left>input");
	var count=0;
	list.each(function(id, val){
		count+=Number(jQuery(val).val());
	});
	jQuery(".cart_count_product").html(count);
}

function changeSum(){
	var price1= jQuery(".cart_product_list>li");
	var priceDiscount=0;
	var priceOrigin=0;

	price1.each(function(id,val){
		priceDiscount+= Number(jQuery(val).attr("data-disc"))*Number(jQuery(val).attr("data-count"));
		priceOrigin+= Number(jQuery(val).attr("data-price"))*Number(jQuery(val).attr("data-count"));
	});

	jQuery(".cart_accept_economy>span").html(priceOrigin-priceDiscount);
	jQuery(".cart_priceProduct").html(priceDiscount);

	if(priceDiscount>=850){
		jQuery(".cart_priceDelivery").html("0");
		jQuery(".cart_priceLastPrice").html(priceDiscount);
	}else{
		jQuery(".cart_priceDelivery").html("125");
		jQuery(".cart_priceLastPrice").html(priceDiscount+125);
	}
}

function dotmr(val){
	val--;
	tmr=val;
	if(val>0){
		setTimeout(function(){dotmr(val);}, 1000);
	}
}

function doRegOrder(idsizecount){
	hishBtnRegOrder(0);
	hishBtnRegOrderError();
	Router("regorder", idsizecount);
	dotmr(6);
	backsignin();
}

function backsignin(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		hishBtnRegOrder(1);
		$(location).attr('href',"/order/");
	}else{ // если данные не совплаи
		

		if(typeof resultRouter=="object" && Object.keys(resultRouter).length>0){
			for(var [key, val] of Object.entries(resultRouter)){
				jQuery(".cart_product_list>li[data-id=\""+val[0]+"\"][data-size=\""+val[1]+"\"] .cart_item_sum_error").css("display", "inline-block");
				jQuery(".cart_product_list>li[data-id=\""+val[0]+"\"][data-size=\""+val[1]+"\"] .cart_item_sum_left>input").attr("max", val[2]);
				jQuery(".cart_product_list>li[data-id=\""+val[0]+"\"][data-size=\""+val[1]+"\"] .cart_item_sum_left>input").val(val[2]);
				jQuery(".cart_product_list>li[data-id=\""+val[0]+"\"][data-size=\""+val[1]+"\"] .cart_item_sum_left>input").css({"border-color":"#005FBF", "background-color":"#D3E9FF"});
				jQuery(".cart_product_list>li[data-id=\""+val[0]+"\"][data-size=\""+val[1]+"\"]").attr("data-count", val[2]);
			}
			hishBtnRegOrderError("Кількість деяких товарів змінилась.<br>Не вдалося перейти.");
			changeSum();
			changeCount();
		}else{
			hishBtnRegOrderError("Невідома помилка. Не вдалося перейти.");
		}
		hishBtnRegOrder(1);
		
		resultRouter=false;
	}
}