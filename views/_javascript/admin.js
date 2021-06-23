var tmr=0;
var code;
var size;
var count;
var activeElem;

jQuery(document).ready(function(){
	startEvents();
});

function startEvents(){
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
	eventBtnDeleteProduct();
	eventBtnAddProduct();
	eventBtnUpdateProduct();
}

function eventBtnDeleteProduct(){
	jQuery(".adminPage_btnDelete").unbind("click");
	jQuery(".adminPage_btnDelete").on("click", function(){
		if(jQuery(this).parent().attr("data-delete")=="true"){
			jQuery(this).parent().attr("data-delete", "false");
			jQuery(this).html("Видалити");
		}else{
			jQuery(this).parent().attr("data-delete", "true");
			jQuery(this).html("Відновити");
		}
		updateSum(jQuery(this).parent().parent().parent());
	});
}

function eventBtnUpdateProduct(){
	jQuery(".adminPage_btnUpdate").unbind("click");
	jQuery(".adminPage_btnUpdate").on("click", function(){
		var check=true;
		var id= jQuery(jQuery(this).parent().children()[1]).html().trim();
		var recipient= jQuery(jQuery(this).parent().children()[3]).children().val().trim();
		var code= jQuery(jQuery(this).parent().children()[4]).children("input[name='phoneid']").val().trim();
		var number= jQuery(jQuery(this).parent().children()[4]).children("input[name='phonenumber']").val().trim();
		var typedelivery= jQuery(jQuery(this).parent().children()[5]).children().val().trim();
		if(typedelivery=="curier"){
			var address= jQuery(jQuery(this).parent().children()[6]).children().val().trim();
		}else if(typedelivery=="punktvidachi"){
			var address= jQuery(jQuery(this).parent().children()[7]).children().val().trim();
			if(address=="1"){
				address="вулиця Михайла Омеляновича-Павленка, 1";
			}else if(address=="2"){
				address="вулиця Митрополита Андрея Шептицького, 4 А";
			}
		}else if(typedelivery=="post"){
			var address= jQuery(jQuery(this).parent().children()[8]).children("select").val().trim();
			var numpost= jQuery(jQuery(this).parent().children()[8]).children("input").val().trim();
			if(numpost==""){
				var address="";
			}else{
				var address= address+"."+numpost;
			}
		}
		var sum= jQuery(jQuery(this).parent().children()[10]).html().trim().replace(" UAH", "");
		var statusOrder= jQuery(jQuery(this).parent().children()[11]).children().val().trim();
		var status= jQuery(jQuery(this).parent().children()[12]).children().val().trim();
		var idUser= jQuery(jQuery(jQuery(this).parent().next().children().children(".adminPage_userData").children().children()[1]).children()[0]).html().trim()
		var statusUser= jQuery(jQuery(jQuery(this).parent().next().children().children(".adminPage_userData").children().children()[1]).children()[7]).children().val().trim();
		var listProduct= jQuery(this).parent().next().children().children(".adminPage_listProduct").children().children("[data-origin='1']");
		var rowProductToDelete="";
		listProduct.each(function(id,val){
			if(jQuery(val).attr("data-delete")=="true"){
				var code = jQuery(val).attr("data-code").trim();
				var idprod= code.replace(/^tp[0-9]+p/, "");
				var size= jQuery(val).attr("data-size").trim();
				var price= jQuery(jQuery(val).children()[4]).html().replace(" UAH", "");
				var count= jQuery(jQuery(val).children()[5]).html();
				var prod= idprod+"."+size+"."+price+"."+count;
				if(rowProductToDelete!=""){
					prod= "-"+prod;
				}
				rowProductToDelete+=prod;
			}
		});
		var listProduct= jQuery(this).parent().next().children().children(".adminPage_listProduct").children().children("[data-origin='0']");
		var rowProductToAdd="";
		listProduct.each(function(id,val){
			if(jQuery(val).attr("data-delete")=="false"){
				var code = jQuery(val).attr("data-code").trim();
				var idprod= code.replace(/^tp[0-9]+p/, "");
				var size= jQuery(val).attr("data-size").trim();
				var price= jQuery(jQuery(val).children()[4]).html().replace(" UAH", "");
				var count= jQuery(jQuery(val).children()[5]).html();
				var prod= idprod+"."+size+"."+price+"."+count;
				if(rowProductToAdd!=""){
					prod= "-"+prod;
				}
				rowProductToAdd+=prod;
			}
		});

		if(recipient==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[3]).children(), "Поле пусте");
			check=false;
		}else if(recipient.match(/[^a-zA-Zа-яА-ЯіІїЇєЄъЪёЁ\s]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[3]).children(), "Можна тільки букви");
			check=false;
		}

		if(code==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children("input[name='phoneid']"), "Поле пусте");
			check=false;
		}else if(code.match(/[^0-9]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children("input[name='phoneid']"), "Можна тільки цифри");
			check=false;
		}else if(code.match(/[^0-9]{1,2}/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children("input[name='phoneid']"), "Мінімум 1 цифра. Максимум 2");
			check=false;
		}

		if(number==""){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children("input[name='phonenumber']"), "Поле пусте");
			check=false;
		}else if(number.match(/[^0-9]+/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children("input[name='phonenumber']"), "Можна тільки цифри");
			check=false;
		}else if(number.match(/[^0-9]{7}/)){
			showErrorAdminPage(jQuery(jQuery(this).parent().children()[4]).children("input[name='phonenumber']"), "Повинно бути 7 цифр");
			check=false;
		}

		if(address==""){
			if(typedelivery=="curier"){
				showErrorAdminPage(jQuery(jQuery(this).parent().children()[6]).children(), "Поле пусте");
			}else if(typedelivery=="punktvidachi"){
				showErrorAdminPage(jQuery(jQuery(this).parent().children()[7]).children(), "Поле пусте");
			}else if(typedelivery=="post"){
				showErrorAdminPage(jQuery(jQuery(this).parent().children()[8]).children("input"), "Поле пусте");
			}
			check=false;
		}else if(address.match(/[^a-zA-Zа-яА-Я0-9іІїЇєЄъЪёЁ\,\.\-\/\s]+/)){
			if(typedelivery=="curier"){
				showErrorAdminPage(jQuery(jQuery(this).parent().children()[6]).children(), "Дозволені символи: a-z а-я , . - /");
			}else if(typedelivery=="punktvidachi"){
				showErrorAdminPage(jQuery(jQuery(this).parent().children()[7]).children(), "Дозволені символи: a-z а-я , . - /");
			}else if(typedelivery=="post"){
				showErrorAdminPage(jQuery(jQuery(this).parent().children()[8]).children("input"), "Дозволені символи: a-z а-я , . - /");
			}
			check=false;
		} 

		if(check){
			var result= id+"|"+recipient+"|"+code+"-"+number+"|"+typedelivery+"|"+address+"|"+sum+"|"+statusOrder+"|"+status+"|"+idUser+"|"+statusUser+"|"+rowProductToDelete+"|"+rowProductToAdd;
			activeElem= jQuery(this);
			showErrorAdminPage(activeElem.children(".adminPage_errorMsg"));
			doUpdateOrder(result);
		}
	});
}

