<?php
/* Smarty version 3.1.33, created on 2023-01-06 16:32:29
  from '/var/www/html/modules/dashboard/applets/IssabelNetwork/tpl/issabelnetwork.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_63b7ffc5791c69_54752545',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '497e9b1bb445b32b8795ebf6be5ad9106a83e855' => 
    array (
      0 => '/var/www/html/modules/dashboard/applets/IssabelNetwork/tpl/issabelnetwork.tpl',
      1 => 1673000581,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b7ffc5791c69_54752545 (Smarty_Internal_Template $_smarty_tpl) {
?><link rel="stylesheet" media="screen" type="text/css" href="modules/<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
/applets/IssabelNetwork/tpl/css/toastr.min.css" />
<link rel="stylesheet" media="screen" type="text/css" href="modules/<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
/applets/IssabelNetwork/tpl/css/issabelnetwork.css" />
<?php echo '<script'; ?>
 type='text/javascript' src='modules/<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
/applets/IssabelNetwork/js/javascript.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="modules/<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
/applets/IssabelNetwork/js/toastr.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
      
      toastr.options.timeOut = 12000; // How long the toast will display without user interaction
      toastr.options.extendedTimeOut = 12000; // How long the toast will display after a user hovers over it
      toastr.options.hideMethod = 'slideUp';
      //toastr.options.closeMethod = 'slideDown';
      toastr.options.onclick = function() { toastr.clear(); }
      toastr.options.progressBar = true;
      //toastr.options.preventDuplicates = true;
      toastr.options.newestOnTop = false;
      
   <?php echo '</script'; ?>
>
<table style="width:100%">
<tr>
<td>
<div style='width:50%;'>
  <p id="text_remote"><b><?php echo $_smarty_tpl->tpl_vars['LABEL_REMOTE']->value;?>
</b></p>
</div>
<div style='float:left;'>
<div class="wrapper" id="remoteadmintog">
  <input id="remoteadmin" type="checkbox" <?php echo $_smarty_tpl->tpl_vars['REMOTE_CHECKED']->value;?>
 /><label class="toggle" for="remoteadmin"><span class="toggle--handler"></span></label>
</div>
</div>
</td>
</tr>
</table>
<!-- Removed toaster by ashik --!>
<?php }
}
