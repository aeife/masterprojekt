<?php
// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';


$players = [];
$gridSize = 50;
$spawns = [];
$spawns[0] = ['x' => 5, 'y' => $gridSize/2];
$spawns[1] = ['x' => $gridSize-5, 'y' => $gridSize/2];
$spawns[2] = ['x' => $gridSize/2, 'y' => 5];
$spawns[3] = ['x' => $gridSize/2, 'y' => $gridSize-5];
$colors = ['blue', 'red', 'green', 'pink'];


// when a client sends data to the server
function wsOnMessage($clientId, $message, $messageLength, $binary) {
	global $Server;
	$data = json_decode($message);

	switch($data->event_name){
		case "startGame":
			startGame();
			break;
        case "getNewFoodCoordinates":
            getNewFoodCoordinates();
            break;
        case "getMovePlayers":
            getMovePlayers();
            break;
        case "newDirection":
            newDirection($clientId, $data->content);
            break;
	}	
}

function startGame(){
	emitAll('playerStartedGame', []);
}

function getNewFoodCoordinates(){
    global $gridSize;

    $x = floor(rand(0, $gridSize-1));
    $y = floor(rand(0, $gridSize-1));
    emitAll('newFoodCoordinates', ['x' => $x, 'y' => $y]);
}

function getMovePlayers(){
    emitAll('movePlayers', []);
}

function newDirection($clientId, $data){
    emitAll('playerSentNewDirection', ['clientId' => $clientId, 'direction' => $data->direction]);
}

// when a client connects
function wsOnOpen($clientId)
{
	global $Server, $players, $gridSize, $spawns, $colors;

	$spawn = ['x' => $spawns[sizeof($players)]['x'], 'y' =>  $spawns[sizeof($players)]['y']];
    $color = $colors[sizeof($players)];

    if (sizeof($players) == 0)
        $host = true;
    else
        $host = false;

	array_push($players, ['clientId' => $clientId, 'spawn' => $spawn, 'host' => $host, 'color' => $color]);

	$connectionData = ['clientId' => $clientId, 'players' => $players, 'spawn' => $spawn];

	emit($clientId, 'successfulConnected', $connectionData);
	broadcast($clientId, 'newPlayerConnected', ['clientId' => $clientId, 'spawn' => $spawn, 'color' => $color]);


/*
   socket.on("disconnect", function(data){
        socket.broadcast.emit('playerDisconnected', {clientId: socket.id});

        for (var i=0; i<players.length; i++){
            if (players[i].idNr === socket.id) {
                var client = players[i];
                break;
            }
        }

        players.splice(players.indexOf(client), 1);
    });
*/
}

// when a client closes or lost connection
function wsOnClose($clientId, $status) {
    global $Server, $players;
    broadcast($clientId, 'playerDisconnected', ['clientId' => $clientId]);


    for ($i = 0; $i < sizeof($players); $i++){
        if ($players[$i]['clientId'] == $clientId){
            break;
        }
    }
    array_splice($players, $i, 1);
}

function emit($clientId, $event_name, $data){
	global $Server;

	$newData = ['event_name' => $event_name, 'content' => $data];
	$newData = json_encode($newData);
	$Server->wsSend($clientId, $newData);
	
}

function emitAll($event_name, $data){
    //var_dump($data);
	global $Server;

	foreach ( $Server->wsClients as $id => $client ){
		$newData = ['event_name' => $event_name, 'content' => $data];
		$newData = json_encode($newData);
		$Server->wsSend($id, $newData);
	}
}

function broadcast($clientId, $event_name, $data){
	global $Server;

	foreach ( $Server->wsClients as $id => $client ){

		if ( $id != $clientId ) {
			$newData = ['event_name' => $event_name, 'content' => $data];
			$newData = json_encode($newData);
			$Server->wsSend($id, $newData);
		}
	}
}



// start the server
$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
$Server->wsStartServer('127.0.0.1', 9300);

?>