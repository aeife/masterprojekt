<?php /* Smarty version Smarty-3.1.13, created on 2013-02-22 14:19:56
         compiled from "..\views\register.tpl" */ ?>
<?php /*%%SmartyHeaderCode:81625127707ce7f699-73288304%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c845f5f237261abd573fc8b38adc43c1418f5438' => 
    array (
      0 => '..\\views\\register.tpl',
      1 => 1361539184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '81625127707ce7f699-73288304',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5127707ceab0b0_89769407',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5127707ceab0b0_89769407')) {function content_5127707ceab0b0_89769407($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <p><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
        <form action="register" method="post">
            Name: <input type="text" name="name"><br>
            Password: <input type="password" name="password"><br>
            Repeat Password: <input type="password" name="passwordRepeat">
            <input type="submit" value="Submit">
        </form>
    </body>
</html><?php }} ?>