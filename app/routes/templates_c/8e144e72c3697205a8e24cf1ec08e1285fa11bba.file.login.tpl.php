<?php /* Smarty version Smarty-3.1.13, created on 2013-03-01 15:18:29
         compiled from "C:\xampp\htdocs\git\masterprojekt\app\views\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28700512e28d3382fe1-16343861%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e144e72c3697205a8e24cf1ec08e1285fa11bba' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\login.tpl',
      1 => 1362147496,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28700512e28d3382fe1-16343861',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_512e28d34612b3_27486836',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512e28d34612b3_27486836')) {function content_512e28d34612b3_27486836($_smarty_tpl) {?><?php if (isset($_SESSION['username'])){?>
    <br/>
    Eingeloggt als: <?php echo $_SESSION['username'];?>

    <a href="/logout"><input type="button" class="button" value="Logout"></a>
<?php }else{ ?>
    <form action="login" method="post">
        <label for="name">Username:</label>
        <input type="text" name="name">
        <label for="password">Passwort:</label>
        <input type="password" name="password">
        <input type="submit" class="button" value="Login">
    </form>
<?php }?><?php }} ?>