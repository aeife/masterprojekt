
/**
 * Module dependencies.
 */

var express = require('express')
    , routes = require('./routes')
    , user = require('./routes/user')
    , login = require('./routes/login')
    , score = require('./routes/score')
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
    app.use(express.cookieParser('your secret here'));
    app.use(express.session());
    app.use(app.router);
    app.use(express.static(path.join(__dirname, 'public')));
});

app.configure('development', function(){
    app.use(express.errorHandler());
});

app.get('/', routes.index);
app.get('/users', user.list);
app.get('/login', login.form);
app.post('/login', login.auth);
app.get('/score', score.list);
app.get('/score/players', score.players);
app.get('/score/:id', score.details);

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
var places = [];


io.sockets.on('connection', function(socket){
    var clientId = socket.id;
    var spawn = {x: spawns[players.length].x, y: spawns[players.length].y, direction: spawns[players.length].direction};
    var color = colors[players.length];

    if (players.length === 0)
        var host = true;
    else 
        var host = false;

    players.push({clientId: clientId, spawn: spawn, host: host, color: color, username: 'Guest'});

    
    var connectionData = {clientId: clientId, players: players, spawn: spawn, gridSize: gridSize};

    socket.emit('successfulConnected', connectionData); 

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

    socket.on("newName", function(data){
        console.log("NEW NAME FROM: " + socket.id);

        for (var i = 0; i < players.length; i++){
            if (players[i].clientId === socket.id){
                players[i].username = data.username;
                break;
            }
        }

        var spawn = {x: spawns[players.length-1].x, y: spawns[players.length-1].y, direction: spawns[players.length-1].direction};
        var color = colors[players.length-1];

        socket.broadcast.emit('newPlayerConnected', {clientId: clientId, spawn: spawn, color: color, username: data.username});
    });

    socket.on("dead", function(data){
        places.push(data.username);

        //check if game over
        if (places.length === players.length-1){
            console.log("GAME OVER");
            //game over
            for (var i = 0; i < players.length; i++){
                var isDead = false;
                for (var j = 0; j < places.length; j++){
                    if (players[i].username === places[j]){
                        isDead = true;
                    }
                }
                if (!isDead) {
                    places.push(players[i].username);
                    break;
                }
            }

            //db
            //require database connection
            var db = require('./database.js');

            //init database
            db.init(function(err, db) {
                if(err) throw err;

                //select table of db
                var collection = db.collection('game');
                var newGameId = 0;

                collection.findOne({}, {'sort': {id: -1}} , function (err, games){
                    if(err) throw err;
                    
                    if (games){
                        console.log(games);
                        for (var i = 0; i < places.length; i++){
                            collection.insert({id: games.id+1, username: places[i], place: places.length-i}, {w:1}, function(err, result) {
                                if (err) throw err;
                            });
                        }
                    }

                });

            });

            //sendGameOver
        }

        console.log(places);
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
