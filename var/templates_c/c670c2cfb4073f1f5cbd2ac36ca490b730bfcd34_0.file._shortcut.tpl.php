<?php
/* Smarty version 3.1.33, created on 2023-01-06 16:32:27
  from '/replica/var_www/html/themes/tenant/_common/_shortcut.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_63b7ffc36015a5_48263624',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c670c2cfb4073f1f5cbd2ac36ca490b730bfcd34' => 
    array (
      0 => '/replica/var_www/html/themes/tenant/_common/_shortcut.tpl',
      1 => 1673000581,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b7ffc36015a5_48263624 (Smarty_Internal_Template $_smarty_tpl) {
?><li>
    <?php if ($_smarty_tpl->tpl_vars['SHORTCUT_BOOKMARKS']->value) {?>
        <a href="#">
            <i class="fa fa-star"></i>
            <span><?php echo $_smarty_tpl->tpl_vars['SHORTCUT_BOOKMARKS_LABEL']->value;?>
</span>
        </a>
        <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SHORTCUT_BOOKMARKS']->value, 'shortcut', false, NULL, 'shortcut', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['shortcut']->value) {
?>
                <li>
                    <a href="index.php?menu=<?php echo $_smarty_tpl->tpl_vars['shortcut']->value['namemenu'];?>
">
                        <span><?php echo $_smarty_tpl->tpl_vars['shortcut']->value['name'];?>
</span>
                    </a>
                </li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
    <?php }?>
</li>

<li>
    <a href="#">
         <i class="fa fa-history"></i>
        <span><?php echo $_smarty_tpl->tpl_vars['SHORTCUT_HISTORY_LABEL']->value;?>
</span>
    </a>
    <ul>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SHORTCUT_HISTORY']->value, 'shortcut');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['shortcut']->value) {
?>
            <li>
                <a href="index.php?menu=<?php echo $_smarty_tpl->tpl_vars['shortcut']->value['namemenu'];?>
">
                    <span><?php echo $_smarty_tpl->tpl_vars['shortcut']->value['name'];?>
</span>
                </a>
            </li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
</li><?php }
}
