<?php
    session_start();
    include('../database.php');

    $result = mysql_query("SELECT username FROM game WHERE id=" . $_GET['id'] . " ORDER BY place");

    $list = array();
    while ($row = mysql_fetch_assoc($result)) {
        $list[] = $row;
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->assign('list', $list);
    $smarty->display('../views/scoreDetails.tpl');
?>