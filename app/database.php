<?php
    /*
     * # database.php
     *
     * Verbindung zu MySQL inklusive aller notwendigen Verbindungsdaten
     */
    $dbUsername="root";
    $database="masterprojekt";

    mysql_connect('localhost',$dbUsername, "");
    mysql_select_db($database);
?>