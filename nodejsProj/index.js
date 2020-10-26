var express= require("express");
var app = express();

//掛載body-parser中介程式
var bp = require("body-parser");
app.use(bp.urlencoded());
app.use(bp.json());
//掛載Sesseion
var exSession = require("express-session");
app.use(exSession({
    secret:"Pa55W@rd"
}))
//當瀏覽者第一次到訪時設定session為Guest
app.use(function (req,res,next) { 
    if(!req.session.userName){
        req.session.userName = "Guest"
    }
    next();
 })

//設定ejs template engine
app.set('view engine','ejs');
app.listen(3000,function(){
    console.log("Server is running")
})

//================設定 router================

//首頁
app.get('/',function(req,res){
    res.render('index',{userName:req.session.userName});
})
//登入頁路由
app.get('/login',function(req,res){
    res.render('formPage',{});
})
// 設定表單收到post過來的資料，並記住userName、password訊息
app.post('/login',function (req,res) { 
    // res.send("formData: "+ req.body.userName);
    req.session.userName = req.body.userName;
    req.session.passWord = req.body.passWord;
    res.redirect('/')
 })
// 設定點擊logout時的動作，清除session、重新導回首頁
 app.get('/logout',function (req,res) {
    delete req.session.userName;
    res.redirect('/') 
 })

 app.get('/member',function (req,res){
     if(req.session.userName == "Guest"){
         res.redirect('/login')
     }
     else{
        res.render('memberPage',{userName:req.session.userName,
                                 passWord:req.session.passWord}); 
     }
      
 })