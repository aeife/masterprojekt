<?php /* Smarty version Smarty-3.1.13, created on 2013-03-01 16:09:55
         compiled from "..\views\game.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28748512e28fc499719-63157442%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7590c89901fd047575521b237085832fd1bd5c17' => 
    array (
      0 => '..\\views\\game.tpl',
      1 => 1362150590,
      2 => 'file',
    ),
    '96909e926ac391f92a72641495c68867f1efd560' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\main.tpl',
      1 => 1361872999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28748512e28fc499719-63157442',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_512e28fc4e3b97_20805645',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512e28fc4e3b97_20805645')) {function content_512e28fc4e3b97_20805645($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Snake</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="language" content="de">
<link rel="stylesheet" type="text/css" href="../public/stylesheets/style.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <<?php ?>?php session_start(); ?<?php ?>>

</head>
<body>
<!-- Globale Box -->
<div id="global">
<!-- Top -->
<div id="bg_top">
<div id="top_login">
  <?php echo $_smarty_tpl->getSubTemplate ('../views/login.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<div id="top_menue">
   <?php echo $_smarty_tpl->getSubTemplate ('../views/menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
</div>
<!-- Content -->
<div id="bg_content">

     <script>
        <?php if (isset($_smarty_tpl->tpl_vars['username']->value)){?>
            var username = "<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
"; 
        <?php }?>
    </script>
    <center>
        <canvas id="canvas" width="500" height="500"></canvas>
    </center>
    <script src="../public/javascripts/fancywebsocket.js"></script>
    <script src="../public/javascripts/level.js" type="text/javascript"></script>
    <script src="../public/javascripts/player.js" type="text/javascript"></script>
    <script src="../public/javascripts/app.js" type="text/javascript"></script>



</div>
<!-- Footer -->
<div id="bg_footer">
    <div id="bg_footer_li">
         &copy; 2012 - 2013 - <strong>André Eife & Benjamin Teufel</strong>
    </div>
    <div id="bg_footer_re">
         <a href="/impressum">Impressum</a>
    </div>
</div>

</div>
</body>
</html><?php }} ?>