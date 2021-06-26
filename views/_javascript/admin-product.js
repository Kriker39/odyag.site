var tmr=0;
var code;
var size;
var count;
var activeElem;

jQuery(document).ready(function(){
	startEvents();

});

function startEvents(){
	jQuery(".adminPage_showImg").on("click", function(e){
		if (!jQuery(".adminPage_showImg>div").is(e.target) && jQuery(".adminPage_showImg>div").has(e.target).length === 0) {
			jQuery(this).css("display", "none");
		}
	});

	jQuery(".adminPage_listColor input[name='addcolor']").change(function() {
		activeElem=jQuery(this);
		
		var id= jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().prev().children()[1]).html();
		var tag= jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().prev().children()[2]).children().val().trim();

		var code= "tp"+tag+"p"+id;

		if (this.files && this.files[0]) {
			var data = new FormData();
			data.append('img', this.files[0]);
			data.append('imgname', code);

			var reader = new FileReader();

			reader.onload = function(e) {
				doAddColor(data, e.target.result);
			}

			reader.readAsDataURL(this.files[0]);
		}
	});

	jQuery(".adminPage_table2_addImg input[name='addimg']").change(function() {
		activeElem=jQuery(this);
		var id= jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().prev().children()[1]).html();
		var tag= jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().prev().children()[2]).children().val().trim();
		var count= jQuery(jQuery(this).parent().parent().parent().parent().parent().children("table")[3]).children().children().length;

		var code= "tp"+tag+"p"+id+"|"+count;

		if (this.files && this.files[0]) {
			
			var data = new FormData();
			data.append('img', this.files[0]);
			data.append('imgname', code);

			var reader = new FileReader();

			reader.onload = function(e) {
				doAddImg(data, e.target.result);
			}

			reader.readAsDataURL(this.files[0]);
		}
	});

	jQuery(".adminPage_table2_constructorImg input[name='addimg']").change(function() {
		activeElem=jQuery(this);
		var id= jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().prev().children()[1]).html();
		var tag= jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().prev().children()[2]).children().val().trim();

		var code= "tp"+tag+"p"+id;

		if (this.files && this.files[0]) {
			
			var data = new FormData();
			data.append('img', this.files[0]);
			data.append('imgname', code);

			var reader = new FileReader();

			reader.onload = function(e) {
				doAddConstructorImg(data, e.target.result);
			}

			reader.readAsDataURL(this.files[0]);
		}
	});
	var constrimg=jQuery(".adminPage_table2_constructorImg input[name='addimg']");
	if(constrimg.attr("src")==undefined){
		jQuery(jQuery(constrimg.parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).attr("data-img", "0");
	}else{
		jQuery(jQuery(constrimg.parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).attr("data-img", "1");
	}
	updateStatusConstructor(constrimg);

	jQuery(".adminPage_table1_showItem").on("click", function(){
		var nextelem= jQuery(this).parent().next();
		if(jQuery(nextelem).css("display")=="none"){
			jQuery(nextelem).css("display", "table-row");
			jQuery(this).parent().css("background-color", "lightgreen");
		}else{
			jQuery(nextelem).css("display", "none");
			jQuery(this).parent().css("background-color", "");
		}
	});

	jQuery(".select_type_delivery").on("change", function(){
		jQuery(this).parent().parent().children(".type_delivery.active").removeClass("active");
		
		var value= jQuery(this).val();
		if(value=="curier"){
			jQuery(jQuery(this).parent().parent().children(".type_delivery")[0]).addClass("active");
		}else if(value=="punktvidachi"){
			jQuery(jQuery(this).parent().parent().children(".type_delivery")[1]).addClass("active");
		}else if(value=="post"){
			jQuery(jQuery(this).parent().parent().children(".type_delivery")[2]).addClass("active");
		}
	});
	eventAddProduct();
	eventBtnDeleteItemList();
	eventBtnUpdateProduct();
	eventImgShow();
	eventDeleteSize();
	eventAddSize();
	eventCheckConstructorInput();
	jQuery(".adminPage_listSize input[name='lengthimg']").trigger("change");
}

function eventAddProduct(){
	jQuery(".adminPage_addProduct>div").unbind("click");
	jQuery(".adminPage_addProduct>div").on("click", function(){
		activeElem=jQuery(this);
		doAddProduct();
	});
}

function eventCheckConstructorInput(){
	jQuery(".adminPage_listSize input[name='lengthimg']").unbind("click");
	jQuery(".adminPage_listSize input[name='lengthimg']").change(function(){
		var listSize= jQuery(this).parent().parent().parent().children();
		var check=true;
		for(var i=1; i<=listSize.length; i++){
			var length= jQuery(jQuery(listSize[i]).children()[2]).children().val();
			if(length==""){
				check=false;
				break;
			}
		}

		if(check){
			jQuery(jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).attr("data-input", "1");
		}else{
			jQuery(jQuery(jQuery(this).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).attr("data-input", "0");
		}
		updateStatusConstructor(this);
	});
}

function updateStatusConstructor(elem){
	var input= jQuery(jQuery(jQuery(elem).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).attr("data-input");
	var img= jQuery(jQuery(jQuery(elem).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).attr("data-img");
	
	if(input=="1" && img=="1"){
		jQuery(jQuery(jQuery(elem).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).children().children("[value='1']").prop("disabled", false);
		jQuery(jQuery(jQuery(elem).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).children().val(1);
	}else{
		jQuery(jQuery(jQuery(elem).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).children().children("[value='1']").prop("disabled", true);
		jQuery(jQuery(jQuery(elem).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).children().val(0);
	}
}
	

function eventDeleteSize(){
	jQuery(".deleteItemListSize").unbind("click");
	jQuery(".deleteItemListSize").on("click", function(){
		jQuery(this).parent().remove();
	});
}

function eventAddSize(){
	jQuery(".addItemListSize").unbind("click");
	jQuery(".addItemListSize").on("click", function(){
		showErrorAdminPage(jQuery(this).children("span"));
		var name=jQuery(jQuery(this).parent().children()[0]).children().val().trim();
		var count=jQuery(jQuery(this).parent().children()[1]).children().val().trim();
		var check=false;

		if(name==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[0]).children(), "Поле пусте");
			check=true;
		}else if(name.match(/[^a-zA-Z0-9]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[0]).children(), "Можна тільки латиньскі букви і цифри");
			check=true;
		}else if(!name.match(/^[a-zA-Z0-9]{1,10}$/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[0]).children(), "Максимум 10 символів");
			check=true;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[0]).children());
		}
		if(count==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[1]).children(), "Поле пусте");
			check=true;
		}else if(count.match(/[^0-9]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[1]).children(), "Можна тільки цифри");
			check=true;
		}else if(!count.match(/^[0-9]{1,10}$/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[1]).children(), "Максимум 10 символів");
			check=true;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[1]).children());
		}

		if(check){

		}else{
			var listSizeName=jQuery(this).parent().parent().parent().parent().children(".adminPage_listSize").children().children();
			check=false;
			listSizeName.each(function(id,val){
				if(jQuery(jQuery(val).children()[0]).html()==name){
					check=true;
				}
			});

			if(check){
				showErrorAdminPage(jQuery(this).children("span"), "Такий розмір вже є");
			}else{
				jQuery(this).parent().parent().parent().parent().children(".adminPage_listSize").children().append("<tr>"+
					"<td>"+name+"</td>"+
					"<td><input type='number' name='sizeimg' value='"+count+"''></td>"+
					"<td><input type='number' name='lengthimg'></td>"+
					"<td class='adminPage_products_btn deleteItemListSize'>Видалити</td>"+
					"</tr>");
				eventDeleteSize();
				eventCheckConstructorInput();
				jQuery(jQuery(jQuery(jQuery(this).parent().parent().parent().parent().children()[1]).children().children()[1]).children()[2]).children().trigger("change");
			}
		}
	});
}

