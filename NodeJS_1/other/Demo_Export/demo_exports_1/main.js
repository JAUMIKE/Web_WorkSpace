// http://myLab/home/index
// http://myLab/home/about
var controllerName = "home";
var actionName = "index";
var todoName = "about";
//引用物件，並執行一次涵式(new的時候)
var module = require("./" + controllerName + ".js");
var obj = new module();
obj[todoName]();
obj[actionName]();
// obj["about"]();
// obj.index();
// obj.about();



