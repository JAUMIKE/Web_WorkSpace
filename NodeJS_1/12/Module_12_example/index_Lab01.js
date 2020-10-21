var express = require('express');
var app = express();
 
//setting middleware
// app.use(express.static(__dirname + '/image')); 
app.set('view engine', 'ejs');  
app.get('/', function(req, res){
  res.render('default',{
  	title: 'EJS 樣板測試'
  });
});
var server = app.listen(5000, function () {
    console.log('Node server is running..');
});
