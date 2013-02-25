  <?php
    session_start();
    include('../database.php');

    $result = mysql_query("SELECT distinct(id) FROM game");

    $list = array();
    while ($row = mysql_fetch_assoc($result)) {
        $list[] = $row;
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty(); //maybe some configuration ?
    $smarty->assign('list', $list);
    $smarty->display('../views/score.tpl');
?>