var express = require('express');
var bodyParser = require('body-parser');
var db = require('./db')
var { Success, Error } = require('./response')
var app = express();
//解析json資料
app.use(bodyParser.json());

app.set('view engine', 'ejs');

app.get('/', function(req, res){
    res.render('index')
})

app.get('/success', function(req, res){
    res.end(
        JSON.stringify(new Success('success'))
    )
})

app.get('/error', function(req, res){
    res.end(
        JSON.stringify(new Error('error'))
    )
})


app.post('/add', function(req, res){
    var body = req.body
    var sql = `INSERT INTO inventory(name, phone, address, adult_mask, child_mask) VALUES(?,?,?,?,?);`
    var data = [body.name, body.phone, body.address, parseInt(body.adult_mask), parseInt(body.child_mask)]
    db.exec(sql, data, function(results, fields) {
        if(results.insertId){
            res.end(
                JSON.stringify(new Success('insert success'))
            )
        } else {
            res.end(
                JSON.stringify(new Error('insert failed'))
            )
        }
    })
})

app.listen(3000);
