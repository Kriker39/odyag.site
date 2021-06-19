var errorSignIn=[];
var errorSignUp=[];
var tmr=0;
var txt="";

jQuery(document).ready(function(){
	startSignEvent();
	doRadioWork();
});

function startSignEvent(){
	jQuery(".deliveryRadio_name").on("click", function(){
		jQuery(this).children("input").prop("checked", true);
		doRadioWork();
	});

	jQuery(".addressSelect_delivery").on("change", function(){
		jQuery(".order_map>.active").removeClass("active");
		jQuery(".order_map>.map"+jQuery(this).val()).addClass("active");
	});

	jQuery(".addressSelect_delivery").trigger("change");

	jQuery("input[name='phoneid']").on("change", function(){
		changeNumber(this, 2);
	});
	jQuery("input[name='phonenumber']").on("change", function(){
		changeNumber(this, 7);
		var number= jQuery(this).val();
		hishBtnAddOrderError();
		if(number.length<7){
			hishBtnAddOrderError("Номер введено не повністю");
			jQuery(this).css({"border-color":"red", "background-color":"pink"});
		}else if(jQuery(this).css("border-color")!="rgb(0, 0, 255)"){
			jQuery(this).css({"border-color":"", "background-color":""});
		}
	});
	jQuery("input[name='name'], input[name='secondname'], input[name='lastname']").on("change", function(){
		changeTextInput(this);
	});
	jQuery("input[name='address']").on("change", function(){
		var text= jQuery(this).val();
		clearInputStyle();
		if(text.match(/^[A-Za-zА-Яа-яІіЄєЇїЁёЪъ,./0-9]+$/)==null){
			jQuery(this).val(text.replace(/[^A-Za-zА-Яа-яІіЄєЇїЁёЪъ,.\/0-9]/gi, ''));
			jQuery(this).css({"border-color":"blue", "background-color":"lightblue"});
		}
	});
	jQuery(".btn_shortInfoProducts").on("click", function(){
		if(jQuery(".shortInfoProducts_list").css("display")=="none"){
			jQuery(".shortInfoProducts_list").css("display", "inline-block");
			jQuery(".btn_shortInfoProducts>span").css("transform","rotate(90deg)");
		}else{
			jQuery(".shortInfoProducts_list").css("display", "");
			jQuery(".btn_shortInfoProducts>span").css("transform","");
		}
	});

	jQuery("input, select").change(function(){
		activeBtnAddOrder(0);
		var radioDeliveryVal= jQuery(".deliveryRadio_name>input[type='radio']:checked").parent().attr("id");
		var valueDelivery="";
		var valueDelivery2="";
		if(radioDeliveryVal=="curier"){
			valueDelivery= jQuery(".deliveryRadio #curier").next().children("input").val().trim();
		}else if(radioDeliveryVal=="punktvidachi"){
			valueDelivery= jQuery(".deliveryRadio #punktvidachi").next().children("select").val().trim();
			if(valueDelivery=="1"){
				valueDelivery= "вулиця Михайла Омеляновича-Павленка, 1";
			}else if(valueDelivery=="2"){
				valueDelivery= "вулиця Митрополита Андрея Шептицького, 4 А";
			}else{
				valueDelivery="";
			}
		}else if(radioDeliveryVal=="post"){
			valueDelivery= jQuery(".deliveryRadio #post").next().children("select").val().trim();
			valueDelivery2= jQuery(".deliveryRadio #post").next().children("div").children("input").val().trim();
			if(valueDelivery!="novaposhta" && valueDelivery!="ukrposhta"){
				valueDelivery="";
			}
		}
		
		var valueTypepay="cash";

		var name=jQuery(".infoClient .infoClient_right input[name='name']").val().trim();
		var secondname=jQuery(".infoClient .infoClient_right input[name='secondname']").val().trim();
		var lastname=jQuery(".infoClient .infoClient_right input[name='lastname']").val().trim();
		var code=jQuery(".infoClient .infoClient_right input[name='phoneid']").val().trim();
		var number=jQuery(".infoClient .infoClient_right input[name='phonenumber']").val().trim();

		if(number.length!=7){number="";}

		if(name!="" && secondname!="" && lastname!="" && code!="" && number!="" && valueDelivery!="" && (radioDeliveryVal!="post" || (radioDeliveryVal=="post" && valueDelivery2!=""))){
			if(valueDelivery2!=""){
				valueDelivery+="."+valueDelivery2;
			}
			txt= name+"|"+secondname+"|"+lastname+"|"+code+"|"+number+"|"+radioDeliveryVal+"|"+valueDelivery;
			activeBtnAddOrder(1);
		}else{
			txt="";
		}

	});
}

