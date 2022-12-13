<?php
/* Smarty version 3.1.33, created on 2022-10-25 12:30:51
  from '/var/www/html/modules/consolidated_report/themes/default/filter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_635789a3a3a984_43008238',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '833c4186bb689a473ef5491aa7842a397e3a77b9' => 
    array (
      0 => '/var/www/html/modules/consolidated_report/themes/default/filter.tpl',
      1 => 1666681244,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_635789a3a3a984_43008238 (Smarty_Internal_Template $_smarty_tpl) {
?><table width="99%" border="0" cellspacing="0" cellpadding="4" align="center">
      <tr class="letra12">
        <td width="8%" align="right"><?php echo $_smarty_tpl->tpl_vars['date_ranges']->value['LABEL'];?>
: <span  class="required">*</span></td>
        <td width="12%" align="left" nowrap><?php echo $_smarty_tpl->tpl_vars['date_ranges']->value['INPUT'];?>
</td>
        <td width="8%" align="right"><?php echo $_smarty_tpl->tpl_vars['date_start']->value['LABEL'];?>
: <span  class="required">*</span></td>
        <td width="12%" align="left" nowrap><?php echo $_smarty_tpl->tpl_vars['date_start']->value['INPUT'];?>
</td>
        <td width="8%" align="right"><?php echo $_smarty_tpl->tpl_vars['date_end']->value['LABEL'];?>
: <span  class="required">*</span></td>
        <td width="12%" align="left" nowrap><?php echo $_smarty_tpl->tpl_vars['date_end']->value['INPUT'];?>
</td>
        <td width="8%" align="center">
            <input class="button" type="submit" name="filter" value="<?php echo $_smarty_tpl->tpl_vars['Filter']->value;?>
" >
        </td>
      </tr>
</table>

<?php }
}
