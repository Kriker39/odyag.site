function changeLinkSearch(e){
	var searchText= jQuery(e).val();
	jQuery(".searchImg>a").attr("href","/search/"+searchText);
}
