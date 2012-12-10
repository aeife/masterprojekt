
/**
 * Module dependencies.
 */

var express = require('express')
    , routes = require('./routes')
    , user = require('./routes/user')
    , http = require('http')
    , path = require('path');

var app = express();

app.configure(function(){
    app.set('port', process.env.PORT || 3000);
    app.set('views', __dirname + '/views');
    app.set('view engine', 'ejs');
    app.use(express.favicon());
    app.use(express.logger('dev'));
    app.use(express.bodyParser());
    app.use(express.methodOverride());
    app.use(app.router);
    app.use(express.static(path.join(__dirname, 'public')));
});

app.configure('development', function(){
    app.use(express.errorHandler());
});

app.get('/', routes.index);
app.get('/users', user.list);

var server = app.listen(app.get('port'), '192.168.1.196', function(){
    console.log("Express server listening on port " + app.get('port'));
});

var io = require('socket.io').listen(server);
var players = [];
var gridSize = 20;
var spawns = [];
spawns[0] = {x: 5, y: gridSize/2, direction: "east"};
spawns[1] = {x: gridSize-5, y: gridSize/2, direction: "west"};
spawns[2] = {x: gridSize/2, y: 5, direction: "south"};
spawns[3] = {x: gridSize/2, y: gridSize-5, direction: "north"};
var colors = ['blue', 'red', 'green', 'pink'];


io.sockets.on('connection', function(socket){
    var clientId = socket.id;
    var spawn = {x: spawns[players.length].x, y: spawns[players.length].y, direction: spawns[players.length].direction};
    var color = colors[players.length];

    if (players.length === 0)
        var host = true;
    else 
        var host = false;

    players.push({clientId: clientId, spawn: spawn, host: host, color: color});

    
    var connectionData = {clientId: clientId, players: players, spawn: spawn, gridSize: gridSize};

    socket.emit('successfulConnected', connectionData);
    socket.broadcast.emit('newPlayerConnected', {clientId: clientId, spawn: spawn, color: color});

    

    socket.on("startGame", function(){
        io.sockets.emit('playerStartedGame');
/*
        setInterval(function(){
            var x = Math.floor(Math.random() * (gridSize-1));
            var y = Math.floor(Math.random() * (gridSize-1));

            io.sockets.emit('newFoodCoordinates', {x: x, y: y}); 
        }, 1000);

        setInterval(function(){
            io.sockets.emit('movePlayers'); 
        }, 50);

*/
    });

    socket.on("getNewFoodCoordinates", function(){
        var x = Math.floor(Math.random() * (gridSize-1));
        var y = Math.floor(Math.random() * (gridSize-1));

        io.sockets.emit('newFoodCoordinates', {x: x, y: y});
    });

    socket.on("getMovePlayers", function(){
        io.sockets.emit('movePlayers'); 
    });

    socket.on("newDirection", function(data){
        console.log("NEW DIRECTION FROM: " + socket.id);
        io.sockets.emit('playerSentNewDirection', {clientId: socket.id, direction: data.direction});
    });

    socket.on("disconnect", function(data){
        socket.broadcast.emit('playerDisconnected', {clientId: socket.id});

        for (var i=0; i<players.length; i++){
            if (players[i].clientId === socket.id) {
                var client = players[i];
                break;
            }
        }

        players.splice(players.indexOf(client), 1);
    });

    

});
