{extends file='./main.tpl'}

{block name=body}
     <ol>
        {foreach from=$list item=row}
            <li>{$row["username"]} {$row["score"]}</li>
        {/foreach}
    </ol>
{/block}