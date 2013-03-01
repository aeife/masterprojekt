
/*
 * # server.js
 *
 * Serverseitige Umsetzung mittels node.js
 * Enthält Webserver mittels Express und Socket-Server mittels socket.io
 */

// Definition von Modulabhängigkeiten (siehe auch package.json)
var express = require('express')
    , routes = require('./routes')
    , login = require('./routes/login')
    , logout = require('./routes/logout')
    , register = require('./routes/register')
    , score = require('./routes/score')
    , game = require('./routes/game')
    , impressum = require('./routes/impressum')
    , http = require('http')
    , path = require('path');


// Initialisierung einer Express-Applikation
var app = express();

// Konfiguration
app.configure(function(){
    app.set('port', process.env.PORT || 3000);
    app.set('views', __dirname + '/views');
    app.set('view engine', 'jade');
    app.use(express.favicon());
    app.use(express.logger('dev'));
    app.use(express.bodyParser());
    app.use(express.methodOverride());
    app.use(express.cookieParser('your secret here'));
    app.use(express.session());
    app.use(app.router);
    app.use(express.static(path.join(__dirname, 'public')));
});

// Konfiguration für Entwicklungsbetrieb
app.configure('development', function(){
    app.use(express.errorHandler());
});


// Definition von Routen
app.get('/', routes.index);
app.get('/game', game.game);
app.get('/login', login.form);
app.post('/login', login.auth);
app.get('/logout', logout.logout);
app.get('/register', register.form);
app.post('/register', register.register);
app.get('/score', score.list);
app.get('/score/players', score.players);
app.get('/score/:id', score.details);
app.get('/impressum', impressum.impressum);

// Initialisierung des Webservers
var server = app.listen(app.get('port'), 'localhost', function(){
    console.log("Express server listening on port " + app.get('port'));
});

// Initialisierung des Socket-Servers
var io = require('socket.io').listen(server);

// Initialisierung von globalen Variablen
var players = [];
var gridSize = 50;
var spawns = [];
spawns[0] = {x: 5, y: gridSize/2, direction: "east"};
spawns[1] = {x: gridSize-5, y: gridSize/2, direction: "west"};
spawns[2] = {x: gridSize/2, y: 5, direction: "south"};
spawns[3] = {x: gridSize/2, y: gridSize-5, direction: "north"};
var colors = ['blue', 'red', 'green', 'pink'];
var places = [];
var moveInterval;
var foodInterval;


/*
 * ## io.sockets.on('connection')
 *
 * Handhabung der Socketverbindungen ab Connection-Event
 *
 * @param {object} socket Datenobjekt der Callback-Funktion zur Handhabung eingegangener Socketverbindungen
 */
