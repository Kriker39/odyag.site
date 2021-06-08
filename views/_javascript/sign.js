var errorSignIn=[];
var errorSignUp=[];

jQuery(document).ready(function(){
	startSignEvent();

});

function startSignEvent(){
	jQuery(".container_signUp").on("mouseenter", function(){
		jQuery(".container_signIn").css("width", "40%");
		jQuery(".container_signUp").css("width", "60%");
		jQuery(".signUpInput").css("opacity", "1");
		jQuery(".signInInput").css("opacity", "0");
	});
	jQuery(".container_signIn").on("mouseenter", function(){
		jQuery(".container_signIn").css("width", "60%");
		jQuery(".container_signUp").css("width", "40%");
		jQuery(".signUpInput").css("opacity", "0");
		jQuery(".signInInput").css("opacity", "1");
	});
	jQuery(".shadow_boardSign").on("click", function(){
		jQuery(".boardSign").css("display", "none");
	});
	jQuery(".forgotPass").on("click", function(){
		jQuery(".boardSign").css("display", "inline-block");
	});
	jQuery("input[name='email']").on("focusout", function(){
		var email= jQuery(this).val().trim();

		if(email!=""){
			if(!validateEmail(email)){
				showError(this, "У поле потрібно вписати електронну пошту. Приклад: example@gmail.com");
			}
		}else{
			showError(this, "Заповніть поле для електронної пошти");
		}
	});
	jQuery("input[name='email']").on("focusout", function(){ 
		var email= jQuery(this).val().trim();

		if(email!=""){
			if(validateEmail(email)){
				hideError(this);
			}else{
				showError(this, "У поле потрібно вписати електронну пошту. Приклад: example@gmail.com");
			}
		}else{
			showError(this, "Заповніть поле для електронної пошти");
		}
	});
	jQuery("input[name='login']").on("focusout", function(){ 
		var login= jQuery(this).val().trim();

		if(login!=""){
			if(validateLogin(login)){
				hideError(this);
			}else{
				showError(this, "Логін повинен бути від 3 до 16 символів. Дозволені символи: a-z 0-9 _ -");
			}
		}else{
			showError(this, "Заповніть поле для логіну");
		}
	});
	jQuery("input[name='password']").on("focusout", function(){ 
		var pass= jQuery(this).val().trim();
		
		if(pass!=""){
			if(validatePassword(pass)){
				hideError(this);
			}else{
				showError(this, "Пароль повинен бути від 6 до 50 символів і мати по 1 символу, цифрі, букві у верхньому і нижньому регістрі.<br> Дозволені символи: a-z A-Z 0-9 ! @ # $ & * ");
			}
		}else{
			showError(this, "Заповніть поле для паролю");
		}
	});
	jQuery(".showHidePass").on("click", function(){ 
		var href= jQuery(this).attr("href");
		jQuery(this).attr("href", jQuery(this).attr("src"));
		jQuery(this).attr("src", href);
		if(jQuery(this).next().attr("type")=="text"){
			jQuery(this).next().attr("type", "password");
		}else{
			jQuery(this).next().attr("type", "text");
		}
		
	});
	jQuery(".signInButton").on("click", function(){ 
		jQuery(".signInInput [name='login']").trigger("focusout");
		jQuery(".signInInput [name='password']").trigger("focusout");
		
		if(errorSignIn.length==0 ){
			var login=jQuery(".signInInput [name='login']").val().trim();
			var pass=jQuery(".signInInput [name='password']").val().trim();
			doSignIn(login, pass);
			jQuery(this).unbind();
		}
	});
	jQuery(".signUpButton").on("click", function(){ 
		jQuery(".signUpInput [name='email']").trigger("focusout");
		jQuery(".signUpInput [name='login']").trigger("focusout");
		jQuery(".signUpInput [name='password']").trigger("focusout");

		if(errorSignUp.length==0){
			var email=jQuery(".signUpInput [name='email']").val().trim();
			var login=jQuery(".signUpInput [name='login']").val().trim();
			var pass=jQuery(".signUpInput [name='password']").val().trim();
			doSignUp(email, login, pass);
			jQuery(this).unbind();
		}
	});
}

