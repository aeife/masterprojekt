<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <?php
        $username="root";
        $database="masterprojekt";

        mysql_connect('localhost',$username, "");
        mysql_select_db($database);

        $result = mysql_query("SELECT username FROM game WHERE id=" . $_GET['id'] . " ORDER BY place");
        ?>


        <ol>
            <?php
                while ($row = mysql_fetch_array($result)){
                    echo "<li>" . $row[0] . "</li>";
                }
            ?>
        </ol>
    </body>
</html>