function eventImgShow(){
	jQuery(".adminPage_listImg img, .adminPage_constructorImg").unbind("click");
	jQuery(".adminPage_listImg img, .adminPage_constructorImg").on("click", function(){
		jQuery(".adminPage_showImg>div>img").attr("src", jQuery(this).attr("src"));
		jQuery(".adminPage_showImg").css("display", "flex");
	});
}

function eventBtnDeleteItemList(){
	jQuery(".deleteItemListImg").unbind("click");
	jQuery(".deleteItemListImg").on("click", function(){
		var id= jQuery(jQuery(this).parent().parent().parent().parent().parent().prev().children()[1]).html();
		var tag= jQuery(jQuery(this).parent().parent().parent().parent().parent().prev().children()[2]).children().val().trim();
		var num= jQuery(jQuery(this).parent().children()[0]).children().attr("data-num");

		var code= "tp"+tag+"p"+id;
		activeElem=jQuery(this);
		doDeleteImg(code, num);
	});
}

function eventBtnUpdateProduct(){
	jQuery(".adminPage_btnUpdate").unbind("click");
	jQuery(".adminPage_btnUpdate").on("click", function(){console.log("click");
		var check=true;
		var id= jQuery(jQuery(this).parent().children()[1]).html().trim();
		var tag= jQuery(jQuery(this).parent().children()[2]).children().val().trim();
		var name= jQuery(jQuery(this).parent().children()[3]).children().val().trim();
		var company= jQuery(jQuery(this).parent().children()[4]).children().val().trim();
		var price= jQuery(jQuery(this).parent().children()[5]).children().val().trim();
		var discount= jQuery(jQuery(this).parent().children()[6]).children().val().trim();
		var description= jQuery(jQuery(this).parent().children()[7]).children().val().trim();
		var material= jQuery(jQuery(this).parent().children()[8]).children().val().trim();
		var category= jQuery(jQuery(this).parent().children()[9]).children().val().trim();
		var constructor_status= jQuery(jQuery(this).parent().children()[10]).children().val().trim();
		var status= jQuery(jQuery(this).parent().children()[11]).children().val().trim();
		var color= jQuery(jQuery(this).parent().next().children().children(".adminPage_listColor").children().children()[1]).children(".adminPage_loadColor").children().attr("src");
		var listSize= jQuery(this).parent().next().children().children(".adminPage_listSize").children().children();
		var rowSize="";
		if(listSize.length>=2){
			listSize.each(function(id,val){
				if(id!=0){
					var size= jQuery(jQuery(val).children()[0]).html().trim();
					var count= jQuery(jQuery(val).children()[1]).children().val().trim();
					var countsize= count+"."+size;
					if(id!=1){
						rowSize+="-";
					}
					rowSize+=countsize;
				}
			});
		}
		var listImg= jQuery(this).parent().next().children().children(".adminPage_listImg").children().children();

		var rowLength="";
		listSize.each(function(id,val){
			if(id!=0){
				var size= jQuery(jQuery(val).children()[0]).html().trim();
				var length= jQuery(jQuery(val).children()[2]).children().val().trim();
				if(length==""){length=0;}
				var lengthsize= length+"."+size;
				if(id!=1){
					rowLength+="-";
				}
				rowLength+=lengthsize;
			}
		});

		if(tag==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[2]).children(), "Поле пусте");
			check=false;
		}else if(tag.match(/[^0-9]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[2]).children(), "Можна тільки цифри");
			check=false;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[2]).children());
		}

		if(name==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[3]).children(), "Поле пусте");
			check=false;
		}else if(name.match(/[^a-zA-Zа-яА-Я0-9іІїЇєЄъЪёЁ[0-9]\,\.\-\/\s]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[3]).children(), "Доступні символи: a-z а-я 0-9 , . - /");
			check=false;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[3]).children());
		}

		if(company==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children(), "Поле пусте");
			check=false;
		}else if(company.match(/[^a-zA-Zа-яА-Я0-9іІїЇєЄъЪёЁ[0-9]\,\.\-\/\s]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children(), "Доступні символи: a-z а-я 0-9 , . - /");
			check=false;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children());
		}

		if(price==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[5]).children(), "Поле пусте");
			check=false;
		}else if(price.match(/[^0-9]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[5]).children(), "Можна тільки цифри");
			check=false;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[5]).children());
		}

		if(discount==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[6]).children(), "Поле пусте");
			check=false;
		}else if(discount.match(/[^0-9]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[6]).children(), "Можна тільки цифри");
			check=false;
		}else if(discount<0 && discount>100){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[6]).children(), "Мінімум 0, максимум 100");
			check=false;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[6]).children());
		}

		if(description==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[7]).children(), "Поле пусте");
			check=false;
		}else if(description.match(/[^a-zA-Zа-яА-Я0-9іІїЇєЄъЪёЁ[0-9]\,\.\-\/\s]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[7]).children(), "Доступні символи: a-z а-я 0-9 , . - /");
			check=false;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[7]).children());
		}

		if(material==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[8]).children(), "Поле пусте");
			check=false;
		}else if(material.match(/[^a-zA-Zа-яА-Я0-9іІїЇєЄъЪёЁ[0-9]\,\.\-\/\%\s]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[8]).children(), "Доступні символи: a-z а-я 0-9 , . - / %");
			check=false;
		}else{
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[8]).children());
		}

		if(color==undefined){
			showErrorAdminPage(jQuery(this).children("span"), "Колір не додано");
			eventHideErrorForUpdateBtn(jQuery(this));
			check=false;
		}else if(rowSize==""){
			showErrorAdminPage(jQuery(this).children("span"), "Розмір не додано");
			eventHideErrorForUpdateBtn(jQuery(this));
			check=false;
		}else if(listImg.length<3){
			showErrorAdminPage(jQuery(this).children("span"), "Мінімальна к-сть зображень: 2");
			eventHideErrorForUpdateBtn(jQuery(this));
			check=false;
		}

		jQuery(".adminPage_listOrder>table>tbody>tr>.adminPage_btnUpdate").each(function(id,val){
			jQuery(this).css("z-index", "5");
		});
		jQuery(this).css("z-index", "6");

		if(check){
			var result= id+"|"+tag+"|"+name+"|"+company+"|"+price+"|"+discount+"|"+description+"|"+material+"|"+category+"|"+constructor_status+"|"+status+"|"+rowSize+"|"+rowLength;
			activeElem= jQuery(this);
			showErrorAdminPage(activeElem.children(".adminPage_errorMsg"));
			doUpdateProduct(result);
		}
	});
}

