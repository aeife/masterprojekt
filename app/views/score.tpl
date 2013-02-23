{extends file='./main.tpl'}

{block name=body}
    <h1>SCORE</h1>
    <ul>
        {foreach from=$list item=row}
            <li><a href = 'score/{$row["id"]}'>Game {$row["id"]}</a></li>  
        {/foreach}
    </ul>
{/block}