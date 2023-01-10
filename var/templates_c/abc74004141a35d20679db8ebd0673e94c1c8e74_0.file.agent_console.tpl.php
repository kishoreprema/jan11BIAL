<?php
/* Smarty version 3.1.33, created on 2023-01-06 11:18:25
  from '/var/www/html/modules/agent_console/themes/default/agent_console.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_63b7b62955b322_10764690',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'abc74004141a35d20679db8ebd0673e94c1c8e74' => 
    array (
      0 => '/var/www/html/modules/agent_console/themes/default/agent_console.tpl',
      1 => 1664271816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b7b62955b322_10764690 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/usr/share/php/Smarty/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LISTA_JQUERY_CSS']->value, 'CURR_ITEM');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['CURR_ITEM']->value) {
?>
    <?php if ($_smarty_tpl->tpl_vars['CURR_ITEM']->value[0] == 'css') {?>
<link rel="stylesheet" href='<?php echo $_smarty_tpl->tpl_vars['CURR_ITEM']->value[1];?>
' />
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['CURR_ITEM']->value[0] == 'js') {
echo '<script'; ?>
 type="text/javascript" src='<?php echo $_smarty_tpl->tpl_vars['CURR_ITEM']->value[1];?>
'><?php echo '</script'; ?>
>
    <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<div
    id="issabel-callcenter-info-message"
    class="ui-state-highlight ui-corner-all">
    <p>
        <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <span id="issabel-callcenter-info-message-text"></span>
    </p>
</div>
<div
    id="issabel-callcenter-error-message"
    class="ui-state-error ui-corner-all">
    <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <span id="issabel-callcenter-error-message-text"></span>
    </p>
</div>
<div id="issabel-callcenter-area-principal">
    <?php if (!$_smarty_tpl->tpl_vars['FRAMEWORK_TIENE_TITULO_MODULO']->value) {?>
    <div id="issabel-callcenter-titulo-consola" class="moduleTitle">&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['icon']->value;?>
" border="0" align="absmiddle" alt="" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</div>
<?php }?>
		<div id="issabel-callcenter-estado-agente" class="<?php echo $_smarty_tpl->tpl_vars['CLASS_ESTADO_AGENTE_INICIAL']->value;?>
">
	    <div id="issabel-callcenter-estado-agente-texto"><?php echo $_smarty_tpl->tpl_vars['TEXTO_ESTADO_AGENTE_INICIAL']->value;?>
</div>
        <div id="issabel-callcenter-cronometro"><?php echo $_smarty_tpl->tpl_vars['CRONOMETRO']->value;?>
</div>    </div>    <div id="issabel-callcenter-wrap">
	    	    <div id="issabel-callcenter-controles">
	        <button id="btn_hangup" class="issabel-callcenter-boton-activo"><?php echo $_smarty_tpl->tpl_vars['BTN_COLGAR_LLAMADA']->value;?>
</button>
	        <button id="btn_togglebreak" class="<?php echo $_smarty_tpl->tpl_vars['CLASS_BOTON_BREAK']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['BTN_BREAK']->value;?>
</button>
	        <button id="btn_transfer" class="issabel-callcenter-boton-activo" ><?php echo $_smarty_tpl->tpl_vars['BTN_TRANSFER']->value;?>
</button>
            <button id="btn_agendar_llamada" <?php if ($_smarty_tpl->tpl_vars['CALLINFO_CALLTYPE']->value != 'outgoing') {?>disabled="disabled"<?php }?>><?php echo $_smarty_tpl->tpl_vars['BTN_AGENDAR_LLAMADA']->value;?>
</button>
	        <button id="btn_guardar_formularios"><?php echo $_smarty_tpl->tpl_vars['BTN_GUARDAR_FORMULARIOS']->value;?>
</button>
<?php if ($_smarty_tpl->tpl_vars['BTN_VTIGERCRM']->value) {?>
	        <button id="btn_vtigercrm" class="issabel-callcenter-boton-activo"><?php echo $_smarty_tpl->tpl_vars['BTN_VTIGERCRM']->value;?>
</button>
<?php }?>
	        <button id="btn_logout" class="issabel-callcenter-boton-activo"><?php echo $_smarty_tpl->tpl_vars['BTN_FINALIZAR_LOGIN']->value;?>
</button>
	    </div> 	    	    <div id="issabel-callcenter-contenido">
						<div id="issabel-callcenter-cejillas-contenido">
			   <ul>
                   <li><a href="#issabel-callcenter-llamada-paneles"><?php echo $_smarty_tpl->tpl_vars['TAB_LLAMADA']->value;?>
</a></li>
                   <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CUSTOM_PANELS']->value, 'HTML_PANEL');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['HTML_PANEL']->value) {
?>
                   <li><a href="#tabs-<?php echo $_smarty_tpl->tpl_vars['HTML_PANEL']->value['panelname'];?>
"><?php echo $_smarty_tpl->tpl_vars['HTML_PANEL']->value['title'];?>
</a></li>
                   <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			   </ul>
                <div id="issabel-callcenter-llamada-paneles">
                    <div id="issabel-callcenter-llamada-paneles-izq" class="ui-layout-west">
                        <div class="ui-layout-center"><fieldset class="ui-widget-content ui-corner-all"><legend><b><?php echo $_smarty_tpl->tpl_vars['TAB_LLAMADA_INFO']->value;?>
</b></legend><div id="issabel-callcenter-llamada-info"><?php echo $_smarty_tpl->tpl_vars['CONTENIDO_LLAMADA_INFORMACION']->value;?>
</div></fieldset></div>
                        <div class="ui-layout-south"><fieldset class="ui-widget-content ui-corner-all"><legend><b><?php echo $_smarty_tpl->tpl_vars['TAB_LLAMADA_SCRIPT']->value;?>
</b></legend><div id="issabel-callcenter-llamada-script"><?php echo $_smarty_tpl->tpl_vars['CONTENIDO_LLAMADA_SCRIPT']->value;?>
</div></fieldset></div>
                    </div>
                    <div class="ui-layout-center"><fieldset class="ui-widget-content ui-corner-all"><legend><b><?php echo $_smarty_tpl->tpl_vars['TAB_LLAMADA_FORM']->value;?>
</b></legend><div id="issabel-callcenter-llamada-form"><?php echo $_smarty_tpl->tpl_vars['CONTENIDO_LLAMADA_FORMULARIO']->value;?>
</div></fieldset></div>
                </div>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CUSTOM_PANELS']->value, 'HTML_PANEL');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['HTML_PANEL']->value) {
?>
                <div id="tabs-<?php echo $_smarty_tpl->tpl_vars['HTML_PANEL']->value['panelname'];?>
">
                    <?php echo $_smarty_tpl->tpl_vars['HTML_PANEL']->value['content'];?>

                </div>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</div>		</div>	</div>
</div><div id="issabel-callcenter-seleccion-break" title="<?php echo $_smarty_tpl->tpl_vars['TITLE_BREAK_DIALOG']->value;?>
">
    <form>
        <select
            name="break_select"
            id="break_select"
            class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"
            style="width: 100%"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['LISTA_BREAKS']->value),$_smarty_tpl);?>

        </select>
    </form>
</div><div id="issabel-callcenter-seleccion-transfer" title="<?php echo $_smarty_tpl->tpl_vars['TITLE_TRANSFER_DIALOG']->value;?>
">
    <form>
        <table border="0" cellpadding="0" style="width: 100%;">
            <tr>
                <td><input
                name="transfer_extension"
                id="transfer_extension"
                class="ui-widget-content ui-corner-all"
                style="width: 100%" /></td>
            </tr>
            <tr>
                <td>
                    <div align="center" id="transfer_type_radio">
                        <input type="radio" id="transfer_type_blind" name="transfer_type" value="blind" checked="checked"/><label for="transfer_type_blind"><?php echo $_smarty_tpl->tpl_vars['LBL_TRANSFER_BLIND']->value;?>
</label>
                        <input type="radio" id="transfer_type_attended" name="transfer_type" value="attended" /><label for="transfer_type_attended"><?php echo $_smarty_tpl->tpl_vars['LBL_TRANSFER_ATTENDED']->value;?>
</label>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div><div id="issabel-callcenter-agendar-llamada" title="<?php echo $_smarty_tpl->tpl_vars['TITLE_SCHEDULE_CALL']->value;?>
">
	<div
	    id="issabel-callcenter-agendar-llamada-error-message"
	    class="ui-state-error ui-corner-all">
	    <p>
	        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
	        <span id="issabel-callcenter-agendar-llamada-error-message-text"></span>
	    </p>
	</div>
    <form>
        <table border="0" cellpadding="0" style="width: 100%;">
            <tr>
                <td><label style="display: table-cell;" for="schedule_new_phone"><b><?php echo $_smarty_tpl->tpl_vars['LBL_CONTACTO_TELEFONO']->value;?>
:&nbsp;</b></label></td>
                <td><input
                    name="schedule_new_phone"
                    id="schedule_new_phone"
                    class="ui-widget-content ui-corner-all"
                    maxlength="64"
                    style="display: table-cell; width: 100%;"
                    value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TEXTO_CONTACTO_TELEFONO']->value, ENT_QUOTES, 'UTF-8', true);?>
" /></td>
            </tr>
            <tr>
                <td><label style="display: table-cell;" for="schedule_new_name"><b><?php echo $_smarty_tpl->tpl_vars['LBL_CONTACTO_NOMBRES']->value;?>
:&nbsp;</b></label></td>
                <td><input
                    name="schedule_new_name"
                    id="schedule_new_name"
                    class="ui-widget-content ui-corner-all"
                    maxlength="250"
                    style="display: table-cell; width: 100%;"
                    value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TEXTO_CONTACTO_NOMBRES']->value, ENT_QUOTES, 'UTF-8', true);?>
" /></td>
            </tr>
        </table>
        <hr />
        <div align="center" id="schedule_radio" style="width: 100%">
            <input type="radio" id="schedule_type_campaign_end" name="schedule_type" value="campaign_end" checked="checked"/><label for="schedule_type_campaign_end"><?php echo $_smarty_tpl->tpl_vars['LBL_SCHEDULE_CAMPAIGN_END']->value;?>
</label>
            <input type="radio" id="schedule_type_bydate" name="schedule_type" value="bydate" /><label for="schedule_type_bydate"><?php echo $_smarty_tpl->tpl_vars['LBL_SCHEDULE_BYDATE']->value;?>
</label>
        </div>
        <br/>
        <table id="schedule_date" border="0" cellpadding="0" style="width: 100%;">
            <tr>
                <td><label for="schedule_date_start"><b><?php echo $_smarty_tpl->tpl_vars['LBL_SCHEDULE_DATE_START']->value;?>
:&nbsp;</b></label></td>
                <td><input type="text" class="ui-widget-content ui-corner-all" name="schedule_date_start" id="schedule_date_start" /></td>
                <td><label for="schedule_date_end"><b><?php echo $_smarty_tpl->tpl_vars['LBL_SCHEDULE_DATE_END']->value;?>
:&nbsp;</b></label></td>
                <td><input type="text" class="ui-widget-content ui-corner-all" name="schedule_date_end" id="schedule_date_end" /></td>
            </tr>
            <tr>
                <td><label><b><?php echo $_smarty_tpl->tpl_vars['LBL_SCHEDULE_TIME_START']->value;?>
:&nbsp;</b></label></td>
                <td><select
                        name="schedule_time_start_hh"
                        id="schedule_time_start_hh"
                        class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['SCHEDULE_TIME_HH']->value),$_smarty_tpl);?>

                    </select>:<select
                        name="schedule_time_start_mm"
                        id="schedule_time_start_mm"
                        class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['SCHEDULE_TIME_MM']->value),$_smarty_tpl);?>

                    </select></td>
                <td><label><b><?php echo $_smarty_tpl->tpl_vars['LBL_SCHEDULE_TIME_END']->value;?>
:&nbsp;</b></label></td>
                <td><select
                        name="schedule_time_end_hh"
                        id="schedule_time_end_hh"
                        class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['SCHEDULE_TIME_HH']->value),$_smarty_tpl);?>

                    </select>:<select
                        name="schedule_time_end_mm"
                        id="schedule_time_end_mm"
                        class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['SCHEDULE_TIME_MM']->value),$_smarty_tpl);?>

                    </select></td>
            </tr>
            <tr>
                <td colspan="4"><input type="checkbox" id="schedule_same_agent" name="schedule_same_agent" /><label for="schedule_same_agent"><?php echo $_smarty_tpl->tpl_vars['LBL_SCHEDULE_SAME_AGENT']->value;?>
</label></td>
            </tr>
        </table>
    </form>
</div>

<?php echo '<script'; ?>
 type="text/javascript">
// Aplicar temas de jQueryUI a diversos elementos
$(document).ready(function() {

    apply_ui_styles(<?php echo $_smarty_tpl->tpl_vars['APPLY_UI_STYLES']->value;?>
);
    initialize_client_state(<?php echo $_smarty_tpl->tpl_vars['INITIAL_CLIENT_STATE']->value;?>
);

});
<?php echo '</script'; ?>
>

<?php }
}
