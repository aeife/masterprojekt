{if isset($smarty.session.username) }
    <br/>
    Logged in as: {$smarty.session.username}
    <a href="logout"><input type="button" class="button" value="Logout"></a>
{else}
    <form action="login" method="post">
        <label for="name">Username:</label>
        <input type="text" name="name">
        <label for="password">Passwort:</label>
        <input type="password" name="password">
        <input type="submit" class="button" value="Login">
    </form>
{/if}