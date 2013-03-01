{extends file='./main.tpl'}

{block name=body}
    <h2>Highscore</h2>
    <br/>
    <div id="scoreDesc">
        Pro Platz werden folgende Punkte verteilt: <br/>
        <br/>
        1. Platz: 50 Punkte <br/>
        2. Platz: 25 Punkte <br/>
        3. Platz: 10 Punkte <br/>
        4. Platz: 5 Punkte <br/>
    </div>

     <ol>
        {foreach from=$list item=row}
            <li><p class="scorePlayers">{$row["username"]}</p> {$row["score"]}</li>
        {/foreach}
    </ol>
{/block}