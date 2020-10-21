const querystring = require('querystring');

var str = 'name=Shan&age=18';
var obj = querystring.parse(str);
console.log(obj);

obj.name = "珊";
obj.age = 20;

var newstr = querystring.stringify(obj);
console.log(newstr);


str = 'name=珊&age=18';
console.log("原始字串  =  " + str);
var enc_str = querystring.escape(str);
console.log("編碼後的字串  =  " + enc_str);
var dec_str = querystring.unescape(enc_str);
console.log("解碼後的字串  =  " + dec_str);