function showErrorInput(elem){
	jQuery(elem).css({"border-color":"red", "background-color":"pink"});
}

function clearInputStyle(){
	jQuery("input").each(function(id,val){
		if(jQuery(val).css("border-color")!="rgb(255, 0, 0)"){
			jQuery(val).css({"border-color":"", "background-color":""});
		}
	});
}

function changeNumber(elem, size){
	var number= jQuery(elem).val();
	clearInputStyle();
	if(number.length>size){
		jQuery(elem).val(number.substr(0, size));
		jQuery(elem).css({"border-color":"blue", "background-color":"lightblue"});
	}
}

function changeTextInput(elem){
	var text= jQuery(elem).val();
	clearInputStyle();
	if(text.match(/^[A-Za-zА-Яа-яІіЄєЇїЁёЪъ]+$/)==null){
		jQuery(elem).val(text.replace(/[^A-Za-zА-Яа-яІіЄєЇїЁёЪъ]/gi, ''));
		jQuery(elem).css({"border-color":"blue", "background-color":"lightblue"});
	}
}

function doRadioWork(){
	jQuery(".deliveryRadio>.active").removeClass("active");
	jQuery(".deliveryRadio_name>input:checked").parent().next().addClass("active");
	jQuery(".deliveryRadio_name>input:checked").trigger("change");
}

function activeBtnAddOrder(int){
	if(int==0){
		jQuery(".order_addOrder").css({"background-color":"", "border-color":"", "pointer-events":""});
		jQuery(".order_addOrder").unbind("click");
	}else if(int==1){
		jQuery(".order_addOrder").css({"background-color":"green", "border-color":"green", "pointer-events":"auto"});
		eventBtnAddOrder();
	}
}

function hishBtnAddOrder(int){
	if(int==0){
		jQuery(".order_addOrder span").css("display", "none");
		jQuery(".order_addOrder img").css("display", "inline-block");
		jQuery(".order_addOrder").unbind("click");
	}else if(int==1){
		jQuery(".order_addOrder img").css("display", "none");
		jQuery(".order_addOrder span").css("display", "inline-block");
		eventBtnAddOrder();
	}
}

function hishBtnAddOrderError(text=null){
	if(text==null){
		jQuery(".order_addOrder_error").html();
		jQuery(".order_addOrder_error").css("opacity", "0");
	}else{
		jQuery(".order_addOrder_error").html(text);
		jQuery(".order_addOrder_error").css("opacity", "1");
	}
}

function eventBtnAddOrder(){
	jQuery(".order_addOrder").on("click", function(){
		doAddOrder();
	});
}

function dotmr(val){
	val--;
	tmr=val;
	if(val>0){
		setTimeout(function(){dotmr(val);}, 1000);
	}
}

function doAddOrder(){
	hishBtnAddOrder(0);
	hishBtnAddOrderError();
	Router("addorder", txt);
	dotmr(6);
	backsignin();
}

function backsignin(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		hishBtnAddOrder(1);
		$(location).attr('href',"/profile/");
	}else{ // если данные не совплаи
		hishBtnAddOrderError(resultRouter);
		hishBtnAddOrder(1);
		
		resultRouter=false;
	}
}