var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : '127.0.0.1',
  user     : 'root',
  password : '',
  database : 'gcm'
});

connection.connect(function(err) {
	// if (err) throw err;
	if (err) {
		console.log(JSON.stringify(err));
		process.exit();
	}
});


connection.query("insert into user (id, address) values (?, ?)", 
		['10001', '台北市大安區復興南路一段390號2樓']);
connection.query("insert into user (id, address) values (?, ?)", 
		['10002', '台中市公益路二段51號20樓']);
connection.query("insert into user (id, address) values (?, ?)", 
		['10003', '台北市大安區復興南路一段391號2樓']);
connection.query("insert into user (id, address) values (?, ?)", 
		['10004', '台中市公益路二段52號20樓']);


connection.end();


