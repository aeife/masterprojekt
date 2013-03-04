<?php
/*
 * # logout.php
 *
 * Löschen der Session und Weiterleitung zur Startseite
 */
    session_start();
    session_destroy();
    header( 'Location: /' );

?>