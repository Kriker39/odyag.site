var expanded = false; // мульти селектор
var products ;
var active_sudmit = false;
var changesInFilter = [];
var saveListProduct = jQuery(".product>ul>li");

var filter = ["Новизною", "Виберіть розмір"];
var sizeElem=0;

jQuery(document).ready(function(){
	startImgHover();
	startCheckboxes();
	startSubmitFilter();
	startResetFilter();
});

function startImgHover(){
	jQuery(".product a").on("mouseenter", function(){
		var src=jQuery(this).children().attr("src");
		var newsrc= src.replace("1.jpg", "2.jpg");

		jQuery(this).children().attr("src", newsrc);
	});

	jQuery(".product a").on("mouseleave", function(){
		var src=jQuery(this).children().attr("src");
		var newsrc= src.replace("2.jpg", "1.jpg");

		jQuery(this).children().attr("src", newsrc);
	});
}

function startCheckboxes() {
	jQuery(".container_select").on("click", function(){
		var elem= jQuery(this).parent();
		var checkboxes = elem.children(".checkboxes");
		if (!expanded) {
			checkboxes.css("display", "block");
			expanded = true;
			jQuery(document).on("mouseup", function(e){
				if(!elem.is(e.target)&& elem.has(e.target).length === 0){
					checkboxes.css("display", "none");
					expanded = false;
					jQuery(document).unbind("mouseup");
				}
			});
		} else {
			checkboxes.css("display", "none");
			expanded = false;
			jQuery(document).unbind("click");
		}
	});
	
	jQuery(".checkboxes>li").on("click", function(){
		var text= jQuery(this).parent().parent().children(".container_select").children("select").children();
		var checkbox= jQuery(this).children("p");

		if(jQuery(this).children("input").attr("type")=="checkbox"){
			if (jQuery(this).children("input").is(':checked')) {
				jQuery(this).children("input").prop("checked", false);
				changeTextSelectorCheckbox(false, text, checkbox);
			} else {
				jQuery(this).children("input").prop("checked", true);
				changeTextSelectorCheckbox(true, text, checkbox);
			}
			workFilter();
		}else if(jQuery(this).children("input").attr("type")=="radio"){
			if (!jQuery(this).children("input").is(':checked')) {
				var mas= jQuery(this).parent().children("li");
				mas.each(function (id, val){
					jQuery(val).children("input").prop("checked", false);
				});
				jQuery(this).children("input").prop("checked", true);
				changeTextSelectorRadio(text, checkbox);
				workFilter();
			}
		}
	});
}

function changeTextSelectorCheckbox(change, text, checkbox){
	var oldtext= text.html();
	var newtext = checkbox.html();

	if(change){
		if(oldtext=="Виберіть розмір"){
			text.html(newtext);
		}else{
			text.append(" | "+newtext);
		}
	}else{
		if(oldtext.indexOf(" | "+newtext)!=-1){
			text.html(oldtext.replace(" | "+newtext, ""));
		}else if(oldtext.indexOf(newtext+" | ")!=-1){
			text.html(oldtext.replace(newtext+" | ", ""));
		}else{
			text.html(oldtext.replace(newtext, "Виберіть розмір"));
		}
	}
}

function changeTextSelectorRadio(text, checkbox){
	var oldtext= text.html();
	var newtext = checkbox.html();

	text.html(newtext);
	checkbox.parent().children("input").prop("checked", true);
}

function workFilter(){
	var newFilter= [];
	var sizeFilter=jQuery(".filter2>div>select>option").html().split(" | ");
	newFilter.push(jQuery(".filter1>div>select>option").html());

	sizeFilter.forEach(function(val){
		newFilter.push(val);
	});

	var isEqual= false;

	if(newFilter.length==filter.length){
		for(var i=0; i<newFilter.length; i++){
			if (filter.indexOf(newFilter[i])==-1){
				isEqual=true;
				break;
			}
			if (newFilter.indexOf(filter[i])==-1){
				isEqual=true;
				break;
			}
		}
	}else{
		isEqual= true;
	}

	if(filter[0]==newFilter[0]){
		newFilter.shift();
	}

	if(isEqual){
		changesInFilter = newFilter;
		jQuery(".submit_filter").css("display","inline-block");
	}else{
		jQuery(".submit_filter").css("display","none");
	}

	
}

