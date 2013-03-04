<?php
/*
 * # impressum.php
 *
 * Rendern des Templates zur Anzeige des Impressums
 */
    session_start();
    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->display('../views/impressum.tpl');
?>