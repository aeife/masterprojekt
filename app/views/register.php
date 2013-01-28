<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
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

                    //db
                    $dbUsername="root";
                    $database="masterprojekt";

                    mysql_connect('localhost',$dbUsername, "");
                    mysql_select_db($database);

                    $result = mysql_query("SELECT * FROM user WHERE name = '" . $username . "'");

                    $row = mysql_fetch_array($result);
                    if ($row != false){
                        // Nutzername schon vorhanden
                        $error = "Username already used";
                    } else {
                        mysql_query("INSERT INTO user VALUES(NULL, '". $username . "', '". md5($password) . "')");

                         header( 'Location: login.php' ) ;
                    }
                }
            }
        ?>
        <p><?php echo $error ?></p>
        <form action="register" method="post">
            Name: <input type="text" name="name"><br>
            Password: <input type="password" name="password"><br>
            Repeat Password: <input type="password" name="passwordRepeat">
            <input type="submit" value="Submit">
        </form>
    </body>
</html>