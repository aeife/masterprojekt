<?php
    session_start();
    if (isset($_POST['name']) && isset($_POST['password'])){
     
        $name = $_POST['name'];
        $password = md5($_POST['password']);

        include('../database.php');

        $result = mysql_query("SELECT * FROM user WHERE name = '" . $name . "'");

        $row = mysql_fetch_array($result);
        
        if ($password == $row['password']){
            $_SESSION['username'] = $row['name'];

            header( 'Location: /' );
        } else {
            echo "error";
        }
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->display('../views/login.tpl');

?>