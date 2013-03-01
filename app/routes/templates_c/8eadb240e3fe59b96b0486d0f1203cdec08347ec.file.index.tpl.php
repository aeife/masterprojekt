<?php /* Smarty version Smarty-3.1.13, created on 2013-03-01 16:06:25
         compiled from "..\views\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27886512e28d32a5ff0-94343493%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8eadb240e3fe59b96b0486d0f1203cdec08347ec' => 
    array (
      0 => '..\\views\\index.tpl',
      1 => 1362150368,
      2 => 'file',
    ),
    '96909e926ac391f92a72641495c68867f1efd560' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\main.tpl',
      1 => 1361872999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27886512e28d32a5ff0-94343493',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_512e28d32e51a9_71399935',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512e28d32e51a9_71399935')) {function content_512e28d32e51a9_71399935($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Snake</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="language" content="de">
<link rel="stylesheet" type="text/css" href="../public/stylesheets/style.css">

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

    <img src="../public/images/spiel.png"/>
    <h2>Willkommen!</h2>
    <br>
    Schnelle Reaktion und taktisches Gespür sind notwendig, um den Highscore zu erklimmen.
    <h3><u>Features:</u></h3>
    <ul>
        <li>Sofort loslegen, ohne Plugins.</li>
        <li>Mehrspielermodus (bis zu 4 Spieler)</li>
        <li>Archiv aller bisherigen Spiele</li>
        <li>Globaler Highscore</li>
    </ul>



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