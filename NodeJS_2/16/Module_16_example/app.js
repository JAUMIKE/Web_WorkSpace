var express = require('express');
var bodyParser = require('body-parser');
//引入index路由
var index = require('./router/index')
var session = require('express-session');
var app = express();
//session設定
app.use(session({
    secret: 'iamagooddeveloperofjavascript,iwoilllearnaboutallofthisapplication',
    resave: false,
    saveUninitialized: false,

    cookie:{
        path: '/',
        httpOnly: true,
        secure: false,
        maxAge: 10 * 60*1000
    }
}))

//解析json資料
app.use(bodyParser.json());

app.use(function(req, res, next){
    res.locals.session = req.session;
    next();
});
app.set('view engine', 'ejs');

//註冊index路由
app.use('/', index)

app.listen(3000);
