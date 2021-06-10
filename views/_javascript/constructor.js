var listShowItem= [];
var sizeList= new Map([
	["107","29,30"],
	["108","29,30"],
	["109","29,30"],
	["110","29,30"],
	]);
var xs, ys;
var saveSrcBackgDisplay;
var multiplySize= 4;

jQuery(document).ready(function(){
	startEvents();
	eventItemDisplay();
	$.lazyLoadXT.scrollContainer = '.list_selectProduct';
});

function startEvents(){
	updateEventListProduct();

	jQuery(".constructor_submitHeight").on("click", function(){
		var num= jQuery(".input_height").val();
		if(num>=100 && num<=250){
			jQuery(".input_height").css("border-color", "");
			jQuery(".display_background").css("height", num*multiplySize);
		}else{
			jQuery(".input_height").css("border-color", "red");
		}
	});

	jQuery(".sett_gender>div").on("click", function(){
		var id= jQuery(this).children("input").attr("id");
		if(id=="woman"){
			jQuery(".display_background").attr("src", "/views/_img/maniken_woman.png");
		}else if(id=="man"){
			jQuery(".display_background").attr("src", "/views/_img/maniken_man.png");
		}else if(id=="womanmore"){
			jQuery(".display_background").attr("src", "/views/_img/maniken_woman_more.png");
		}else if(id=="manmore"){
			jQuery(".display_background").attr("src", "/views/_img/maniken_man_more.png");
		}
		
		jQuery(this).children("input").prop("checked", true);
	});

	jQuery("input[name='downloadPhoto']").change(function() {
		readURL(this);
		if(checkBackgroundDisplay){
			disabledSettGender(0);
			disabledSettPhoto(1);
			jQuery(".sett_photo #loaded").prop("checked", true);
		}
	});

	jQuery(".constructor_loadPhoto").on("click", function(){
		var txt=jQuery(this).parent().children("input").val();
		var re=new RegExp("^(ftp|http|https):\/\/[^ \"]+$");
		if(re.test(txt)){
			jQuery(".display_background").attr("src", txt);
			jQuery(this).parent().children("input").css("border-color","");
		}else{
			jQuery(this).parent().children("input").css("border-color","red");
		}
		
		jQuery(".display_background").on("error", function(){
			jQuery(this).attr("src", "/views/_img/error_load_img.png");
		});
		if(checkBackgroundDisplay){
			disabledSettGender(0);
			disabledSettPhoto(1);
			jQuery(".sett_photo #loaded").prop("checked", true);
		}
	});

	jQuery(".sett_photo>div").on("click", function(){
		var id= jQuery(this).children("input").attr("id");
		if(id=="maniken"){
			saveSrcBackgDisplay= jQuery(".display_background").attr("src");
			jQuery(".sett_gender>div>input:checked").trigger("click");
			jQuery(".constructor_infoLoadCart").css("opacity", "0");
			disabledSettGender(1);
		}else if(id=="loaded"){
			jQuery(".display_background").attr("src", saveSrcBackgDisplay);
			jQuery(".constructor_infoLoadCart").css("opacity", "1");
			disabledSettGender(0);
		}
		
		jQuery(this).children("input").prop("checked", true);
	});

	eventUpdateListProduct();
}

function updateEventListProduct(){
	jQuery(".list_selectProduct>ul>li").on("click", function(){
		var idproduct= jQuery(this).attr("data-id");
		if (listShowItem.indexOf(idproduct)==-1){
			var elem= jQuery(this).children();
			var mainimglink= jQuery(elem[0]).attr("src");
			var shortinfoproduct= elem[1];
			var sizeproduct= jQuery(jQuery(shortinfoproduct).children()[2]).html().replace("Розмір: ", "");
			var masId= idproduct.split("-");
			
			jQuery(this).children(".list_product_plus").css("opacity","1");

			jQuery(".showMenu>ul").append("<li  data-id=\""+idproduct+"\">"+
				"<img src=\""+mainimglink+"	\" class=\"constructor_imgItem\">"+
				shortinfoproduct.outerHTML+
				"<img src=\"/views/_img/close.png\" class=\"constructor_closeItem\">");

			var idmasive= idproduct.split("-");
			var index= Number(jQuery(".displayitem").length)+1;
			var txt="<div class=\"displayitem\" data-id=\""+idproduct+"\" style=\"z-index:"+index+";\" title=\"код: "+masId[0]+"\nрозмір: "+masId[1]+"\">";

			for(var i=1; i<=jQuery(this).attr("data-lenimg"); i++){
				txt+="<img src=\"/data/product/constructor/"+idmasive[0]+"/"+i+".png\">"
			}
			txt+="</div>";

			jQuery(".display").append(txt);

			var height= jQuery(this).attr("data-length")*multiplySize;

			jQuery(".displayitem[data-id="+idproduct+"]").css("height", height);

			listShowItem.push(idproduct);
			removeItemEvent();
			eventItemDisplay();
		}
	});
}

