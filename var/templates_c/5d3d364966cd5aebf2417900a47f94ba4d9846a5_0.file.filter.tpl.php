<?php
/* Smarty version 3.1.33, created on 2022-09-27 17:18:01
  from '/var/www/html/modules/ivr_category/themes/default/filter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6332e2f1e27f52_80144330',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d3d364966cd5aebf2417900a47f94ba4d9846a5' => 
    array (
      0 => '/var/www/html/modules/ivr_category/themes/default/filter.tpl',
      1 => 1664273447,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6332e2f1e27f52_80144330 (Smarty_Internal_Template $_smarty_tpl) {
?><table width="99%" border="0" cellspacing="0" cellpadding="4" align="center">
      <tr class="letra12">
        <td width="8%" align="right"><?php echo $_smarty_tpl->tpl_vars['date_start']->value['LABEL'];?>
: <span  class="required">*</span></td>
        <td width="12%" align="left" nowrap><?php echo $_smarty_tpl->tpl_vars['date_start']->value['INPUT'];?>
</td>
        <td width="8%" align="right"><?php echo $_smarty_tpl->tpl_vars['date_end']->value['LABEL'];?>
: <span  class="required">*</span></td>
        <td width="12%" align="left" nowrap><?php echo $_smarty_tpl->tpl_vars['date_end']->value['INPUT'];?>
</td>
        <td width="8%" align="right"><?php echo $_smarty_tpl->tpl_vars['ivr_menu']->value['LABEL'];?>
: </td>
        <td width="12%" align="left" nowrap><?php echo $_smarty_tpl->tpl_vars['ivr_menu']->value['INPUT'];?>
</td>
        <td width="8%" align="right"><?php echo $_smarty_tpl->tpl_vars['report_type']->value['LABEL'];?>
: </td>
        <td width="12%" align="left" nowrap><?php echo $_smarty_tpl->tpl_vars['report_type']->value['INPUT'];?>
</td>
        <td width="8%" align="center">
            <input class="button" type="submit" name="filter" value="<?php echo $_smarty_tpl->tpl_vars['Filter']->value;?>
" >
        </td>
      </tr>
</table>

<?php }
}
