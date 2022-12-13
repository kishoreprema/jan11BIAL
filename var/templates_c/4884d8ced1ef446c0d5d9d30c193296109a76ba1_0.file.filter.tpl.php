<?php
/* Smarty version 3.1.33, created on 2022-09-29 13:42:12
  from '/var/www/html/modules/summary_by_extension/themes/default/filter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6335535cc34877_75169564',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4884d8ced1ef446c0d5d9d30c193296109a76ba1' => 
    array (
      0 => '/var/www/html/modules/summary_by_extension/themes/default/filter.tpl',
      1 => 1664271816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6335535cc34877_75169564 (Smarty_Internal_Template $_smarty_tpl) {
?><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="letra12">
        <td align="right" width="8%"><?php echo $_smarty_tpl->tpl_vars['date_from']->value['LABEL'];?>
:&nbsp;</td>
        <td align="left" width="13%"><?php echo $_smarty_tpl->tpl_vars['date_from']->value['INPUT'];?>
</td>
        <td align="right" width="7%"><?php echo $_smarty_tpl->tpl_vars['option_fil']->value['LABEL'];?>
:&nbsp;</td>
        <td align="left" width="22%"><?php echo $_smarty_tpl->tpl_vars['option_fil']->value['INPUT'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['value_fil']->value['INPUT'];?>
</td>
        <td align="left"><input class="button" type="submit" name="show" value="<?php echo $_smarty_tpl->tpl_vars['SHOW']->value;?>
"></td>
    </tr>
    <tr class="letra12">
        <td align="right" width="5%"><?php echo $_smarty_tpl->tpl_vars['date_to']->value['LABEL'];?>
:&nbsp;</td>
        <td align="left"><?php echo $_smarty_tpl->tpl_vars['date_to']->value['INPUT'];?>
</td>
    </tr>
</table>


<?php echo '<script'; ?>
 type= "text/javascript">

function popup_ventana(url_popup)
{
    var ancho = 750;
    var alto = 580;
    var winiz = (screen.width-ancho)/2;
    var winal = (screen.height-alto)/2;
    my_window = window.open(url_popup,"my_window","width="+ancho+",height="+alto+",top="+winal+",left="+winiz+",location=yes,status=yes,resizable=yes,scrollbars=yes,fullscreen=no,toolbar=yes");
    my_window.document.close();
}

<?php echo '</script'; ?>
>

<?php }
}
