<?php /* Smarty version Smarty-3.1.13, created on 2013-03-04 11:52:43
         compiled from "..\views\scoreDetails.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23963512e290b5aa113-98504367%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f9f06ec51de659abd9d427eee1f4b3ab38d2fcd' => 
    array (
      0 => '..\\views\\scoreDetails.tpl',
      1 => 1362149509,
      2 => 'file',
    ),
    '96909e926ac391f92a72641495c68867f1efd560' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\main.tpl',
      1 => 1362391669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23963512e290b5aa113-98504367',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_512e290b68b412_69286788',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512e290b68b412_69286788')) {function content_512e290b68b412_69286788($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MultiCollide</title>
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

    <h2>Spieldetails</h2>
    <br/>
    <ol>
        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
            <li><?php echo $_smarty_tpl->tpl_vars['row']->value["username"];?>
</li>
        <?php } ?>
    </ol>



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