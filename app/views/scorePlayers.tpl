<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
   

        <ol>
            {foreach from=$list item=row}
                <li>{$row["username"]} {$row["score"]}</li>
            {/foreach}
        </ol>
    </body>
</html>