<?php
/*
 * # server.php
 *
 * Serverseitige Umsetzung mittels PHP
 * Enthält nur SocketServer
 * Aufruf mittels: php.exe server.php
 */

// Timeout des Servers verhindern
set_time_limit(0);

// Einfügen von Socket-Klasse für Socketfunktionalitäten in PHP
require 'class.PHPWebSocket.php';


// Initialisierung von globalen Variablen
$players = [];
$gridSize = 50;
$spawns = [];
$spawns[0] = ['x' => 5, 'y' => $gridSize/2, 'direction' => "east"];
$spawns[1] = ['x' => $gridSize-5, 'y' => $gridSize/2, 'direction' => "west"];
$spawns[2] = ['x' => $gridSize/2, 'y' => 5, 'direction' => "south"];
$spawns[3] = ['x' => $gridSize/2, 'y' => $gridSize-5, 'direction' => "north"];
$colors = ['blue', 'red', 'green', 'pink'];
$places = [];


/*
 * ## wsOnMessage
 *
 * Handhabung der Socketverbindungen ab Connection-Event
 * 
 * Je nach übermittelter Nachricht wird die Funktionalität weiterdelegiert.
 *
 * @param {int} clientId ID des Clients
 * @param {string} message Übermittelte Nachricht
 * @param {int} messageLength Länge der Nachricht
 * @param {binary} binary Nachricht in Binärformat
 */
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

/*
 * ## startGame
 *
 * Startet das Spiel und übermittelt Startinformation an alle Spieler
 * 
 */
function startGame(){
	emitAll('playerStartedGame', []);
}

/*
 * ## getNewFoodCoordinates
 *
 * Erzeugen und Übermitteln (an alle Spieler) neuer Futter-Koordinaten
 * 
 */
function getNewFoodCoordinates(){
    global $gridSize;

    $x = floor(rand(0, $gridSize-1));
    $y = floor(rand(0, $gridSize-1));
    emitAll('newFoodCoordinates', ['x' => $x, 'y' => $y]);
}

 /*
 * ## getMovePlayers
 *
 * Server hat Bewegungsbefehl von Host erhalten und übermittelt dies an alle Spieler
 */
function getMovePlayers(){
    emitAll('movePlayers', []);
}

 /*
 * ## newDirection
 *
 * Spieler hat Richtungsänderung gesendet
 * Weiterleitung der Information an alle Clients
 *
 * @param {int} clientId ID des betroffenen Clients
 * @param {object} data Datenobjekt mit Informationen zum Client und dessen Richtungsänderung
 */
function newDirection($clientId, $data){
    emitAll('playerSentNewDirection', ['clientId' => $clientId, 'direction' => $data->direction]);
}

/*
 * ## newName
 *
 * Erst wenn ein neuer Client seinen Nutzernamen gesendet hat, werden seine Verbindungsinformationen an alle anderen Spieler gesendet.
 * 
 * @param {int} clientId ID des betroffenen Clients
 * @param {object} data Datenobjekt mit Nutzername des Clients
 */
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

/*
 * ## dead
 *
 * Spieler sendet seinen Tod an den Server
 *
 * @param {object} data Datenobjekt mit allen Informationen des gestorbenen Clients
 */
function dead($data){
    global $places, $players;

    array_push($places, $data->username);

    // Prüfe, ob das Spiel beendet ist
    // Beendigungsbedingung: nur noch ein lebender Spieler
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

        // Aufbau der Datenbankverbindung
        $username="root";
        $database="masterprojekt";

        mysql_connect('localhost',$username, "");
        mysql_select_db($database);

        // Finden der nächsten Spiel-ID
        // Einfügen des Endstands des aktuellen Spiels unter neuer Spiel-ID
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

        // Übermittlung des Spielendes an alle Spieler
        emitAll('gameOver', ['gameId' => $row[0]+1]);

        // @TODO Übermittlung hinzufügen

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
	
}

/*
 * ## wsOnClose
 *
 * Verbindung zu einem Spieler ist abgebrochen
 *
 * @param {int} clientId ID des betroffenen Clients
 * @param {object} status Close-Status des Clients
 */
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


/*
 * ## emit
 *
 * Senden einer Nachricht an einen bestimmten Client
 *
 * @param {int} clientId ID des Clients, an welchen die Nachricht übermittelt werden soll
 * @param {string} event_name Name des Events
 * @param {object} data Datenobjekt mit zu übermittelten Informationen
 */
function emit($clientId, $event_name, $data){
	global $Server;

	$newData = ['event_name' => $event_name, 'content' => $data];
	$newData = json_encode($newData);
	$Server->wsSend($clientId, $newData);
	
}

/*
 * ## emitAll
 *
 * Senden einer Nachricht an alle Clients
 *
 * @param {string} event_name Name des Events
 * @param {object} data Datenobjekt mit zu übermittelten Informationen
 */
function emitAll($event_name, $data){
    //var_dump($data);
	global $Server;

	foreach ( $Server->wsClients as $id => $client ){
		$newData = ['event_name' => $event_name, 'content' => $data];
		$newData = json_encode($newData);
		$Server->wsSend($id, $newData);
	}
}

/*
 * ## broadcast
 *
 * Senden einer Nachricht an alle anderen Clients, außer des eigenen
 *
 * @param {int} clientId ID des Clients, an welchen die Nachricht nicht übermittelt werden soll
 * @param {string} event_name Name des Events
 * @param {object} data Datenobjekt mit zu übermittelten Informationen
 */
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



// Starten des Socket-Servers
$Server = new PHPWebSocket();

// Socketevents mit Funktionen verbinden
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');

$Server->wsStartServer('127.0.0.1', 9300);

?>