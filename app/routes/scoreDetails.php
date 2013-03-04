<?php
/*
 * # scoreDetails.php
 *
 * Rendern des Templates zur Anzeige des Ergebnisses eines Spiels
 */
    session_start();

    // Einbinden der Datenbankinformationen
    include('../database.php');

    // Finden aller am Spiel teilgenommenen Spieler, sortiert nach ihrer Platzierung
    $result = mysql_query("SELECT username FROM game WHERE id=" . $_GET['id'] . " ORDER BY place");

    // Informationen zur Übergabe ans Template in Array speichern
    $list = array();
    while ($row = mysql_fetch_assoc($result)) {
        $list[] = $row;
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->assign('list', $list);
    $smarty->display('../views/scoreDetails.tpl');
?>