function eventBtnAddProduct(){
	jQuery(".adminPage_btnAdd").unbind("click");
	jQuery(".adminPage_btnAdd").on("click", function(){
		activeElem=jQuery(this);
		code= jQuery(activeElem.parent().children("td")[0]).children("input").val().trim();
		size= jQuery(activeElem.parent().children("td")[1]).children("input").val().trim();
		count= jQuery(activeElem.parent().children("td")[2]).children("input").val().trim();
		
		if(code==""){
			showErrorAdminPage(jQuery(activeElem.parent().children("td")[0]).children("input"), "Поле пусте");
		}else{
			showErrorAdminPage(jQuery(activeElem.parent().children("td")[0]).children("input"));
		}
		if(size==""){
			showErrorAdminPage(jQuery(activeElem.parent().children("td")[1]).children("input"), "Поле пусте");
		}else{
			showErrorAdminPage(jQuery(activeElem.parent().children("td")[1]).children("input"));
		}
		if(count==""){
			showErrorAdminPage(jQuery(activeElem.parent().children("td")[2]).children("input"), "Поле пусте");
		}else{
			showErrorAdminPage(jQuery(activeElem.parent().children("td")[2]).children("input"));
		}

		if(code!="" && size!="" && count!=""){
			var listProduct= activeElem.parent().parent().parent().parent().children(".adminPage_listProduct").children().children();
			var check=true;
			showErrorAdminPage(activeElem.children("span"));
			listProduct.each(function(id,val){
				if(jQuery(val).attr("data-delete")!="true" && jQuery(val).attr("data-code")==code && jQuery(val).attr("data-size")==size){
					showErrorAdminPage(activeElem.children("span"), "Товар вже є у списку");
					check=false;
					return false;
				}
			});
			if(check){
				doGetNewProduct(code, size, count);
			}
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
		eventBtnAddProduct();
		eventBtnUpdateProduct();
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

function updateSum(elem){
	var list= jQuery(elem).children().children("tr");
	var sum=0;
	list.each(function(id,val){
		if(jQuery(val).attr("data-delete")=="false"	){
			var val=jQuery(jQuery(val).children("td")[6]).html().replace(" UAH", "");
			sum+=parseInt(val);
		}
	});
	jQuery(jQuery(elem).parent().parent().prev().children("td")[10]).html(sum+" UAH");
}
function eventHideErrorForUpdateBtn(elem){
	jQuery(document).click(function(e){
		if (!elem.is(e.target)) {
			jQuery(".adminPage_listOrder>table>tbody>tr>.adminPage_btnUpdate>.adminPage_errorMsg").each(function(id, val){
				jQuery(val).remove();
			});
			jQuery(this).unbind("click");
		}
	});
}

function doGetNewProduct(code, size, count){
	hishBtnAdminPage(activeElem, 0);
	Router("getproductforadmin", code, size, count);
	backsignin1();
}

function backsignin1(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin1, 1000);
	}
	else if(typeof resultRouter=="object"){ // если данные совпали, переход
		hishBtnAdminPage(activeElem, 1);
		activeElem.parent().parent().parent().parent().children(".adminPage_listProduct").append('<tr data-delete="false" data-code="'+code+'" data-size="'+size+'" data-origin="0">'+
							'<td>'+code+'</td>'+
							'<td><a href="/product/'+code+'">'+resultRouter["name"]+' '+resultRouter["company"]+'</a></td>'+
							'<td><img src="/data/product/color/'+code+'.jpg"></td>'+
							'<td>'+size+'</td>'+
							'<td>'+resultRouter["price"]+' UAH</td>'+
							'<td>'+count+'</td>'+
							'<td>'+(count*resultRouter["price"])+' UAH</td>'+
							'<td class="adminPage_listOrder_btn adminPage_btnDelete">Видалити</td>'+
						'</tr>');
		updateSum(activeElem.parent().parent().parent().prev());
		resultRouter=false;
		code="";
		size="";
		count="";
		eventBtnDeleteProduct();
		eventBtnAddProduct();
	}else{ // если данные не совплаи
		showErrorAdminPage(activeElem.children("span"), resultRouter);
		hishBtnAdminPage(activeElem, 1);
		
		resultRouter=false;
	}
}

function doUpdateOrder(updateData){
	jQuery(".adminPage_listOrder>table>tbody>tr>.adminPage_btnUpdate").each(function(id,val){
		jQuery(this).css("z-index", "5");
	});
	jQuery(activeElem).css("z-index", "6");
	hishBtnAdminPage(activeElem, 0);
	Router("updateorderadmin", updateData);
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
		
		resultRouter=false;
	}
}