<?php
/* Smarty version 3.1.33, created on 2022-09-27 17:18:01
  from '/var/www/html/modules/ivr_category/themes/default/datatables.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6332e2f1e475b0_30060940',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '76952f98149fff124cf69ab9f2b71b4913f58107' => 
    array (
      0 => '/var/www/html/modules/ivr_category/themes/default/datatables.tpl',
      1 => 1664273447,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6332e2f1e475b0_30060940 (Smarty_Internal_Template $_smarty_tpl) {
?><div class='modal' id='gridModal' tabindex='-1' role='dialog'>
  <div class='modal-dialog <?php echo $_smarty_tpl->tpl_vars['modalClass']->value;?>
' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title'><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'modalTitle');?>
</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body' id='gridModalContent'>
        <?php echo $_smarty_tpl->tpl_vars['modalContent']->value;?>

      </div>
    </div>
  </div>
</div>
<?php }
}
