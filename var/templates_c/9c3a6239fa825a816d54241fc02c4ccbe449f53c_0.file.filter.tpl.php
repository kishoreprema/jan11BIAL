<?php
/* Smarty version 3.1.33, created on 2022-09-27 17:17:08
  from '/var/www/html/modules/group_permission/themes/default/filter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6332e2bca6db67_04815289',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c3a6239fa825a816d54241fc02c4ccbe449f53c' => 
    array (
      0 => '/var/www/html/modules/group_permission/themes/default/filter.tpl',
      1 => 1664271816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6332e2bca6db67_04815289 (Smarty_Internal_Template $_smarty_tpl) {
?><table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="letra12">
        <td width="10%" align="right"><?php echo $_smarty_tpl->tpl_vars['filter_group']->value['LABEL'];?>
:</td>
        <td width="20%" align="left"><?php echo $_smarty_tpl->tpl_vars['filter_group']->value['INPUT'];?>
</td>
        <td align="left"><input class="button" type="submit" name="show" value="<?php echo $_smarty_tpl->tpl_vars['SHOW']->value;?>
" /><td>
    </tr>
</table>
<?php }
}
