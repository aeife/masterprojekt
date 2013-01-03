<?php
// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';


$players = [];
$gridSize = 50;
$spawns = [];
$spawns[0] = ['x' => 5, 'y' => $gridSize/2, 'direction' => "east"];
$spawns[1] = ['x' => $gridSize-5, 'y' => $gridSize/2, 'direction' => "west"];
$spawns[2] = ['x' => $gridSize/2, 'y' => 5, 'direction' => "south"];
$spawns[3] = ['x' => $gridSize/2, 'y' => $gridSize-5, 'direction' => "north"];
$colors = ['blue', 'red', 'green', 'pink'];
$places = [];


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
        case "newName":
            newName($clientId, $data->content);
            break;
        case "dead":
            dead($data->content);
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

function newName($clientId, $data){
    global $spawns, $colors, $players;
    for ($i = 0; $i < sizeof($players); $i++) {
        if ($players[$i]['clientId'] == $clientId) {
            $players[$i]['username'] = $data->username;
        }
    }

    $spawn = ['x' => $spawns[sizeof($players)-1]['x'], 'y' =>  $spawns[sizeof($players)-1]['y'], 'direction' => $spawns[sizeof($players)-1]['direction']];
    $color = $colors[sizeof($players)-1];

    broadcast($clientId, 'newPlayerConnected', ['clientId' => $clientId, 'spawn' => $spawn, 'color' => $color, 'username' => $data->username]);
}

function dead($data){
    global $places, $players;

    array_push($places, $data->username);

    //check if game over
    if (sizeof($places) == sizeof($players)-1){
        echo "GAME OVER";

        for ($i = 0; $i < sizeof($players); $i++){
            echo $players[$i]['username'];
            echo $places[0];
            if (!in_array($players[$i]['username'], $places)){
                array_push($places, $players[$i]['username']);
            }
        }
        if (sizeof($places) != sizeof($players)){
            array_push($places, "Guest");
        }

        //db entry
        //db
        $username="root";
        $database="masterprojekt";

        mysql_connect('localhost',$username, "");
        mysql_select_db($database);

        $result = mysql_query("SELECT max(id) FROM game");

        $row = mysql_fetch_array($result);

        if ($row[0]){
            echo "bin drin";
            for ($i = 0; $i < sizeof($places); $i++){
                echo $i;
                $query = "INSERT INTO game VALUES(NULL, '". ($row[0]+1) . "', '". $places[$i] . "', '". (sizeof($places)-$i) . "')";
                mysql_query($query);
            }
        }

        // send game over

    }
}

// when a client connects
function wsOnOpen($clientId)
{
	global $Server, $players, $gridSize, $spawns, $colors;

	$spawn = ['x' => $spawns[sizeof($players)]['x'], 'y' =>  $spawns[sizeof($players)]['y'], 'direction' => $spawns[sizeof($players)]['direction']];
    $color = $colors[sizeof($players)];

    if (sizeof($players) == 0)
        $host = true;
    else
        $host = false;

	array_push($players, ['clientId' => $clientId, 'spawn' => $spawn, 'host' => $host, 'color' => $color, 'username' => 'Guest']);

	$connectionData = ['clientId' => $clientId, 'players' => $players, 'spawn' => $spawn, 'gridSize' => $gridSize];

	emit($clientId, 'successfulConnected', $connectionData);
	


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