  <?php
/*
 * # score.php
 *
 * Rendern des Templates zur Anzeige einer Liste aller vorherigen Spiele
 */
    session_start();

    // Einbinden der Datenbankinformationen
    include('../database.php');

    // Finden aller verschiedenen Spiel-IDs
    $result = mysql_query("SELECT distinct(id) FROM game");

    // Informationen zur Übergabe ans Template in Array speichern
    $list = array();
    while ($row = mysql_fetch_assoc($result)) {
        $list[] = $row;
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->assign('list', $list);
    $smarty->display('../views/score.tpl');
?>