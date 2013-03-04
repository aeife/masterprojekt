<?php 
/*
 * # game.php
 *
 * Rendern des Templates zur Anzeige des Spiels
 */
    session_start();
    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->display('../views/game.tpl');
?>