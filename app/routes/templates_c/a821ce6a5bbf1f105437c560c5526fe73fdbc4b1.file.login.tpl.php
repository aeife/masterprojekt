<?php /* Smarty version Smarty-3.1.13, created on 2013-02-26 10:59:27
         compiled from "..\views\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:267735127717761b2d2-19079852%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '267735127717761b2d2-19079852',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51277177665088_88480058',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51277177665088_88480058')) {function content_51277177665088_88480058($_smarty_tpl) {?><?php if (isset($_SESSION['username'])){?>
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