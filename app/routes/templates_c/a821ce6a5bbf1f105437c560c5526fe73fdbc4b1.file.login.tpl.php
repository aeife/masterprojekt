<?php /* Smarty version Smarty-3.1.13, created on 2013-02-23 19:36:35
         compiled from "..\views\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:267735127717761b2d2-19079852%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a821ce6a5bbf1f105437c560c5526fe73fdbc4b1' => 
    array (
      0 => '..\\views\\login.tpl',
      1 => 1361644426,
      2 => 'file',
    ),
    '96909e926ac391f92a72641495c68867f1efd560' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\main.tpl',
      1 => 1361641526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '267735127717761b2d2-19079852',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51277177665088_88480058',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51277177665088_88480058')) {function content_51277177665088_88480058($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
       
    <form action="login" method="post">
        name: <input type="text" name="name"><br>
        Password: <input type="password" name="password">
        <input type="submit" value="Submit">
    </form>

    </body>
</html><?php }} ?>