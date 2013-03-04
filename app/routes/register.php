<?php
/*
 * # register.php
 *
 * Verwaltung der Registrierung
 */
    session_start();
    $error = "";

    if (isset($_POST["name"])) {
        // Prüfen der Eingaben
        $username = $_POST["name"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["passwordRepeat"];

        if ($password != $passwordRepeat){
            // Prüfe, ob eingegebene Passwörter gleich sind
            $error = "Passwörter stimmen nicht überein";
        } else if (strlen($password) < 5){
            // Prüfe, ob Passwort Mindestlänge erfüllt
            $error = "Passwort ist zu kurz (mindestens 5 Zeichen)";
        } else {
            // Prüfe, ob Nutzername bereits vorhanden

            // Einbinden der Datenbankinformationen
            include('../database.php');

            $result = mysql_query("SELECT * FROM user WHERE name = '" . $username . "'");

            $row = mysql_fetch_array($result);
            if ($row != false){
                // Nutzername schon vorhanden
                $error = "Nutzername existiert bereits";
            } else {
                // Einfügen des neuen Nutzers
                mysql_query("INSERT INTO user VALUES(NULL, '". $username . "', '". md5($password) . "')");

                header( 'Location: /' ) ;
            }
        }
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->assign('error', $error);
    $smarty->display('../views/register.tpl');
?>