io.sockets.on('connection', function(socket){

    // ID des gerade verbundenen Clients
    var clientId = socket.id;

    // Daten für neuen Client
    var spawn = {x: spawns[players.length].x, y: spawns[players.length].y, direction: spawns[players.length].direction};
    var color = colors[players.length];

    // Der 1. verbundene Client übernimmt die Rolle des Hosts.
    if (players.length === 0)
        var host = true;
    else 
        var host = false;

    players.push({clientId: clientId, spawn: spawn, host: host, color: color, username: 'Guest'});

    
    var connectionData = {clientId: clientId, players: players, spawn: spawn, gridSize: gridSize};

    // Übermittlung der eigenen Daten an den Client 
    socket.emit('successfulConnected', connectionData); 


    /*
     * ## socket.on('startGame')
     *
     * Startet das Spiel und übermittelt Startinformation an alle Spieler
     */
    socket.on("startGame", function(){
        io.sockets.emit('playerStartedGame');

        foodinterval = setInterval(function(){
            var x = Math.floor(Math.random() * (gridSize-1));
            var y = Math.floor(Math.random() * (gridSize-1));

            io.sockets.emit('newFoodCoordinates', {x: x, y: y}); 
        }, 1000);

        moveinterval = setInterval(function(){
            io.sockets.emit('movePlayers'); 
        }, 50);


    });

     /*
     * ## socket.on('getNewFoodCoordinates')
     *
     * Erzeugen und Übermitteln (an alle Spieler) neuer Futter-Koordinaten
     */
    socket.on("getNewFoodCoordinates", function(){
        var x = Math.floor(Math.random() * (gridSize-1));
        var y = Math.floor(Math.random() * (gridSize-1));

        io.sockets.emit('newFoodCoordinates', {x: x, y: y});
    });

     /*
     * ## socket.on('getMovePlayers')
     *
     * Server hat Bewegungsbefehl von Host erhalten und übermittelt dies an alle Spieler
     */
    socket.on("getMovePlayers", function(){
        io.sockets.emit('movePlayers'); 
    });

     /*
     * ## socket.on('newDirection')
     *
     * Spieler hat Richtungsänderung gesendet
     * Weiterleitung der Information an alle Clients
     *
     * @param {object} data Datenobjekt der Callback-Funktion mit Informationen zum Client und dessen Richtungsänderung
     */
    socket.on("newDirection", function(data){
        console.log("NEW DIRECTION FROM: " + socket.id);
        io.sockets.emit('playerSentNewDirection', {clientId: socket.id, direction: data.direction});
    });

    /*
     * ## socket.on('newName')
     *
     * Erst wenn ein neuer Client seinen Nutzernamen gesendet hat, werden seine Verbindungsinformationen an alle anderen Spieler gesendet.
     * 
     * @param {object} data Datenobjekt der Callback-Funktion mit Nutzername des Clients
     */
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

    /*
     * ## socket.on('dead')
     *
     * Spieler sendet seinen Tod an den Server
     *
     * @param {object} data Datenobjekt der Callback-Funktion mit allen Informationen des gestorbenen Clients
     */
    socket.on("dead", function(data){
        places.push(data.username);

        // Prüfe, ob das Spiel beendet ist
        // Beendigungsbedingung: nur noch ein lebender Spieler
        if (places.length === players.length-1){
            console.log("GAME OVER");
            
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
            if (places.length != players.length){
                places.push("Guest");
            }


            // Aufbau der Datenbankverbindung
            var db = require('./database.js');

            db.init(function(err, db) {
                if(err) throw err;

                var collection = db.collection('game');
                var newGameId = 0;

                // Finden der nächsten Spiel-ID
                // Einfügen des Endstands des aktuellen Spiels unter neuer Spiel-ID
                collection.findOne({}, {'sort': {id: -1}} , function (err, games){
                    if(err) throw err;
                    
                    if (!games){
                        gameid = 0;
                    } else {
                        gameid = games.id;
                    }
                    console.log(games);
                    for (var i = 0; i < places.length; i++){
                        collection.insert({id: gameid+1, username: places[i], place: places.length-i}, {w:1}, function(err, result) {
                            if (err) throw err;
                        });
                    }

                    // Übermittlung des Spielendes an alle Spieler
                    io.sockets.emit('gameOver', {gameId: gameid+1});

                    // Für nächstes Spiel: Platzierungen zurücksetzen und Intervalle stoppen
                    places = [];
                    clearInterval(foodinterval);
                    clearInterval(moveinterval);
                });

            });

            
        }

        console.log(places);
    });

    /*
     * ## socket.on('disconnect')
     *
     * Verbindung zu einem Spieler ist abgebrochen
     *
     * @param {object} data Datenobjekt der Callback-Funktion mit Informationen zum Client, welcher die Verbindung abgebrochen hat
     */
    socket.on("disconnect", function(data){
        // Übermittlung, dass ein Client das Spiel verlassen hat, an alle anderen Spieler
        socket.broadcast.emit('playerDisconnected', {clientId: socket.id});

        // Entfernen des Spielers aus dem allgemeinen Spielerfeld
        for (var i=0; i<players.length; i++){
            if (players[i].clientId === socket.id) {
                var client = players[i];
                break;
            }
        }

        players.splice(players.indexOf(client), 1);
    });

    

});
