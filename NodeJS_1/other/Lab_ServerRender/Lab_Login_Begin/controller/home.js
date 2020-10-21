module.exports = function (request, response, controllerName) {
    this.request  = request;
    this.response = response;
    this.viewPath = controllerName + "/";
    
	this.index = function () {
	    this.response.render(this.viewPath + "index.html", 
			{ userName: "<i>Guest</i>",
				dataList: [100, 200, 300]
			}
	    );
	}
	
	this.about = function () {
	    this.response.render(this.viewPath + "about.html", 
	        {}
	    );
	}

}
