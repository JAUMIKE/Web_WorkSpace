var express = require('express');
var session = require('express-session');
var FileStore = require('session-file-store')(session);
var app = express();

app.use(session({
    secret: 'asdoijisjdfiogjfdiogjdfoi',
    //減少I/O開支
    resave: false,
    saveUninitialized: false,
    store: new FileStore({
        path: __dirname+'/sessions'
    }),
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