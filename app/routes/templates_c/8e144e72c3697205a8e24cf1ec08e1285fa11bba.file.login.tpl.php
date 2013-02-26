<?php /* Smarty version Smarty-3.1.13, created on 2013-02-26 10:57:35
         compiled from "C:\xampp\htdocs\git\masterprojekt\app\views\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7232512b5a86314807-46656912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e144e72c3697205a8e24cf1ec08e1285fa11bba' => 
    array (
      0 => 'C:\\xampp\\htdocs\\git\\masterprojekt\\app\\views\\login.tpl',
      1 => 1361872654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7232512b5a86314807-46656912',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_512b5a86316bd7_92317105',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512b5a86316bd7_92317105')) {function content_512b5a86316bd7_92317105($_smarty_tpl) {?><?php if (isset($_SESSION['username'])){?>
    <br/>
    Logged in as: <?php echo $_SESSION['username'];?>

    <a href="logout"><input type="button" class="button" value="Logout"></a>
<?php }else{ ?>
    <form action="login" method="post">
        <label for="name">Username:</label>
        <input type="text" name="name">
        <label for="password">Passwort:</label>
        <input type="password" name="password">
        <input type="submit" class="button" value="Login">
    </form>
<?php }?><?php }} ?>