<?php
/*
 * # login.php
 *
 * Verwaltung des Logins und Rendern des Templates für den Loginbereich
 */
    session_start();

    // Authorisierung eines Loginversuchs
    if (isset($_POST['name']) && isset($_POST['password'])){

        $name = $_POST['name'];
        // Verschlüsselung des Passworts mittels MD5
        $password = md5($_POST['password']);

        // Einbinden der Datenbankinformationen
        include('../database.php');

        // Suchen eines Nutzers mit den Logininformationen
        $result = mysql_query("SELECT * FROM user WHERE name = '" . $name . "'");

        $row = mysql_fetch_array($result);
        
        // Weiterleitung zur Startseite und bei gefundenen Nutzer Eintragung des Nutzernamens in die Session
        if ($password == $row['password']){
            $_SESSION['username'] = $row['name'];

            header( 'Location: /' );
        } else {
            header( 'Location: /' );
        }
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->display('../views/login.tpl');

?>