function hishBtnAdminPage(elem, num){
	if(num==0){
		jQuery(elem).children("span").css("display", "none");
		jQuery(elem).children("img").css("display", "inline-block");
		jQuery(elem).unbind("click");
	}else if(num==1){
		jQuery(elem).children("span").css("display", "");
		jQuery(elem).children("img").css("display", "");
	}
}

function showErrorAdminPage(elem, text=null){
	if(text==null){
		jQuery(elem).css("border-color", "");
		jQuery(elem).parent().children(".adminPage_errorMsg").remove();
	}else{
		if(!jQuery(elem).parent().children(".adminPage_errorMsg").length){
			jQuery(elem).css("border-color", "red");
			jQuery(elem).parent().append("<div class='adminPage_errorMsg' style='height:"+jQuery(this).height()+";'>"+text+"</div>");
		}
	}
}

function eventHideErrorForUpdateBtn(elem){
	jQuery(document).on("mouseup", function(e){
		if (!jQuery(elem).is(e.target)) {
			jQuery(".adminPage_listOrder>table>tbody>tr>.adminPage_btnUpdate>.adminPage_errorMsg").each(function(id, val){
				jQuery(val).remove();
			});
			jQuery(this).unbind("mouseup");
		}
	});
}

function doAddColor(dataForm, link){
	showErrorAdminPage(activeElem);
	$.ajax({
		type: "POST",
		url: '/models/loadcolor.php',
		cache: false,
		contentType: false,
		processData: false,
		data: dataForm,
		success: function(msg){
			if (msg=="true") {
				jQuery(jQuery(activeElem).parent().parent().children()[0]).children().attr("src", link);
			} else {
				showErrorAdminPage(activeElem, msg);
			}
		}
	});
}

