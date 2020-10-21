module.exports = function (request, response, controllerName) {
    this.request  = request;
    this.response = response;
    this.viewPath = controllerName + "/";
    
	this.index = function () {
	    this.response.render(this.viewPath + "index.html", 
	        { userName: request.session.userName }
	    );
	}
	
	this.member = function () {
		if (!request.session.userName) {
			response.redirect("/member/login");
			return;
		}
	    this.response.render(this.viewPath + "member.html", 
	        { userName: request.session.userName }
	    );
	}

}
