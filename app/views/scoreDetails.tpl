{extends file='./main.tpl'}

{block name=body}
    <h2>Spieldetails</h2>
    <br/>
    <ol>
        {foreach from=$list item=row}
            <li>{$row["username"]}</li>
        {/foreach}
    </ol>
{/block}