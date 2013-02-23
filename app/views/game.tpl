{extends file='./main.tpl'}

{block name=head}
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <?php session_start(); ?>
{/block}

{block name=body}
     <script>
        {if isset($username) }
            var username = "{$username}"; 
        {/if}
    </script>

    <canvas id="canvas" width="5000" height="5000"></canvas>

    <script src="../public/javascripts/fancywebsocket.js"></script>
    <script src="../public/javascripts/level.js" type="text/javascript"></script>
    <script src="../public/javascripts/player.js" type="text/javascript"></script>
    <script src="../public/javascripts/app.js" type="text/javascript"></script>
{/block}