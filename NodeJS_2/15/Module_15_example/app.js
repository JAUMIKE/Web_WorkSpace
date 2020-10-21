var express = require('express');
var bodyParser = require('body-parser');
//引入index路由
var index = require('./router/index')
var app = express();

//解析json資料
app.use(bodyParser.json());
app.set('view engine', 'ejs');

//註冊index路由
app.use('/', index)
app.listen(3000);