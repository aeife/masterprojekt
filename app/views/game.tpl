{extends file='./main.tpl'}

{block name=head}
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <?php session_start(); ?>
{/block}

{block name=body}
     <script>
        {if isset($smarty.session.username) }
            var username = "{$smarty.session.username}"; 
        {/if}
    </script>
    <center>
        <canvas id="canvas" width="500" height="500"></canvas>
    </center>
    <script src="../public/javascripts/fancywebsocket.js"></script>
    <script src="../public/javascripts/level.js" type="text/javascript"></script>
    <script src="../public/javascripts/player.js" type="text/javascript"></script>
    <script src="../public/javascripts/app.js" type="text/javascript"></script>
{/block}