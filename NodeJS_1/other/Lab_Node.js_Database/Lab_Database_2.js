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

console.log("Connected.");

// 3.1

connection.end();
