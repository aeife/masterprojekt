<!DOCTYPE html>
<html>
    <head>
        <?php session_start(); ?>
    </head>
    <body>
        <form action="loginDB.php" method="post">
            name: <input type="text" name="name"><br>
            Password: <input type="password" name="password">
            <input type="submit" value="Submit">
        </form>
    </body>
</html>