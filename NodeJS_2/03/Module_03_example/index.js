var http = require('http');

//create a server object:
http.createServer(function (req, res) {
  if (req.url == '/user1') {
    res.write('Hello User1 !!');
  } else if (req.url == '/user2') {
    res.write('Hello User2 !!');
  } else {
    res.write('Hello World!');
  }

  //write a response to the client
  res.end(); //end the response
}).listen(3000); //the server object listens on port 3000