  <?php
    include('../smarty/Smarty.class.php');
    $smarty = new Smarty;

    $username="root";
    $database="masterprojekt";

    mysql_connect('localhost',$username, "");
    mysql_select_db($database);

    $result = mysql_query("SELECT distinct(id) FROM game");

    $list = array();
    while ($row = mysql_fetch_assoc($result)) {
        $list[] = $row;
    }

    $smarty = new Smarty(); //maybe some configuration ?
    $smarty->assign('list', $list);
    $smarty->display('../views/score.tpl');
?>