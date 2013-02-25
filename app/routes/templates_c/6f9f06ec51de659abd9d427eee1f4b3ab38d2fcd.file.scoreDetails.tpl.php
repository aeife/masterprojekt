<?php /* Smarty version Smarty-3.1.13, created on 2013-02-25 13:56:06
         compiled from "..\views\scoreDetails.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2562451276dc22a47e6-52293819%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f9f06ec51de659abd9d427eee1f4b3ab38d2fcd' => 
    array (
      0 => '..\\views\\scoreDetails.tpl',
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
  'nocache_hash' => '2562451276dc22a47e6-52293819',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51276dc2300a49_46945161',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51276dc2300a49_46945161')) {function content_51276dc2300a49_46945161($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <?php echo $_smarty_tpl->getSubTemplate ('../views/menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <br/>
        <?php echo $_smarty_tpl->getSubTemplate ('../views/login.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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

    </body>
</html><?php }} ?>