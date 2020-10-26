處裡流程:
1.引用express模組、先確認index.js --> index.ejs render是否正常
    -require express 
    -app.listen
    -app.get('/')
    -app.set('view engine','ejs')
    -render()

2.製作表單頁面，formPage.ejs、並在index.js設定路由，get('/login')、post('/')
，確認index.ejs --> formPage.ejs這段正常
    -app.get('/login',function(req,res))
    -app.post('/login',function(req,res))
    -<a href="/login"></a>

3.透過req.body.userName 確認是否收到表單資料，但需要引入body-Parser 模組並掛載中介程式
    -require ('body-parser')
    -app.use(bp.urlencoding())
    -app.use(bp.json())
    -res.send(req.body.userName)

4.確認有收到表單資料後，引入session模組，並於post路由處理的時候將表單資料記錄在session
    -require('express-session')
    -app.use(es({secret:}))
    -app.post('/login',function(req,res){req.session.userName= req.body.Name})

5.當首頁可正常顯示表單填寫的資訊，掛載中介程式讓初始訪客的userName是guest
    -app.use(function(req,res){if(!req.session.userName) req.session.userName = 'guest'})

6.利用session判斷登入是否為訪客，讓首頁的登入狀態可改變，並於路由設定登出頁面


7.製作會員登入後的會員頁並利用session判斷是否可顯示會員頁