function eventUpdateListProduct(){
	jQuery(".constructor_updateListProduct").css("background-color", "");
	jQuery(".constructor_updateListProduct").on("click", function(){
		var cookie= $.cookie("Cart");
		if(cookie!=null){
			doConstructorUpdate();
		}else{
			jQuery(".list_selectProduct>ul").html("<div class=\"constructor_emptyCart\"><img src=\"/views/_img/icon_info.png\"> У кошику порожньо</div>");
		}
	});
}

function disabledSettGender(code){
	if(code=="0"){
		jQuery(".sett_gender").addClass("disabled");
	}else if(code=="1"){
		jQuery(".sett_gender").removeClass("disabled");
	}
}

function disabledSettPhoto(code){
	if(code=="0"){
		jQuery(".sett_photo").addClass("disabled");
	}else if(code=="1"){
		jQuery(".sett_photo").removeClass("disabled");
		jQuery(".constructor_infoLoadCart").css("opacity", "1");
	}
}

function checkBackgroundDisplay(){
	var stat= true;
	var src=jQuery("display_background").attr("src");

	if(src=="/views/_img/error_load_img.png"){
		stat=false;
	}

	return stat;
}

function removeItemEvent(){
	jQuery(".showMenu>ul>li").unbind("click");
	jQuery(".showMenu>ul>li").on("click", function(){
		var id=jQuery(this).attr("data-id");
		var idMas=listShowItem.indexOf(id);
		jQuery(".list_selectProduct>ul>li[data-id=\""+id+"\"]").children(".list_product_plus").css("opacity","0");
		if(idMas!=-1){
			listShowItem.splice(idMas, 1); 
		}

		jQuery(".displayitem[data-id="+id+"]").remove();
		jQuery(this).remove();
	});
}

function eventItemDisplay(){
	jQuery(".displayitem").unbind();
	jQuery(".displayitem").on("mousedown", function(e){
		xs=e.pageX;
		ys=e.pageY;

		var len= Number(jQuery(".displayitem").length);
		var len2= Number(jQuery(this).css("z-index"));
		for (var i = len2+1; i <=len; i++) {
			jQuery(".displayitem[style^=\"z-index: "+i+"\"]").css("z-index", i-1);
			jQuery(this).css("z-index", i);
		}
		
		jQuery(this).on("mousemove", function(e){
		    var xn= e.pageX;
		    var yn= e.pageY;

		    var left=Number(jQuery(this).css("left").replace("px", ""));
		    var top=Number(jQuery(this).css("top").replace("px", ""));

		    var width = jQuery(this).parent().innerWidth()-jQuery(this).outerWidth();
		    var height = jQuery(this).parent().innerHeight()-jQuery(this).outerHeight();

		    if(xs<xn){ //x+
		    	var rslt=(left+xn-xs);
		    	if(rslt<=width){
			    	jQuery(this).css("left",rslt+"px");
			    }
		    }else if(xs>xn){ //x-
		    	var rslt=(left-(xs-xn));
		    	if(rslt>=0){
		    		jQuery(this).css("left",rslt+"px");
		    	}
		    }

		    if(ys<yn){ //y+
		    	var rslt=(top+yn-ys);
		    	if(rslt<=height){
		    		jQuery(this).css("top",rslt+"px");
		    	}
		    }else if(ys>yn){ //y-
		    	var rslt=(top-(ys-yn));
		    	if(rslt>=0){
		    		jQuery(this).css("top",rslt+"px");
		    	}
		    }

    		xs=e.pageX;
			ys=e.pageY;
		});
	});
	jQuery(".displayitem").on("mouseup mouseleave", function(){
		jQuery(".displayitem").unbind("mousemove");
	});
}

function readURL(input) {
	if (input.files && input.files[0]) {
	var reader = new FileReader();

	reader.onload = function(e) {
		jQuery('.display_background').attr('src', e.target.result);
	}

	reader.readAsDataURL(input.files[0]);
	}
}

