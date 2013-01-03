//canvas
var canvas = $("#canvas");
var ctx = canvas[0].getContext("2d");

//vars
var gameStarted = false;

//controls
document.onkeydown = function(e) {
    switch(e.keyCode) {
        case 87:
            //w
            //player.fields.push({x: player.fields[player.fields.length-1].x, y: player.fields[player.fields.length-1].y - 1});
            //player.changeDirection("north");
            sendNewDirection("north");
            break;
        case 65:
            //a
            //player.changeDirection("west");
            sendNewDirection("west");
            break;
        case 83:
            //s
            //player.changeDirection("south");
            sendNewDirection("south");
            break;
        case 68:
            //d
            //player.changeDirection("east");
            sendNewDirection("east");
            break;
        case 71:
            //go
            if (player.host && !gameStarted)
                sendStartGame();
            //start();
            break;
    };
};

//players
var players = [];
var player;
deathNotSent = true;

//gameloop
//setInterval('player.move(player.direction)', 50);
function start(){
    console.log("START");
    console.log(player.host);
    //var moveInterval = setInterval('moveAllPlayers()', 500);
    if (player.host){
        console.log("ICH BIN HOST!");
        var foodInterval = setInterval(function(){
            socket.emit('getNewFoodCoordinates'); 
        }, 1000);
        var moveInterval = setInterval(function(){
            socket.emit('getMovePlayers');
        }, 50);
    }
}

function moveAllPlayers(){
    console.log(players.length);
    for (var i = 0; i < players.length; i++){
        players[i].move(players[i].direction);
    }
    if (player.isDead() && deathNotSent){
        sendDeath();
        deathNotSent = false;
    }
}   


//SOCKETS
if (window.io != undefined)
    var socket = io.connect('192.168.1.196');

//OUTPUT
function sendNewDirection(direction){
    socket.emit('newDirection', {direction: direction});
}

function sendStartGame(){
    socket.emit('startGame');
}

function sendNewName(){
    socket.emit('newName', {username: player.username});
}

function sendDeath(){
    console.log("SENDING OWN DEATH");
    socket.emit('dead', {username: player.username});
}


//INPUT
socket.on('successfulConnected', function(data){

    //level
    level.initializeGrid(data.gridSize);

    //player
    //player = new Player(data.spawn.x, data.spawn.y);
    //player.id = data.clientId;

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

socket.on('newPlayerConnected', function(data){

    var newPlayer = new Player(data.spawn.x, data.spawn.y, data.spawn.direction, data.color, data.username);
    newPlayer.id = data.clientId;
    players.push(newPlayer);

    console.log(players);
});

socket.on('playerSentNewDirection', function(data){
    var client = searchPlayerById(data.clientId);
    client.changeDirection(data.direction);
});

socket.on('playerStartedGame', function(){
    start();
    gameStarted = true;
});

socket.on('newFoodCoordinates', function(data){
    level.generateFood(data.x, data.y);
});

socket.on('movePlayers', function(){
    moveAllPlayers();
});

socket.on('playerDisconnected', function(data){
    var client = searchPlayerById(data.clientId);
    console.log(client);
    client.kill();
    
});

socket.on('gameOver', function(data){
    window.location = "/score/" + data.gameId;
});

//API

function searchPlayerById(id){
    var playerPos = -1;
    for (var i = 0; i < players.length; i++){
        if (players[i].id == id){
            playerPos = i;
        }
    }

    return players[playerPos];
}


function changeSpeed(speed){
    clearInterval(moveInterval);
    moveInterval = setInterval('moveAllPlayers()', speed);
}