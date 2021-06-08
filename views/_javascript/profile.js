var savel=jQuery.cookie("savel");
var savep=jQuery.cookie("savep");
var switchStatus="of";

jQuery(document).ready(function(){
	startEvents();
	workSaveEnter();
	savel=jQuery.cookie("savel");
	savep=jQuery.cookie("savep");
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