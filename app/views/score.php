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

        $result = mysql_query("SELECT distinct(id) FROM game");

        ?>
        <a href = 'scoreplayers.php'>Player Score</a>
        <ul>
            <?php
                while ($row = mysql_fetch_array($result)){
                    echo "<li><a href = 'scoreDetails.php?id=". $row[0] . "'>Game " . $row[0] . "</a></li>";
                }
            ?>
        </ul>
    </body>
</html>