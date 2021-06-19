var savel=jQuery.cookie("savel");
var savep=jQuery.cookie("savep");
var switchStatus="of";
var tmr=0;

jQuery(document).ready(function(){
	startEvents();
	workSaveEnter();
	savel=jQuery.cookie("savel");
	savep=jQuery.cookie("savep");
	jQuery(".select_methodDelivery").trigger("change");
});

function startEvents(){
	jQuery(".table_showItem").on("click", function(){
		var num= jQuery(this).parent().attr("class").replace("main", "");
		if(jQuery(".item"+num).css("display")=="none"){
			jQuery(".item"+num).css("display", "table-row");
		}else{
			jQuery(".item"+num).css("display", "none");
		}
	});

	jQuery(".exitProfile").on("click", function(){
		jQuery.removeCookie("savel", { path: '/' });
		jQuery.removeCookie("savep", { path: '/' });
		jQuery.removeCookie("PHPSESSID", { path: '/' });
		$(location).attr('href',"/");
		exit();
	});

	jQuery(".select_methodDelivery").change(function(){
		var listDelivery= jQuery(".info_profile_delivery");
		listDelivery.each(function(id,val){
			jQuery(this).css("display", "none");
		});

		var listShowDelivery= jQuery(".info_profile_delivery[name='"+jQuery(this).val()+"']");
		listShowDelivery.each(function(id,val){
			jQuery(this).css("display", "flex");
		});
	});

	jQuery(".addressSelect_delivery").on("change", function(){
		jQuery(".order_map>.active").removeClass("active");
		jQuery(".order_map>.map"+jQuery(this).val()).addClass("active");
	});	

	jQuery(".addressSelect_delivery").trigger("change");

	jQuery("input[name='address_delivery']").on("change", function(){
		changeTextInputAddress(this);
	});

	jQuery("input[name='delivery_num']").on("change", function(){
		changeNumber(this, 10);
	});
	jQuery("input[name='phoneid']").on("change", function(){
		changeNumber(this, 2);
	});
	jQuery("input[name='phonenumber']").on("change", function(){
		changeNumber(this, 7);
		var number= jQuery(this).val();
		hishBtnUpdateInfoError();
		activeBtnUpdateInfo(1);
		if(number.length<7){
			hishBtnUpdateInfoError("Номер введено не вірно. Повинно бути: тільки цифри і к-сть цифр 7");
			activeBtnUpdateInfo(0);
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

	eventBtnUpdateInfo();
}

function eventBtnUpdateInfo(){
	jQuery(".btrSaveUserInfo").on("click", function(){
		var txt="";
		
		var radioDeliveryVal= jQuery(".select_methodDelivery").val();
		var valueDelivery="";
		var valueDelivery2="";
		if(radioDeliveryVal=="curier"){
			valueDelivery= jQuery(".info_profile_right>input[name='address_delivery']").val().trim();
		}else if(radioDeliveryVal=="punktvidachi"){
			valueDelivery= jQuery(".info_profile_right>.addressSelect_delivery").val().trim();
			if(valueDelivery=="1"){
				valueDelivery= "вулиця Михайла Омеляновича-Павленка, 1";
			}else if(valueDelivery=="2"){
				valueDelivery= "вулиця Митрополита Андрея Шептицького, 4 А";
			}else{
				valueDelivery="";
			}
		}else if(radioDeliveryVal=="post"){
			valueDelivery= jQuery(".info_profile_delivery[name='post'] select").val().trim();
			valueDelivery2= jQuery(".info_profile_right>input[name='delivery_num']").val().trim();
			if(valueDelivery!="novaposhta" && valueDelivery!="ukrposhta"){
				valueDelivery="";
			}
		}
		
		var valueTypepay="cash";

		var name=jQuery(".info_profile_right input[name='name']").val().trim();
		var secondname=jQuery(".info_profile_right input[name='secondname']").val().trim();
		var lastname=jQuery(".info_profile_right input[name='lastname']").val().trim();
		var code=jQuery(".info_profile_right input[name='phoneid']").val().trim();
		var number=jQuery(".info_profile_right input[name='phonenumber']").val().trim();

		if(number.length!=7){number="";}

		if(valueDelivery2!=""){
			valueDelivery+="."+valueDelivery2;
		}
		txt= name+"|"+secondname+"|"+lastname+"|"+code+"|"+number+"|"+radioDeliveryVal+"|"+valueDelivery;

		doUpdateInfo(txt);
	});
}

function showBtnUpdateInfo(){
	jQuery(".product_updateInfo_accept").css("right", "-44px");
	setTimeout(function(){
		jQuery(".product_updateInfo_accept").css("background-color", "green");
		setTimeout(function(){
			jQuery(".product_updateInfo_accept").css("right", "0");
			setTimeout(function(){
				jQuery(".product_updateInfo_accept").css("background", "white");
			}, 100);
		}, 1000);
	}, 500);
}

function changeNumber(elem, size){
	var number= jQuery(elem).val();
	clearInputStyle();
	if(number.length>size){
		jQuery(elem).val(number.substr(0, size));
		jQuery(elem).css({"border-color":"blue", "background-color":"lightblue"});
	}
}

function changeTextInputAddress(elem){
	var text= jQuery(elem).val();
	clearInputStyle();
	if(text.match(/^[0-9A-Za-zА-Яа-яІіЄєЇїЁёЪъ\,\.\/\(\)\-\s]+$/)==null){
		jQuery(elem).val(text.replace(/[^0-9A-Za-zА-Яа-яІіЄєЇїЁёЪъ\,\.\/\(\)\-]/gi, ''));
		jQuery(elem).css({"border-color":"blue", "background-color":"lightblue"});
	}
}

function changeTextInput(elem){
	var text= jQuery(elem).val();
	clearInputStyle();
	if(text.match(/^[A-Za-zА-Яа-яІіЄєЇїЁёЪъ\s]+$/)==null){
		jQuery(elem).val(text.replace(/[^A-Za-zА-Яа-яІіЄєЇїЁёЪъ]/gi, ''));
		jQuery(elem).css({"border-color":"blue", "background-color":"lightblue"});
	}
}

function clearInputStyle(){
	jQuery("input").each(function(id,val){
		if(jQuery(val).css("border-color")!="rgb(255, 0, 0)"){
			jQuery(val).css({"border-color":"", "background-color":""});
		}
	});
}

function hishBtnUpdateInfo(int){
	if(int==0){
		jQuery(".btrSaveUserInfo span").css("display", "none");
		jQuery(".btrSaveUserInfo img").css("display", "inline-block");
		jQuery(".btrSaveUserInfo").unbind("click");
	}else if(int==1){
		jQuery(".btrSaveUserInfo img").css("display", "none");
		jQuery(".btrSaveUserInfo span").css("display", "inline-block");
		eventBtnUpdateInfo();
	}
}

function hishBtnUpdateInfoError(text=null){
	if(text==null){
		jQuery(".info_profile_updateInfoError>.info_profile_right").html();
		jQuery(".info_profile_updateInfoError").css({"opacity":"0", "height":"0"});
	}else{
		jQuery(".info_profile_updateInfoError>.info_profile_right").html(text);
		jQuery(".info_profile_updateInfoError").css({"opacity":"1", "height":"auto"});
	}
}

function activeBtnUpdateInfo(int){
	if(int==0){
		jQuery(".btrSaveUserInfo").css({"background-color":"lightgray", "border-color":"lightgray", "pointer-events":""});
		jQuery(".btrSaveUserInfo").unbind("click");
	}else if(int==1){
		jQuery(".btrSaveUserInfo").css({"background-color":"green", "border-color":"green", "pointer-events":"auto"});
		eventBtnUpdateInfo();
	}
}

function workSaveEnter(){ // выполнение всех функций необходимых для вечной авторизации
	if(savel!=null){
		switchStatus=savel.substring(8,10);
		changeTextSwitch();
		changeSaveEnter();
		if(switchStatus=="on"){
			jQuery('.saveSignIn>div>input').prop('checked', true);
			changeCookieON();
		}
	}
}

function changeTextSwitch(){ // сменя текста переключателя вечной авторизации
	jQuery(".saveSignIn").on("click", function(){
		elem2=jQuery(".saveSignIn>div>input");
		if(elem2.is(":checked")){
			elem2.prop("checked", false);
		}else{
			elem2.prop("checked", true);
		}
		elem2.trigger("change");
	});
}

function changeSaveEnter(){ // ифент на выполнение функционала переключателя вечной авторизации
	var elem1=jQuery(".saveSignIn>div>input");
	elem1.change(function(){
		if(this.checked){
			changeCookieON();
		}else{
			savel=savel.substring(0,8)+"of"+savel.substring(10); // меняет инфу переключателя для вечной авторизации на выкл
			$.cookie("savel",savel, { path : '/'});
			$.cookie("savep",savep, { path : '/'});
		}
	});
}

function changeCookieON(){ // обновляет куки с логином и паролем
	savel=savel.substring(0,8)+"on"+savel.substring(10); // меняет инфу переключателя для вечной авторизации на вкл
	$.cookie("savel",savel, { expires : 30 , path : '/'}); // добавляет/обновляет куки логина
	$.cookie("savep",savep, { expires : 30 , path : '/'}); // добавляет/обновляет куки пароля
}

function dotmr(val){
	val--;
	tmr=val;
	if(val>0){
		setTimeout(function(){dotmr(val);}, 1000);
	}
}

function doUpdateInfo(txt){
	hishBtnUpdateInfo(0);
	hishBtnUpdateInfoError();
	Router("updateuserinfo", txt);
	dotmr(6);
	backsignin();
}

function backsignin(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		hishBtnUpdateInfo(1);
		showBtnUpdateInfo();
	}else{ // если данные не совплаи
		if(resultRouter=="unsign"){
			$(location).attr('href',"/sign/");
		}else{
			hishBtnUpdateInfoError(resultRouter);
			hishBtnUpdateInfo(1);
		}
		
		resultRouter=false;
	}
}