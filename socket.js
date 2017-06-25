var server = require('http').Server();
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('newOrder-channel');

redis.subscribe ('orderDone-channel');

redis.subscribe ('orderDelete-channel');

redis.on('message', function (channel, message) {
    var message = JSON.parse(message);
    console.log(channel + ':' + message.event);
    io.emit(channel + ':' + message.event, message.data) // channel:event
});

server.listen(3000, function () {
    console.log('Server run on port 3000');
});