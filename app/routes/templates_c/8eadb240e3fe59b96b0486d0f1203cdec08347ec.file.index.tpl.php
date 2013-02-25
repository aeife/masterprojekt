<?php /* Smarty version Smarty-3.1.13, created on 2013-02-25 13:53:53
         compiled from "..\views\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:805151277293b48de8-15860945%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8eadb240e3fe59b96b0486d0f1203cdec08347ec' => 
    array (
      0 => '..\\views\\index.tpl',
      1 => 1361795279,
      2 => 'file',
    ),
    '96909e926ac391f92a72641495c68867f1efd560' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\main.tpl',
      1 => 1361796832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '805151277293b48de8-15860945',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51277293b6d265_12722697',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51277293b6d265_12722697')) {function content_51277293b6d265_12722697($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <?php echo $_smarty_tpl->getSubTemplate ('../views/menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <br/>
        <?php echo $_smarty_tpl->getSubTemplate ('../views/login.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <br/>
        
    Awesome Game!

    </body>
</html><?php }} ?>