module.exports = function (request, response, controllerName) {
    this.request  = request;
    this.response = response;
    this.viewPath = controllerName + "/";
    
	this.login = function () {
	    this.response.render(this.viewPath + "login.html", 
	        {	
	        	errorMessage: "", 
	        	id: "",
	        	password: "",
	        	userName: request.session.userName
	        }
	    );
	}

	this.post_login = function () {
		var error = "";
		if (this.request.body.txtID == "") {
			error += "Please keyin user name<br>";
		}
		if (this.request.body.txtPassword == "") {
			error += "Please keyin password<br>";
		}
		
		if (error == "") {
			request.session.userName = this.request.body.txtID;
			this.response.redirect("/home/index");
		}
		else {
		    this.response.render(this.viewPath + "login.html", 
		        {	
		        	errorMessage: error, 
		        	id: this.request.body.txtID,
		        	password: this.request.body.txtPassword,
		        	userName: request.session.userName
		        }
		    );
		}
	}

	this.logout = function () {
		delete request.session.userName;
	    response.redirect("/home/index");
	}
	
}
