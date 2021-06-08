var routs, checkRouter=false, firstcallback=true, resultRouter=false;

function getroutes(){
	jQuery.getScript("/config/routes.js", function(data){
		routs= routes;
		checkRouter=true;
	});
}

function Router(){
	var args = Array.prototype.slice.call(arguments);

	if(firstcallback){
		getroutes();
		firstcallback=false;
	}

	if(checkRouter==false){
		setTimeout(Router, 1000, args);
	}else{
		while(args[0][0].length!=1){
			args=args[0];
		}

		for(var route of routs){
			if(route[0]==args[0]){
				args.shift();
				rout=route[1].split("/");
				var controllerName= rout.shift();
					controllerName= controllerName[0].toUpperCase() + controllerName.slice(1) + "Controller";
				var actionName= rout.shift();
					actionName= "jsaction"+actionName[0].toUpperCase() + actionName.slice(1) ;
				var parameters= args;

				jQuery.ajax({
					type: "POST",
					url: "/components/adapterJSRouter.php",
					data: {'controller': controllerName, 'action': actionName, 'args': parameters},
					dataType: 'json',
					cache: false,
					success: function(text){
						if(text==1){
							resultRouter=true;
						}else{
							resultRouter=text;
						}
					}
				});

				break;
			}
		}

		firstcallback=true;
		checkRouter=false;
	}
}