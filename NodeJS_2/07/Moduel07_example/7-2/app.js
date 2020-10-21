const bodyParser = require('body-parser'); const express = require('express');
const app = express(); var jsonParser = bodyParser.json() // 解析 JSON 資料
var urlencodedParser = bodyParser.urlencoded() //解析 Form Data 

app.post('/json', jsonParser, function (req, res) {
    console.log(req.body); // 可以從 req.body 中抓取解析的資料
    res.send('Form Data = ' + req.body)
})

app.post('/form', urlencodedParser, function (req, res) {
    console.log(req.body);
    res.send('JSON Data = ' + req.body)
})

app.get('/test', function (req, res) {
    res.send(' query string = ' + req.query.name);
});


app.listen(3000);
