const express = require('express');
const app = express();

app.get("/welcome/:name", function (req, res) {
    let name = req.params.name;
    res.end(`Welcome ${name}, have a good day.`);
});

app.get(/[a-z0-9]+@[a-z0-9]+.[a-z0-9]+/, function (req, res) {
    res.end(`your email is correct.`);
});


app.listen(4000);
