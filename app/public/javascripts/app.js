/*
 * # app.js
 *
 * Clientseitige Spielelogik
 * Gemeinsame Verwendung durch Node.js und PHP
 */


// Initialisierung des Canvas-Elements
var canvas = $("#canvas");
var ctx = canvas[0].getContext("2d");

// Initialisierung von globalen Variablen
var gameStarted = false;
var players = [];
var player;
deathNotSent = true;

// Konfiguration der Steuerung
document.onkeydown = function(e) {
    switch(e.keyCode) {
        case 87:
            // entspricht Taste W
            sendNewDirection("north");
            break;
        case 65:
            // entspricht Taste A
            sendNewDirection("west");
            break;
        case 83:
            // entspricht Taste S
            sendNewDirection("south");
            break;
        case 68:
            // entspricht Taste D
            sendNewDirection("east");
            break;
        case 71:
            // entspricht Taste G
            // Start des Spiels, nur als Host möglich
            if (player.host && !gameStarted)
                sendStartGame();
            break;
    };
};



/*
 * ## start
 *
 * Starten des Spiels
 * Enthält nur für den Host Funktionalität zum Grundbetrieb des Spiels
 */
function start(){
    console.log("START");
    console.log(player.host);
}

/*
 * ## moveAllPlayers
 *
 * Bewegen aller Spieler im Spielerfeld
 */
function moveAllPlayers(){
    console.log(players.length);
    for (var i = 0; i < players.length; i++){
        players[i].move(players[i].direction);
    }
    // Falls eigener Spieler während der Bewegung stirbt und der Tod noch nicht gesendet wurde, sende seinen Tod
    if (player.isDead() && deathNotSent){
        sendDeath();
        deathNotSent = false;
    }
}   


// Nur in der Node.js-Variante steht das io-Objekt zur Verfügung
// Die PHP-Variante definiert die socket-Variable in einer externen Datei
if (window.io != undefined)
    var socket = io.connect('192.168.1.196');

/*
 * ## Output
 */

/*
 * ### sendNewDirection
 *
 * Sende eigene neue Richtung nach Richtungsänderung
 *
 * @param {string} direction Neue Richtung
 */
function sendNewDirection(direction){
    socket.emit('newDirection', {direction: direction});
}

/*
 * ### sendStartGame
 *
 * Übermittlung des Spielstarts
 */
function sendStartGame(){
    socket.emit('startGame');
}

/*
 * ### sendNewName
 *
 * Übermittlung des eigenen Nutzernamens
 */
function sendNewName(){
    socket.emit('newName', {username: player.username});
}

/*
 * ### sendDeath
 *
 * Übermittlung des eigenen Todes
 */
function sendDeath(){
    console.log("SENDING OWN DEATH");
    socket.emit('dead', {username: player.username});
}


/*
 * ## Input
 */

 /*
 * ### socket.on('successfulConnected')
 *
 * Wenn Server erfolgreiche Verbindung bestätigt
 *
 * @param {object} data Datenobjekt mit Spielinformationen
 */
socket.on('successfulConnected', function(data){

    level.initializeGrid(data.gridSize);

    // Lege für alle bisherigen Spieler ein Spielerobjekt an
    for (var i = 0; i < data.players.length; i++){
        var newPlayer = new Player (data.players[i].spawn.x, data.players[i].spawn.y, data.players[i].spawn.direction, data.players[i].color, data.players[i].username);
        newPlayer.id = data.players[i].clientId;
        newPlayer.host = data.players[i].host;
        players.push(newPlayer);
    }
    player = players[players.length-1];

    if (!(typeof username === 'undefined')){
        player.username = username;
    }

    sendNewName();

    console.log(players);
});

 /*
 * ### socket.on('newPlayerConnected')
 *
 * Neuer Spieler ist hinzugekommen
 *
 * @param {object} data Datenobjekt mit Informationen zum neuen Spieler
 */
socket.on('newPlayerConnected', function(data){

    // Anlegen eines neuen Spielerobjekts für den neu hinzugekommenen Spieler
    var newPlayer = new Player(data.spawn.x, data.spawn.y, data.spawn.direction, data.color, data.username);
    newPlayer.id = data.clientId;
    players.push(newPlayer);

    console.log(players);
});

 /*
 * ### socket.on('playerSentNewDirection')
 *
 * Richtungsänderung eines Spielers (einschließlich des eigenen Spielers)
 *
 * @param {object} data Datenobjekt mit Informationen zum betreffenden Spieler
 */
socket.on('playerSentNewDirection', function(data){
    var client = searchPlayerById(data.clientId);
    client.changeDirection(data.direction);
});

 /*
 * ### socket.on('playerStartedGame')
 *
 * Host hat das Spiel gestartet
 */
socket.on('playerStartedGame', function(){
    start();
    gameStarted = true;
});

 /*
 * ### socket.on('newFoodCoordinates')
 *
 * Neues Essens-Koordinaten wurden generiert, erzeuge an diesen Koordinaten Essen
 *
 * @param {object} data Datenobjekt mit Koordinaten des Essens
 */
socket.on('newFoodCoordinates', function(data){
    level.generateFood(data.x, data.y);
});

 /*
 * ### socket.on('movePlayers')
 *
 * Anordnung des Servers die Bewegungen für alle Spieler durchzuführen
 */
socket.on('movePlayers', function(){
    moveAllPlayers();
});

 /*
 * ### socket.on('playerDisconnected')
 *
 * Spieler hat die Verbindung geschlossen
 *
 * @param {object} data Datenobjekt mit Informationen zum Spieler, welcher die Verbindung abgebrochen hat
 */
socket.on('playerDisconnected', function(data){
    var client = searchPlayerById(data.clientId);
    console.log(client);
    client.kill();
    
});

 /*
 * ### socket.on('gameOver')
 *
 * Spiel ist zu Ende
 * Weiterleitung zur Ergebnisübersicht
 *
 * @param {object} data Datenobjekt mit ID des Spiels für entsprechende Route
 */
socket.on('gameOver', function(data){
    window.location = "/score/" + data.gameId;
});



 /*
 * ## Hilfsfunktionen
 */

/*
 * ### searchPlayerById
 *
 * Suche eines bestimmten Spielers im Spielerfeld anhand seiner ID
 *
 * @param {int} id ID des gesuchten Spielers
 */
function searchPlayerById(id){
    var playerPos = -1;
    for (var i = 0; i < players.length; i++){
        if (players[i].id == id){
            playerPos = i;
        }
    }

    return players[playerPos];
}