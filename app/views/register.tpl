{extends file='./main.tpl'}

{block name=body}
    <h2>Registrierung</h2>
   <p>{$error}</p>
    <form action="register" method="post">
        <label for="name">Name:</label> <input type="text" name="name"><br>
        <label for="password">Passwort:</label> <input type="password" name="password"><br>
        <label for="passwordRepeat">Passwort wiederholen:</label> <input type="password" name="passwordRepeat"><br>
        <label>&nbsp;</label> <input type="submit" value="Registrieren">
    </form>
{/block}