function doAddImg(dataForm, link){
	showErrorAdminPage(activeElem);
	$.ajax({
		type: "POST",
		url: '/models/loadimg.php',
		cache: false,
		contentType: false,
		processData: false,
		data: dataForm,
		success: function(msg){
			if (msg=="true") {
				var num= jQuery(activeElem).parent().parent().parent().parent().parent().children(".adminPage_listImg").children().children().length;
				jQuery(activeElem).parent().parent().parent().parent().parent().children(".adminPage_listImg").children().append("<tr>"+
					"<td><img src='"+link+"'  data-num='"+num+"'></td>"+
					"<td class='adminPage_products_btn deleteItemListImg'><span>Видалити</span><img src='/views/_img/loader2.gif'></td>"+
					"</tr>");
				eventBtnDeleteItemList();
				eventImgShow();
				eventCheckConstructorInput();
				jQuery(activeElem).val("");
			} else {
				showErrorAdminPage(activeElem, msg);
			}
		}
	});
}

function doAddConstructorImg(dataForm, link){
	showErrorAdminPage(activeElem);
	$.ajax({
		type: "POST",
		url: '/models/loadconstructorimg.php',
		cache: false,
		contentType: false,
		processData: false,
		data: dataForm,
		success: function(msg){
			if (msg=="true") {
				jQuery(jQuery(activeElem).parent().parent().children()[0]).children().attr("src", link);
				
				jQuery(jQuery(jQuery(activeElem).parent().parent().parent().parent().parent().parent().parent().children()[1]).children()[10]).attr("data-img", "1");
	
				updateStatusConstructor(jQuery(activeElem));
				eventImgShow();
			} else {
				showErrorAdminPage(activeElem, msg);
			}
		}
	});
}