jQuery(window).on('load resize',windowSize);
function windowSize(){
	if (jQuery(window).width() <= '1400'){
		jQuery(".container_display").css("flex-direction", "column");

		if (jQuery(window).width() <= '1100'){
			multiplySize=3;
			jQuery(".display_background").css("height", jQuery(".input_height").val()*multiplySize);
			jQuery(".display").css("width", "700px");

			if (jQuery(window).width() <= '800'){
				multiplySize=2;
				jQuery(".display_background").css("height", jQuery(".input_height").val()*multiplySize);
				jQuery(".display").css("width", "500px");
				var elem= jQuery(".displayitem");
				elem.each(function(id, val){
					var idval=jQuery(val).attr("data-id");
					var lengthval= jQuery(".list_selectProduct li[data-id='"+idval+"']").attr("data-length");
					jQuery(val).css("height", lengthval*multiplySize);
				});
			}else{
				multiplySize=3;
				jQuery(".display_background").css("height", jQuery(".input_height").val()*multiplySize);
				jQuery(".display").css("width", "700px");
				var elem= jQuery(".displayitem");
				elem.each(function(id, val){
					var idval=jQuery(val).attr("data-id");
					var lengthval= jQuery(".list_selectProduct li[data-id='"+idval+"']").attr("data-length");
					jQuery(val).css("height", lengthval*multiplySize);
				});
			}
		}else{
			multiplySize=4;
			jQuery(".display_background").css("height", jQuery(".input_height").val()*multiplySize);
			jQuery(".display").css("width", "1000px");
			var elem= jQuery(".displayitem");
			elem.each(function(id, val){
				var idval=jQuery(val).attr("data-id");
				var lengthval= jQuery(".list_selectProduct li[data-id='"+idval+"']").attr("data-length");
				jQuery(val).css("height", lengthval*multiplySize);
			});
		}
	}else{
		jQuery(".container_display").css("flex-direction", "row");
	}
}
// jQuery( ".constructor_updateListProduct .upd_timer" ).animate({
// 			left: "100%"
// 		}, 5000,function() {
// 			jQuery(".constructor_updateListProduct .upd_timer").css({"opacity":"0", "left":"0"});
// 		});
function hishBtnUpdate(int){
	var sec= 10;
	if(int==0){
		jQuery(".constructor_updateListProduct span").css("display", "none");
		jQuery(".constructor_updateListProduct .btnLoadUpdate").css("display", "inline-block");
		jQuery(".constructor_updateListProduct").unbind("click");
	}else if(int==1){
		jQuery(".constructor_updateListProduct .btnLoadUpdate").css("display", "none");
		jQuery(".constructor_updateListProduct span").css("display", "inline-block");
		showMsgDone();
		jQuery(".constructor_updateListProduct .upd_timer").css({"opacity":"1", "left":"100%", "transition":sec+"s left linear"});
		setTimeout(function(){
			jQuery(".constructor_updateListProduct .upd_timer").css({"opacity":"0", "left":"", "transition":""});
			eventUpdateListProduct();
		}, sec*1000);
	}
}

function showMsgDone(){
	jQuery(".constructor_updateListProduct>.btnDone").css("opacity", "1");
	setTimeout(function(){
		jQuery(".constructor_updateListProduct>.btnDone").css("background-color", "lightgreen");
		setTimeout(function(){
			jQuery(".constructor_updateListProduct>.btnDone").css("opacity", "0");
			setTimeout(function(){
				jQuery(".constructor_updateListProduct>.btnDone").css("background-color", "");
			}, 1000);
		}, 1000);
	}, 300);
}

function doConstructorUpdate(){
	hishBtnUpdate(0);
	// hishBtnRegOrderError();
	Router("updateconstructor", "");
	backsignin();
}

function backsignin(){
	if(resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		hishBtnUpdate(1);
	}else{ // если данные не совплаи
		
		jQuery(".list_selectProduct>ul").html("");
		var listCookie= resultRouter[0].slice();
		var listProduct= resultRouter[1].slice();
		var newList= resultRouter[0].slice();
		var changeList=[""];
		jQuery(".list_product>h3>div>span").html(listProduct.length);
		

		$.when(listProduct.forEach(function(product){
			var size=0;
			for (var i = 0; i < newList.length; i++){
				if(newList[i][0]==product["id"]){
					var idsize= newList[i][0]+"-"+newList[i][1];
					var check=true;
					for (var j = 0; j < changeList.length; j++){
						if(changeList[j]==idsize){
							check=false;
							break;
						}
					}
					if(check){
						size= newList[i][1];
						changeList.push(idsize);
						break;
					}
				}
			}
			jQuery(".list_selectProduct>ul").append("<li data-id=\"tp"+product["tag"]+"p"+product["id"]+"-"+size+"\" data-length=\""+product["length"]+"\" data-lenimg=\"1\">"+
				"<img data-src=\"/data/product/img/tp"+product["tag"]+"p"+product["id"]+"/1.jpg\" class=\"constructor_imgItem2\">"+
				"<div>"+
					"<p>"+product["name"]+"</p>"+
					"<p>Колір: <img src=\"/data/product/color/tp"+product["tag"]+"p"+product["id"]+".jpg\"></p>"+
					"<p>Розмір: "+size+"</p>"+
					"<p>Код: tp"+product["tag"]+"p"+product["id"]+"</p>"+
				"</div>"+
				"<div class=\"list_product_plus\">"+
					"<div class=\"plus_symbol\">+</div>"+
					"<div class=\"plus_shadow\"></div>"+
				"</div>"+
			"</li>");
		})).then(function(){
			setTimeout(function() {
				$(window).lazyLoadXT();
				var list=jQuery(".list_selectProduct>ul>li");
				var list2=jQuery(".showMenu>ul>li");
				for(var i=0; i<list.length; i++){
					for(var j=0; j<list2.length; j++){
						if(jQuery(list[i]).attr("data-id")==jQuery(list2[j]).attr("data-id")){
							jQuery(list[i]).children(".list_product_plus").css("opacity","1");
							break
						}
					}
				}
				removeItemEvent();
				updateEventListProduct();
			}, 50);
		});

		hishBtnUpdate(1);
		resultRouter=false;
	}
}