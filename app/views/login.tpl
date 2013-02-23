{extends file='./main.tpl'}

{block name=body}
    <form action="login" method="post">
        name: <input type="text" name="name"><br>
        Password: <input type="password" name="password">
        <input type="submit" value="Submit">
    </form>
{/block}