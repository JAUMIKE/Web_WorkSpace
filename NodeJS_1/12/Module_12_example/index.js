var express = require('express');
var app = express();
 
//setting middleware
app.use(express.static(__dirname + '/image')); 

app.set('view engine', 'ejs');  
app.get('/', function(req, res){
   //使用default樣板，並可以帶入參數給樣板利用
  res.render('default',{
  	headTitle: '實作EJS',
  	title: 'EJS 樣板測試',
  	bodyItems: ['我是一', '我是二', '我是三', '我是四','我是五'],
  	footNote: '© 2020 Copyright:MDBootstrap.com'
  });
});

var server = app.listen(5000, function () {
    console.log('Node server is running..');
});
