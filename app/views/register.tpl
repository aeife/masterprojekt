{extends file='./main.tpl'}

{block name=body}
   <p>{$error}</p>
    <form action="register" method="post">
        Name: <input type="text" name="name"><br>
        Password: <input type="password" name="password"><br>
        Repeat Password: <input type="password" name="passwordRepeat">
        <input type="submit" value="Submit">
    </form>
{/block}