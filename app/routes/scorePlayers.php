<?php
/*
 * # scorePlayers.php
 *
 * Rendern des Templates zur Anzeige des Spieler-Highscores
 */
    session_start();

    // Einbinden der Datenbankinformationen
    include('../database.php');

    // Finden aller verschiedenen Nutzer
    $result = mysql_query("SELECT distinct(username) FROM game ORDER BY username");
    $users = [];

    // Informationen zur späteren Übergabe ans Template in assoziatives Array speichern
    while ($row = mysql_fetch_array($result)){
        if ($row[0] != "Guest")
            array_push($users, ["username" => $row[0], "score" => 0]);
    }

     // Sortierung aller Einträge nach Nutzernamen, Gäste ausgeschlossen
    $result = mysql_query("SELECT * FROM game WHERE username != 'Guest' ORDER BY username ");

    // Informationen über Platzierung der einzelnen Spieler zur Berechnung des Scores
    $score = [];
    while ($row = mysql_fetch_array($result)){
        array_push($score, ["username" => $row['username'], "place" => $row['place']]);
    }

    $j = 0;
    for ($i = 0; $i < sizeof($users); $i++){
        while ($j < sizeof($score) && $users[$i]["username"] == $score[$j]["username"] ){
            switch ($score[$j]["place"]){
                case 1:
                    $users[$i]["score"] += 50;
                    break;
                case 2:
                    $users[$i]["score"] += 25;
                    break;
                case 3:
                    $users[$i]["score"] += 10;
                    break;
                case 4:
                    $users[$i]["score"] += 5;
                    break;
            }
            $j++;
        }
    }
    
    usort($users, function($a, $b) {
        return $b['score'] - $a['score'];
    });

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->assign('list', $users);
    $smarty->display('../views/scorePlayers.tpl');

?> 