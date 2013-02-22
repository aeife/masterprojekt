<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <ol>
            {foreach from=$list item=row}
                <li>{$row["username"]}</li>
            {/foreach}
        </ol>
    </body>
</html>