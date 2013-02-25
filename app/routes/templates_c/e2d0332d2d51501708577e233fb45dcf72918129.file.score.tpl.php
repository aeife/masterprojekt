<?php /* Smarty version Smarty-3.1.13, created on 2013-02-25 13:39:15
         compiled from "..\views\score.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1593351276a77891438-03269106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2d0332d2d51501708577e233fb45dcf72918129' => 
    array (
      0 => '..\\views\\score.tpl',
      1 => 1361793584,
      2 => 'file',
    ),
    '96909e926ac391f92a72641495c68867f1efd560' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\main.tpl',
      1 => 1361795717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1593351276a77891438-03269106',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51276a779cc1e2_72339676',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51276a779cc1e2_72339676')) {function content_51276a779cc1e2_72339676($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <?php echo $_smarty_tpl->getSubTemplate ('../views/menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <?php echo $_smarty_tpl->getSubTemplate ('../views/login.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        
    <h1>SCORE</h1>
    <ul>
        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
            <li><a href = 'score/<?php echo $_smarty_tpl->tpl_vars['row']->value["id"];?>
'>Game <?php echo $_smarty_tpl->tpl_vars['row']->value["id"];?>
</a></li>  
        <?php } ?>
    </ul>

    </body>
</html><?php }} ?>