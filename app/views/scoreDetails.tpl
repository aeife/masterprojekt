{extends file='./main.tpl'}

{block name=body}
    <ol>
        {foreach from=$list item=row}
            <li>{$row["username"]}</li>
        {/foreach}
    </ol>
{/block}