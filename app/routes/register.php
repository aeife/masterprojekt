<?php
    $error = "";

    if (isset($_POST["name"])) {
        $username = $_POST["name"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["passwordRepeat"];

        if ($password != $passwordRepeat){
            $error = "Passwords do not match";
        } else if (strlen($password) < 5){
            $error = "Password is too short (at least 5 chars)";
        } else {
            // Prüfe ob Nutzername bereits vorhanden

            include('../database.php');

            $result = mysql_query("SELECT * FROM user WHERE name = '" . $username . "'");

            $row = mysql_fetch_array($result);
            if ($row != false){
                // Nutzername schon vorhanden
                $error = "Username already used";
            } else {
                mysql_query("INSERT INTO user VALUES(NULL, '". $username . "', '". md5($password) . "')");

                 header( 'Location: login' ) ;
            }
        }
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->assign('error', $error);
    $smarty->display('../views/register.tpl');
?>