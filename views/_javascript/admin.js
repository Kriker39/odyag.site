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
		jQuery(".adminPage_btnAdd").unbind("click");
	}else if(num==1){
		jQuery(elem).children("span").css("display", "");
		jQuery(elem).children("img").css("display", "");
		eventBtnAddProduct();
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

function doGetNewProduct(code, size, count){
	hishBtnAdminPage(activeElem, 0);
	Router("getproductforadmin", code, size, count);
	backsignin1();
}

function backsignin1(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin1, 1000);
	}
	else if(typeof resultRouter=="object" && resultRouter != null){ // если данные совпали, переход
		hishBtnAdminPage(activeElem, 1);
		activeElem.parent().parent().parent().parent().children(".adminPage_listProduct").append('<tr data-delete="false" data-code="'+code+'" data-size="'+size+'">'+
							'<td>'+code+'</td>'+
							'<td><a href="/product/'+code+'">'+resultRouter["name"]+' '+resultRouter["company"]+'</a></td>'+
							'<td><img src="/data/product/color/'+code+'.jpg"></td>'+
							'<td>'+size+'</td>'+
							'<td>'+resultRouter["price"]+' UAH</td>'+
							'<td>'+count+'</td>'+
							'<td>'+(count*resultRouter["price"])+' UAH</td>'+
							'<td class="adminPage_listOrder_btn adminPage_btnDelete">Видалити</td>'+
						'</tr>');
		jQuery()
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