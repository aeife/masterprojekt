{if isset($smarty.session.username) }
    Logged in as: {$smarty.session.username}
    <a href="logout">Logout</a>
{else}
    <form action="login" method="post">
        name: <input type="text" name="name"><br>
        Password: <input type="password" name="password">
        <input type="submit" value="Submit">
    </form>
{/if}