function startSubmitFilter() {
	products=jQuery(".product>ul>li");

	jQuery('.submit_filter').on("click", function() {
		var filterNow= [];
		filterNow.push(jQuery(".filter1>div>select>option").html());
		filterNow.push(jQuery(".filter2>div>select>option").html());console.log(filterNow);
		if(filterNow[0]=="Новизною" && filterNow[1]=="Виберіть розмір"){
			jQuery(".reset_filter").css("display", "none");
		}else{
			jQuery(".reset_filter").css("display", "inline-block");
		}
		if(changesInFilter.indexOf("Спаданням ціни")!=-1){	
			for (var i = 0; i < products.length; i++) {
				var endSort=true;
				for (var j = 0; j < products.length; j++) {
					if(jQuery(jQuery(".product>ul>li")[j]).attr("data-price") < jQuery(jQuery(".product>ul>li")[j+1]).attr("data-price")){
						swapElements(jQuery(".product>ul>li")[j], jQuery(".product>ul>li")[j+1]);
						endSort=false;
					}
				}
				if(endSort){
					break;
				}
			}
			changesInFilter.shift();
		}else if(changesInFilter.indexOf("Зростанням ціни")!=-1){
			for (var i = 0; i < products.length; i++) {
				var endSort=true;
				for (var j = 0; j < products.length-1; j++) {
					if(jQuery(jQuery(".product>ul>li")[j]).attr("data-price") > jQuery(jQuery(".product>ul>li")[j+1]).attr("data-price")){
						swapElements(jQuery(".product>ul>li")[j], jQuery(".product>ul>li")[j+1]);
						endSort=false;
					}
				}
				if(endSort){
					break;
				}
			}
			changesInFilter.shift();
		}else if(changesInFilter.indexOf("Популярністю")!=-1){
			for (var i = 0; i < products.length; i++) {
				var endSort=true;
				for (var j = 0; j < products.length-1; j++) {
					if(Number(jQuery(jQuery(".product>ul>li")[j]).attr("data-views")) < Number(jQuery(jQuery(".product>ul>li")[j+1]).attr("data-views"))){
						swapElements(jQuery(".product>ul>li")[j], jQuery(".product>ul>li")[j+1]);
						endSort=false;
					}
				}console.log("ssa");
				// if(endSort){
				// 	break;
				// }
			}
			changesInFilter.shift();
		}else if(changesInFilter.indexOf("Новизною")!=-1){
			for (var i = 0; i < products.length; i++) {
				var endSort=true;
				for (var j = 0; j < products.length-1; j++) {
					if(jQuery(jQuery(".product>ul>li")[j]).attr("data-id") < jQuery(jQuery(".product>ul>li")[j+1]).attr("data-id")){
						swapElements(jQuery(".product>ul>li")[j], jQuery(".product>ul>li")[j+1]);
						endSort=false;
					}
				}
				if(endSort){
					break;
				}
			}
			changesInFilter.shift();
		}

		if(changesInFilter.length>=1){
			if(changesInFilter[0]=="Виберіть розмір"){
				products.each(function(id, val){
				jQuery(val).css("display", "inline-block");
			});
			}else{
				products.each(function(id, val){
					jQuery(val).css("display", "none");
				});

				products.each(function(id, val){
					var sizeAndSum= jQuery(val).attr("data-size").split("-");
					
					for(var i=0; i<sizeAndSum.length; i++){
						var masSize= sizeAndSum[i].split(".");
						for(var j=0; j<changesInFilter.length; j++){
							if(masSize[1]==changesInFilter[j] && masSize[0]>0){
								jQuery(val).css("display", "inline-block");
								break;
							}
						}
					}
				});
			}
		}
		
		changesInFilter= [];
		filter = [];


		var sizeFilt=jQuery(".filter2>div>select>option").html().split(" | ");

		filter.push(jQuery(".filter1>div>select>option").html());
		sizeFilt.forEach(function(val){
			filter.push(val);
		});

		jQuery(".submit_filter").css("display","none");
		
		var y = $(window).scrollTop(); 
		$(window).scrollTop(y+1);
		$(window).scrollTop(y);
	});
}

function startResetFilter(){
	jQuery('.reset_filter').on("click", function() {console.log(jQuery('.filter1>ul>li>input[name="main"]'));
		jQuery('.filter1>ul>li>input[name="main"]').parent().trigger("click");
		var filter2=jQuery('.filter2>ul>li');
		filter2.each(function(id, val){
			if(jQuery(val).children("input").prop("checked")){
				jQuery(val).trigger("click");
			}
		});
		jQuery('.submit_filter').trigger("click");
	});
}

function swapElements(obj1, obj2) {
    // create marker element and insert it where obj1 is
    var temp = document.createElement("div");
    obj1.parentNode.insertBefore(temp, obj1);

    // move obj1 to right before obj2
    obj2.parentNode.insertBefore(obj1, obj2);

    // move obj2 to right before where obj1 used to be
    temp.parentNode.insertBefore(obj2, temp);

    // remove temporary marker node
    temp.parentNode.removeChild(temp);
}
