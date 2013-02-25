<?php /* Smarty version Smarty-3.1.13, created on 2013-02-25 13:55:43
         compiled from "..\views\game.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7594512772ad536660-78414044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7590c89901fd047575521b237085832fd1bd5c17' => 
    array (
      0 => '..\\views\\game.tpl',
      1 => 1361793584,
      2 => 'file',
    ),
    '96909e926ac391f92a72641495c68867f1efd560' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\main.tpl',
      1 => 1361796832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7594512772ad536660-78414044',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_512772ad580cd2_51818579',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512772ad580cd2_51818579')) {function content_512772ad580cd2_51818579($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
        
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <<?php ?>?php session_start(); ?<?php ?>>

    </head>
    <body>
        <?php echo $_smarty_tpl->getSubTemplate ('../views/menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <br/>
        <?php echo $_smarty_tpl->getSubTemplate ('../views/login.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <br/>
        
     <script>
        <?php if (isset($_smarty_tpl->tpl_vars['username']->value)){?>
            var username = "<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
"; 
        <?php }?>
    </script>

    <canvas id="canvas" width="5000" height="5000"></canvas>

    <script src="../public/javascripts/fancywebsocket.js"></script>
    <script src="../public/javascripts/level.js" type="text/javascript"></script>
    <script src="../public/javascripts/player.js" type="text/javascript"></script>
    <script src="../public/javascripts/app.js" type="text/javascript"></script>

    </body>
</html><?php }} ?>