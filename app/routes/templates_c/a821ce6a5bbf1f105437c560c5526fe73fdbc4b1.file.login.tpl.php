<?php /* Smarty version Smarty-3.1.13, created on 2013-02-27 16:40:38
         compiled from "..\views\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30870512e28f6685e71-46843942%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a821ce6a5bbf1f105437c560c5526fe73fdbc4b1' => 
    array (
      0 => '..\\views\\login.tpl',
      1 => 1361872654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30870512e28f6685e71-46843942',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_512e28f66bb993_48030944',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512e28f66bb993_48030944')) {function content_512e28f66bb993_48030944($_smarty_tpl) {?><?php if (isset($_SESSION['username'])){?>
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