var mysql = require('mysql');
var connection = mysql.createConnection({
	host : '127.0.0.1',
	user : 'root',
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

var roadName = '復興南路一段';
connection.query('select * from user where address like ?', 
		'%' + roadName + '%',
		function(err, rows) {
			if (err)
				throw err;

			console.log('Data received from Db:\n');
			for (var i = 0; i < rows.length; i++) {
				console.log(rows[i].address);
			};
			
			console.log(rows);
		});

connection.end();

