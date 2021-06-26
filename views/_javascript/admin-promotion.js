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

	jQuery(".adminPage_listPromotion input[name='addimg']").change(function() {
		activeElem=jQuery(this);
		var id= jQuery(this).parent().prev().prev().html().trim();

		if (this.files && this.files[0]) {
			
			var data = new FormData();
			data.append('img', this.files[0]);
			data.append('imgname', id);

			var reader = new FileReader();

			reader.onload = function(e) {
				doAddPromo(data, e.target.result);
			}

			reader.readAsDataURL(this.files[0]);
		}
	});

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

	eventAddProduct();
	eventBtnDeleteItemList();
	eventBtnUpdateProduct();
	eventImgShow();
}

function eventAddProduct(){
	jQuery(".addImg").unbind("click");
	jQuery(".addImg").on("click", function(){
		var code= jQuery(this).prev().children().val();
		var check= false;
		if(code==""){
			showErrorAdminPage(jQuery(this).prev().children(), "Поле пусте");
			check=true;
		}else if(code.match(/[^a-zA-Z0-9]+/)){
			showErrorAdminPage(jQuery(this).prev().children(), "Можна тільки латиньскі букви і цифри");
			check=true;
		}else{
			showErrorAdminPage(jQuery(this).prev().children());
		}

		if(!check){
			var result= code.replace(/^(tp[0-9]+p)/, "");
			if(!isNaN(result)){
				activeElem= jQuery(this);
				showErrorAdminPage(activeElem.children("span"));
				doAddProduct(result);
			}	
		}
		
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

function eventImgShow(){
	jQuery(".adminPage_imgPromotion, .adminPage_listProduct img").unbind("click");
	jQuery(".adminPage_imgPromotion, .adminPage_listProduct img").on("click", function(){
		jQuery(".adminPage_showImg>div>img").attr("src", jQuery(this).attr("src"));
		jQuery(".adminPage_showImg").css("display", "flex");
	});
}

function eventBtnDeleteItemList(){
	jQuery(".deleteItemListImg").unbind("click");
	jQuery(".deleteItemListImg").on("click", function(){
		jQuery(this).parent().remove();
	});
}

function eventBtnUpdateProduct(){
	jQuery(".adminPage_btnUpdate").unbind("click");
	jQuery(".adminPage_btnUpdate").on("click", function(){
		var check=true;
		var id= jQuery(jQuery(this).parent().children()[1]).html().trim();
		var imgPromo= jQuery(jQuery(this).parent().children()[2]).children().attr("src");
		var status= jQuery(jQuery(this).parent().children()[4]).children().val().trim();

		var listProduct= jQuery(this).parent().next().children().children(".adminPage_listProduct").children().children();

		var rowProduct="";
		listProduct.each(function(id,val){
			if(id!=0){
				var idp= jQuery(jQuery(val).children()[0]).html().trim();
				var idp= idp.replace(/^(tp[0-9]+p)/, "");

				if(id!=1 && idp!="" && !isNaN(idp)){
					rowProduct+=".";
				}
				rowProduct+=idp;
			}
		});

		if(imgPromo==undefined){
			showErrorAdminPage(jQuery(this).children("span"), "Зображення не додано");
			eventHideErrorForUpdateBtn(jQuery(this));
			check=false;
		}else if(listProduct.length<2){
			showErrorAdminPage(jQuery(this).children("span"), "Мінімальна к-сть товарів: 1");
			eventHideErrorForUpdateBtn(jQuery(this));
			check=false;
		}

		jQuery(".adminPage_listOrder>table>tbody>tr>.adminPage_btnUpdate").each(function(id,val){
			jQuery(this).css("z-index", "5");
		});
		jQuery(this).css("z-index", "6");

		if(check){
			var result= id+"|"+status+"|"+rowProduct;
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

function doAddPromo(dataForm, link){
	showErrorAdminPage(activeElem);
	$.ajax({
		type: "POST",
		url: '/models/loadimgpromo.php',
		cache: false,
		contentType: false,
		processData: false,
		data: dataForm,
		success: function(msg){
			if (msg=="true") {
				jQuery(activeElem).parent().prev().children().attr("src", link);
				eventImgShow();
				jQuery(activeElem).val("");
			} else {
				showErrorAdminPage(activeElem, msg);
			}
		}
	});
}

function doAddProduct(result){
	Router("getprodforpromo", result);
	hishBtnAdminPage(activeElem, 0);
	backsignin1();
}

function backsignin1(){
	if(tmr>0 || resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin1, 1000);
	}
	else if(typeof resultRouter== "object"){ // если данные совпали, переход
		jQuery(activeElem).parent().parent().parent().parent().children(".adminPage_listProduct").children().append("<tr>"+
							"<td>tp"+resultRouter["tag"]+"p"+resultRouter["id"]+"</td>"+
							"<td>"+resultRouter["name"]+" "+resultRouter["company"]+"</td>"+
							"<td><img src='/data/product/img/tp"+resultRouter["tag"]+"p"+resultRouter["id"]+"/1.jpg' class='adminPage_itemListImg'></td>"+
							"<td class='adminPage_products_btn deleteItemListImg'><span>Видалити</span><img src='/views/_img/loader2.gif'></td>"+
						"</tr>");
		
		hishBtnAdminPage(activeElem, 1);
		eventAddProduct()
		eventBtnDeleteItemList();
		resultRouter=false;
	}else{ // если данные не совплаи
		showErrorAdminPage(activeElem.children("span"), resultRouter);
		hishBtnAdminPage(activeElem, 1);
		resultRouter=false;
	}
}

function doUpdateProduct(updateData){
	hishBtnAdminPage(activeElem, 0);
	Router("updatepromotionadmin", updateData);
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