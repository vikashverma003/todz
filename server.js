var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');
app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "X-Requested-With");
  next();
});
server.listen(8891);
io.on('connection', function (socket) {
  //console.log('socket',socket)
  console.log("new client connected");
  let project_id = socket.handshake.query.project_id;
  let todz_id = socket.handshake.query.todz_id;
  var redisClient = redis.createClient();
  //redisClient.subscribe('message');
 // redisClient.subscribe('Project.*.*');
  redisClient.psubscribe('Project.'+project_id+'.'+todz_id, function(err, count) {
  });
  redisClient.on('pmessage', function(subscribed, channel, message) {
    console.log(channel);
    message = JSON.parse(message);
console.log(message);
    io.emit(channel , message);
});


  socket.on('disconnect', function() {
    redisClient.quit();
  });

});
