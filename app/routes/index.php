<?php
/*
 * # index.php
 *
 * Rendern des Templates zur Anzeige der Startseite
 */
    session_start();
    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->display('../views/index.tpl');
?>