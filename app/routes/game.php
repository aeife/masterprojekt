<?php 
    session_start();
    if (isset($_SESSION['username']))
        $username = $_SESSION['username']; 

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    if (isset($username))
        $smarty->assign('username', $username);
    $smarty->display('../views/game.tpl');
?>