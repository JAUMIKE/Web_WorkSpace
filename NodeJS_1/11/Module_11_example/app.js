var express = require('express');
var app = express();
//setting middleware
app.use(express.static(__dirname));
app.use(express.static('image'));
app.use(express.static('css'))
app.use(express.static('js'))
var server = app.listen(5000, function () {
console.log('Node server is running..');
});
