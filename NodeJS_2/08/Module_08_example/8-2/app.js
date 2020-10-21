const express = require('express');
const multer = require('multer')
const app = express();


//自定義 storage
var myStorage = multer.diskStorage({
    destination: function (req, file, cb) {
        cb(null, "upload");    // 保存的路徑 (需先自己創建)
    },
    filename: function (req, file, cb) {
        cb(null, Date.now() + '-' + file.originalname);  // 自定義檔案名稱
    }
});

var upload = multer({
    storage: myStorage,  // 設置 storage
    fileFilter: function (req, file, cb) {  // 檔案過濾
        if (file.mimetype != 'image/gif') {
            return cb(new Error('Wrong file type'));
        }
        cb(null, true)
    }
});

app.post('/upload_file', upload.single('myfile'), function (req, res, next) {
    res.send("上傳成功");
});

app.get("/", function (req, res) {
    res.sendfile(__dirname + '/index.html', function (err) {
        if (err) res.send(404);
    });
});


app.listen(3000);