<?php
    session_start();
    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->display('../views/index.tpl');
?>