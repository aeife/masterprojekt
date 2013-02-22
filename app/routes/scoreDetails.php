<?php
    include('../smarty/Smarty.class.php');
    $smarty = new Smarty;

    $username="root";
    $database="masterprojekt";

    mysql_connect('localhost',$username, "");
    mysql_select_db($database);

    $result = mysql_query("SELECT username FROM game WHERE id=" . $_GET['id'] . " ORDER BY place");

    $list = array();
    while ($row = mysql_fetch_assoc($result)) {
        $list[] = $row;
    }

    $smarty = new Smarty(); //maybe some configuration ?
    $smarty->assign('list', $list);
    $smarty->display('../views/scoreDetails.tpl');
?>