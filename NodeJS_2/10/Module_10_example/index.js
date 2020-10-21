const express = require('express');
const app = express();
const myRoute = require('./myRoute');

app.use(function (req, res, next) {
    console.log('Time: ' + Date());
    next();
});

app.use('/apple', function (req, res, next) {
    console.log("有人在用 apple 的模組");
    next();
});

app.use('/apple', myRoute);

app.listen(8888)
