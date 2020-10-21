const express = require('express');
const app = express();
const bodyParser = require('body-parser');
var urlencodedParser = bodyParser.urlencoded() //解析 Form Data 


app.get("/", function (req, res) {
    res.sendfile(__dirname + '/index.html', function (err) {
        if (err) res.send(404);
    });
});

app.get('/getdata', function (req, res) {
    console.log(req.query);
    res.send('收到的資料 = ' + JSON.stringify(req.query))
})

app.post('/postdata', urlencodedParser, function (req, res) {
    console.log(req.body);
    res.send('收到的資料 = ' + JSON.stringify(req.body))
})


app.listen(3000);