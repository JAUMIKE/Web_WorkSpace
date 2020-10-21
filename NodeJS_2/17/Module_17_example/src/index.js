const express = require('express');
const db = require(__dirname + '/_connect_db');
const app = express();

app.get('/products/:page?', (req, res)=>{
    const perPage = 6; // 每頁幾筆
    let page = parseInt(req.params.page) || 1; // 預設為第一頁
    const output = { perPage, page };

    const sql1 = "SELECT COUNT(1) num FROM products"; // 取得總筆數的 SQL
    const sql2 = `SELECT * FROM products LIMIT ${(page-1)*perPage}, ${perPage}`;
    db.queryAsync(sql1)
        .then(results=>{
            output.total = results[0].num; // 取得總筆數
            output.totalPages = Math.ceil(output.total/perPage); // 計算總頁數

            if(page<1 || page>output.totalPages){
                return res.redirect('/products'); // 若查看的分頁超出範圍，則重新轉向
            }
            return db.queryAsync(sql2);
        })
        .then(results=>{
            output.rows = results;
            res.json(output);
        })
        .catch(ex=>{
            console.log(ex);
        });
});

app.listen(3000, ()=>{
    console.log('server start');
});


