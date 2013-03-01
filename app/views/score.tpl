{extends file='./main.tpl'}

{block name=body}
    <h2>Score</h2>
    <br/>
    <ul id="score">
        {foreach from=$list item=row}
            <li><a href = 'score/{$row["id"]}'>Game {$row["id"]}</a></li>  
        {/foreach}
    </ul>
{/block}