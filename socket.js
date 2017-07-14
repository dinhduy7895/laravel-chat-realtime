var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();

server.listen(6969);

io.on('connection', function (socket) {
    console.log("client connected");
    redis.subscribe('test-channel');
    redis.on('message', function (channel, data) {
    data = JSON.parse(data);
        console.log("mew message add in queue "+ data.message + " channel" + socket.id);
    socket.emit('sendMessage', data);
    });
    
});

