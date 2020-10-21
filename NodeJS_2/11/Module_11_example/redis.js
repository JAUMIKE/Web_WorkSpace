var express = require('express');
var session = require('express-session');
var redis = require('redis');
var RedisStore = require('connect-redis')(session);

// 建立cli
var rClient = redis.createClient(6379, '127.0.0.1');

var app = express();

app.use(session({
    secret: 'asdoijisjdfiogjfdiogjdfoi',
    //減少I/O開支
    resave: false,
    saveUninitialized: false,
    store: new RedisStore({client: rClient}),
    cookie:{
        path: '/',
        httpOnly: true,
        secure: false,
        maxAge: 60*1000
    }
}));

app.get('/', function(req, res){
    res.setHeader('Content-Type', 'text/html; charset=utf-8')
    //req.session.views 為自己定義的值
    if (req.session.views) {
        req.session.views++
        res.write('<p>瀏覽次數: ' + req.session.views + '</p>')
        res.end()
    } else {
        req.session.views = 1
        res.end('您是第一次訪問!')
    }
})  

app.listen(3000);
