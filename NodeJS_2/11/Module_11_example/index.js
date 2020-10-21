var express = require('express');
var session = require('express-session');
var bodyParser = require('body-parser');
var app = express();
//用來解析POST資料的設定
app.use(bodyParser.urlencoded({ extended: false }));

app.use(session({
    secret: 'asdoijisjdfiogjfdiogjdfoi',
    resave: true,
    saveUninitialized: true,

    cookie:{
        path: '/',
        httpOnly: true,
        secure: false,
        maxAge: 5*1000
    }
}))

app.get('/', function(req, res){
    res.setHeader('Content-Type', 'text/html; charset=utf-8')
    //req.session.views 為自己定義的值
    if (req.session.views) {
        req.session.views++
        res.write('<p>瀏覽次數: ' + req.session.views + '</p>')
        res.write('<p>Cookie ID: ' + req.session.id + '</p>')
        res.write('<p>Cookie過期時間: ' + (req.session.cookie.maxAge / 1000) + '秒</p>')
        res.end()
    } else {
        req.session.views = 1
        res.end('您是第一次訪問!')
    }
})  
app.get('/name', function(req, res){
    req.session.name = 'session中的name'
    res.setHeader('Content-Type', 'text/html; charset=utf-8')
    res.write('<p>name: ' + req.session.name + '</p>')
    res.end()
})

//使用POST提交
app.get('/login', function(req, res){
    //判斷是否已經登入
    if(req.session.user) {
        res.setHeader('Content-Type', 'text/html; charset=utf-8')
        res.write('<p>'+req.session.user.account+'你已經登入囉!</p>')
        res.write('<p>登入時間:'+req.session.user.logined_at+'</p>')
        res.end() 
    } else {
        res.redirect('/form')
    }
})
app.post('/login', function(req, res){
    res.setHeader('Content-Type', 'text/html; charset=utf-8')
    //判斷是否已經登入
    if(req.session.user) {
        res.write('<p>'+req.session.user.account+'你已經登入囉!</p>')
        res.write('<p>登入時間:'+req.session.user.logined_at+'</p>')
    } else {
        //判斷是否有傳遞值
        if(req.body.account == undefined || req.body.password == undefined) {
            res.write('<p>沒有傳遞值，無法登入哦!</p>')
        } else {
            //預設帳號密碼
            const account = 'user'
            const password = 'user'
            //處理請求
            if(req.body.account === account && req.body.password === password) {
                res.write('<p>登入成功!</p>')
                //將登入狀態寫入session
                req.session.user = {
                    'account': req.body.account,
                    'logined_at': new Date(Date.now())
                }
            } else {
                res.write('<p>登入失敗，帳號或密碼錯誤!</p>')
            }
        }
    }
    res.end() 
})


//使用GET提交
// app.get('/login', function(req, res){
//     res.setHeader('Content-Type', 'text/html; charset=utf-8')
//     //判斷是否已經登入
//     if(req.session.user) {
//         res.write('<p>'+req.session.user.account+'你已經登入囉!</p>')
//         res.write('<p>登入時間:'+req.session.user.logined_at+'</p>')
//     } else {
//         //判斷是否有傳遞值
//         if(req.query.account == undefined || req.query.password == undefined) {
//             res.write('<p>沒有傳遞值，無法登入哦!</p>')
//         } else {
//             //預設帳號密碼
//             const account = 'user'
//             const password = 'user'
//             //處理請求
//             if(req.query.account === account && req.query.password === password) {
//                 res.write('<p>登入成功!</p>')
//                 //將登入狀態寫入session
//                 req.session.user = {
//                     'account': req.query.account,
//                     'logined_at': new Date(Date.now())
//                 }
//             } else {
//                 res.write('<p>登入失敗，帳號或密碼錯誤!</p>')
//             }
//         }
//     }
//     res.end() 
// })

app.get('/form', function(req, res){
    //判斷是否已經登入
    if(req.session.user) {
        res.redirect('/login')
    } else {
        res.sendFile(__dirname+'/index.html')
    }
})

app.listen(3000);