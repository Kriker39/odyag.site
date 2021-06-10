var errorSignIn=[];
var errorSignUp=[];

jQuery(document).ready(function(){
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
	}else{
		jQuery(".cart_regOrder_error").html(text);
		jQuery(".cart_regOrder_error").css("opacity", "1");
	}
}

function eventBtnRegOrder(){
	jQuery(".cart_regOrder").on("click", function(){
		var elemLi= jQuery(".cart_product_list>li");
		var mas=[];
		elemLi.each(function(id, val){
			if(!isNaN(jQuery(val).attr("data-count"))){
				var txt= jQuery(val).attr("data-id")+"-"+jQuery(val).attr("data-count");
				mas.push(txt);
			}
		});
		var idcount= mas.join(".");
		doRegOrder(idcount);
	});
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


function doRegOrder(idcount){
	hishBtnRegOrder(0);
	hishBtnRegOrderError();
	Router("regorder", idcount);
	backsignin();
}

function backsignin(){
	if(resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		hishBtnRegOrder(1);
		console.log("ok");
	}else{ // если данные не совплаи
		console.log(resultRouter);
		hishBtnRegOrder(1);
		hishBtnRegOrderError(resultRouter);

		resultRouter=false;
	}
}