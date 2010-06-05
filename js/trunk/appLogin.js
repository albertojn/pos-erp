

/* --------------------------------------------
	appLogin contiene todas las funciones para 
	el manejo de validacion de usuarios
-------------------------------------------- */


AppLogin = function ()
{
	
	
	this._init();

}



AppLogin.prototype._init = function ()
{
	
	var html_content = '';
	html_content += '<div id="login" class="box login">';
	html_content += '<div class="title">Acceder</div>';
	html_content += '<div>usr  <input id="login0" type="text"></div>';
	html_content += '<div>pswd <input id="login1" type="password"></div>';
	html_content += '<div><input type="button" id="login2" style="width: 70px" value="aceptar" onclick="login.checkCurrentLoginInfo()"></div>';
	html_content += "</div>";
	html_content += "</div>";
	
	
	Ext.get("work_zone").update(html_content);
	
}



AppLogin.prototype.showForm = function ()
{

	Ext.get("login").fadeIn();
}





AppLogin.prototype.fadeForm = function ()
{

	Ext.get("login").fadeOut({  
		endOpacity: 0.3,
		callback: function(){
				Ext.get("login0").dom.disabled = true;
				Ext.get("login1").dom.disabled = true;
				Ext.get("login2").dom.disabled = true;
			}
		
		});

}



AppLogin.prototype.checkCurrentStatus = function ()
{
	
	
}



AppLogin.prototype.checkCurrentLoginInfo = function ()
{
	
	//fade the form
	this.fadeForm();
	
	//start the effect of loading
	Ext.get("login").frame("C3DAF9", 100);
	
	//make ajax
	Ext.Ajax.request({
	   url: 'getResource.php',
	   success: login.ajaxSuccess,
	   failure: login.ajaxFailure,
	   headers: {
	       'my-header': 'foo'
	   },
	   params: { foo: 'bar' }
	});
	
	
}



AppLogin.prototype.ajaxSuccess = function ( data )
{
	//Ext.get("login").hasActiveFx
	console.log(data)
	
}



AppLogin.prototype.ajaxFailure = function ()
{
	
}