function doDeleteImg(code, num){
	Router("deleteimg", code, num);
	hishBtnAdminPage(activeElem, 0);
	backsignin1();
}

function backsignin1(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin1, 1000);
	}
	else if(resultRouter == true){ // если данные совпали, переход
		var table= jQuery(activeElem).parent().parent();
		jQuery(activeElem).parent().remove();
		var listProduct= table.children();
		for(var i=0; i<	listProduct.length; i++){
			if(i!=0){
				jQuery(jQuery(listProduct[i]).children()[0]).children().attr("data-num", i);
			}
		}
		setTimeout(function(){
			hishBtnAdminPage(activeElem, 1);
		}, 5000);
		resultRouter=false;
	}else{ // если данные не совплаи
		showErrorAdminPage(activeElem.children("span"), resultRouter);
		hishBtnAdminPage(activeElem, 1);
		resultRouter=false;
	}
}

function doUpdateProduct(updateData){
	hishBtnAdminPage(activeElem, 0);
	Router("updateproductadmin", updateData);
	backsignin2();
}

function backsignin2(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin2, 1000);
	}
	else if(resultRouter == true){ // если данные совпали, переход
		location.href=location.href;
	}else{ // если данные не совплаи
		showErrorAdminPage(activeElem.children("span"), resultRouter);
		hishBtnAdminPage(activeElem, 1);
		eventHideErrorForUpdateBtn(activeElem);
		eventBtnUpdateProduct();
		
		resultRouter=false;
	}
}

function doAddProduct(){
	hishBtnAdminPage(activeElem, 0);
	Router("addproductadmin", null);
	backsignin3();
}

function backsignin3(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin3, 1000);
	}
	else if(resultRouter == true){ // если данные совпали, переход
		location.href=location.href;
	}else{ // если данные не совплаи
		showErrorAdminPage(activeElem.children("span"), resultRouter);
		hishBtnAdminPage(activeElem, 1);
		eventAddProduct();
		eventHideErrorForUpdateBtn(activeElem);
		
		resultRouter=false;
	}
}