function showError(elem, text){
	if(jQuery(elem).next().attr("name")=="errorText"){
		jQuery(elem).next().remove();
	}
	jQuery(elem).after("<span name=\"errorText\">"+text+"</span>");
	jQuery(elem).addClass("signError");
	if(jQuery(elem).parent().attr("class").indexOf("signInput")!=-1){
		if(jQuery(elem).parent().attr("class").indexOf("signUpInput")!=-1){
			if(errorSignUp.indexOf(elem)==-1){
				errorSignUp.push(elem);
			}
		}else{
			if(errorSignIn.indexOf(elem)==-1){
				errorSignIn.push(elem);
			}
		}
	}
}

function hideError(elem){
	if(jQuery(elem).next().attr("name")=="errorText"){
		jQuery(elem).next().remove();
	}
	jQuery(elem).removeClass("signError");
	if(jQuery(elem).parent().attr("class").indexOf("signInput")!=-1){
		if(jQuery(elem).parent().attr("class").indexOf("signUpInput")!=-1){
			if(errorSignUp.indexOf(elem)!=-1){ 
				errorSignUp.splice(errorSignUp.indexOf(elem), 1);
			}
		}else{
			if(errorSignIn.indexOf(elem)!=-1){ 
				errorSignIn.splice(errorSignIn.indexOf(elem), 1);
			}
		}
	}
}

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email));
}

function validateLogin(login) {
    const re = /^[a-zA-Z0-9_-]{3,16}$/;
    return re.test(String(login));
}

function validatePassword(pass) {
    const re = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/;
    return re.test(String(pass));
}

function doSignIn(login, pass){
	jQuery(".signInButton").html("<img src=\"/views/_img/loader1.gif\">");
	Router("signin", login, pass);
	backsignin1();
}

function doSignUp(email, login, pass){
	jQuery(".signUpButton").html("<img src=\"/views/_img/loader1.gif\">");
	Router("signup", email, login, pass);
	backsignin2();
}

function backsignin1(){
	if(resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin1, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		$(location).attr('href','/profile');
		exit();
	}else{ // если данные не совплаи
		jQuery(".signInButton").html("ВХІД");
		
		jQuery(".signInButton").on("click", function(){ 
			jQuery(".signInInput [name='login']").trigger("focusout");
			jQuery(".signInInput [name='password']").trigger("focusout");
			
			if(errorSignIn.length==0 ){
				var login=jQuery(".signInInput [name='login']").val().trim();
				var pass=jQuery(".signInInput [name='password']").val().trim();
				doSignIn(login, pass);
				jQuery(this).unbind();
			}
		});
	
	
		showError(jQuery(".signIn input[name='login']")[0], resultRouter);

		resultRouter=false;
	}
}

function backsignin2(){
	if(resultRouter==false){ // если результата нет, повторяет эту функцию каждую 1 сек
		setTimeout(backsignin2, 1000);
	}
	else if(resultRouter==true){ // если данные совпали, переход
		$(location).attr('href','/profile');
		exit();
	}else{ // если данные не совплаи
		jQuery(".signUpButton").html("РЕЄСТРАЦІЯ");
		

		jQuery(".signUpButton").on("click", function(){ 
			jQuery(".signUpInput [name='email']").trigger("focusout");
			jQuery(".signUpInput [name='login']").trigger("focusout");
			jQuery(".signUpInput [name='password']").trigger("focusout");
			if(errorSignUp.length==0){
				var email=jQuery(".signUpInput [name='email']").val().trim();
				var login=jQuery(".signUpInput [name='login']").val().trim();
				var pass=jQuery(".signUpInput [name='password']").val().trim();
				doSignUp(email, login, pass);
				jQuery(this).unbind();
			}
		});

		showError(jQuery(".signUp input[name='"+resultRouter[0]+"']")[0], resultRouter[1]);

		resultRouter=false;
	}
}