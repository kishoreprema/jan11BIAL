<?php
/* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
  Codificación: UTF-8
  +----------------------------------------------------------------------+
  | Issabel version 0.5                                                  |
  | http://www.issabel.org                                               |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006 Palosanto Solutions S. A.                         |
  +----------------------------------------------------------------------+
  | The contents of this file are subject to the General Public License  |
  | (GPL) Version 2 (the "License"); you may not use this file except in |
  | compliance with the License. You may obtain a copy of the License at |
  | http://www.opensource.org/licenses/gpl-license.php                   |
  |                                                                      |
  | Software distributed under the License is distributed on an "AS IS"  |
  | basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See  |
  | the License for the specific language governing rights and           |
  | limitations under the License.                                       |
  +----------------------------------------------------------------------+
  | The Initial Developer of the Original Code is PaloSanto Solutions    |
  +----------------------------------------------------------------------+
  $Id: new_campaign.php $ */

require_once 'libs/misc.lib.php';
require_once 'libs/paloSantoForm.class.php';
require_once 'libs/paloSantoGrid.class.php';

define ('LIMITE_PAGINA', 50);

if (!function_exists('_tr')) {
    function _tr($s)
    {
        global $arrLang;
        return isset($arrLang[$s]) ? $arrLang[$s] : $s;
    }
}
if (!function_exists('load_language_module')) {
    function load_language_module($module_id, $ruta_base='')
    {
        $lang = get_language($ruta_base);
        include_once $ruta_base."modules/$module_id/lang/en.lang";
        $lang_file_module = $ruta_base."modules/$module_id/lang/$lang.lang";
        if ($lang != 'en' && file_exists("$lang_file_module")) {
            $arrLangEN = $arrLangModule;
            include_once "$lang_file_module";
            $arrLangModule = array_merge($arrLangEN, $arrLangModule);
        }

        global $arrLang;
        global $arrLangModule;
        $arrLang = array_merge($arrLang,$arrLangModule);
    }
}

function _moduleContent(&$smarty, $module_name){

    load_language_module($module_name);

    //include module files
    include_once "modules/$module_name/configs/default.conf.php";
    global $arrConf;

    // Se fusiona la configuración del módulo con la configuración global
    $arrConf = array_merge($arrConf, $arrConfModule);

    require_once "modules/$module_name/libs/paloSantoLoginLogout.class.php";

    //folder path for custom templates
    $base_dir = dirname($_SERVER['SCRIPT_FILENAME']);
    $templates_dir = (isset($arrConf['templates_dir']))?$arrConf['templates_dir']:'themes';
    $local_templates_dir = "$base_dir/modules/$module_name/".$templates_dir.'/'.$arrConf['theme'];


    $pDB = new paloDB($arrConf["cdr_dsn"]);
    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $smarty->assign('mb_message', _tr('Error when connecting to database')." ".$pDB->errMsg);
        return NULL;
    }

    return listadoIVRcategory($pDB, $smarty, $module_name, $local_templates_dir);
}

function listadoIVRCategory($pDB, $smarty, $module_name, $local_templates_dir){

    $oCalls = new paloSantoLoginLogout($pDB);
    $ivr_menus = $oCalls->ivr_menus();
    $smarty->assign(array(
        'SHOW'      =>  _tr('Show'),
        'Filter'    =>  _tr('Find'),
    ));
    
    $arrFormElements = array(
        'date_start'  => array(
         'LABEL'                  => _tr('Date Init'),
         'REQUIRED'               => 'yes',
         'INPUT_TYPE'             => 'DATE',
         'INPUT_EXTRA_PARAM'      => array("TIME" => true, "FORMAT" => "%d %b %Y %H:%M"),
         'VALIDATION_TYPE'        => 'ereg',
         'VALIDATION_EXTRA_PARAM' => '^[[:digit:]]{1,2}[[:space:]]+[[:alnum:]]{3}[[:space:]]+[[:digit:]]{4}[[:space:]]+[[:digit:]]{1,2}:[[:digit:]]{1,2}$'),
        'date_end'    => array(
            'LABEL'                  => _tr('Date End'),
            'REQUIRED'               => 'yes',
            'INPUT_TYPE'             => 'DATE',
            'INPUT_EXTRA_PARAM'      => array("TIME" => true, "FORMAT" => "%d %b %Y %H:%M"),
            'VALIDATION_TYPE'        => 'ereg',
            'VALIDATION_EXTRA_PARAM' => '^[[:digit:]]{1,2}[[:space:]]+[[:alnum:]]{3}[[:space:]]+[[:digit:]]{4}[[:space:]]+[[:digit:]]{1,2}:[[:digit:]]{1,2}$'),
        'ivr_menu'  => array(
            'LABEL'                  => _tr('IVR Menu'),
            'REQUIRED'               => 'no',
            'INPUT_TYPE'             => 'SELECT',
            'INPUT_EXTRA_PARAM'      => $ivr_menus,
            'VALIDATION_TYPE'        => 'text',
            'VALIDATION_EXTRA_PARAM' => ''),

        'report_type'  => array(
            'LABEL'                  => 'Report Type',
            'REQUIRED'               => 'no',
            'INPUT_TYPE'             => 'SELECT',
            'INPUT_EXTRA_PARAM'      => Array( 'Detailed' => 'Detailed',
						'Summary' => 'Summary'
					),
            'VALIDATION_TYPE'        => 'text',
            'VALIDATION_EXTRA_PARAM' => ''),
    );
    $oFilterForm = new paloForm($smarty, $arrFormElements);

    // Parámetros base y validación de parámetros
    $url = array('menu' => $module_name);
    $paramFiltroBase = $paramFiltro = array(
        'date_start'    =>  date('d M Y')." 00:00", 
        'date_end'      =>  date('d M Y')." 23:59",
	'ivr_menu'      =>  '',
	'report_type'   => 'Summary'
    );
    foreach (array_keys($paramFiltro) as $k) {
        if (!is_null(getParameter($k))){
            $paramFiltro[$k] = getParameter($k);
        }
    }
    $htmlFilter = $oFilterForm->fetchForm("$local_templates_dir/filter.tpl", "", $paramFiltro);
    if (!$oFilterForm->validateForm($paramFiltro)) {
        $smarty->assign(array(
            'mb_title'      =>  _tr('Validation Error'),
            'mb_message'    =>  '<b>'._tr('The following fields contain errors').':</b><br/>'.
                                implode(', ', array_keys($oFilterForm->arrErroresValidacion)),
        ));
        $paramFiltro = $paramFiltroBase;
    }

    // Tradudir fechas a formato ISO para comparación y para API de CDRs.
    $url = array_merge($url, $paramFiltro);
    $paramFiltro['date_start'] = date('Y-m-d H:i:s',strtotime($paramFiltro['date_start'].":00"));
    $paramFiltro['date_end']   = date('Y-m-d H:i:s',strtotime($paramFiltro['date_end'].":59"));

    if($paramFiltro['report_type'] == 'Detailed'){
    	$recordset = $oCalls->leerRegistrosIVRCategory($paramFiltro['ivr_menu'],
       					 $paramFiltro['date_start'], $paramFiltro['date_end']);
    }else
    	$recordset = $oCalls->leerRegistrosIVRCategorySummery($paramFiltro['ivr_menu'],
       					 $paramFiltro['date_start'], $paramFiltro['date_end']);
    
    if (!is_array($recordset)) {
        $smarty->assign(array(
            'mb_title'      =>  _tr('Query Error'),
            'mb_message'    =>  $oCalls->errMsg,
        ));
    	$recordset = array();
    }
    
    $oGrid = new paloSantoGrid($smarty);
    $bExportando = $oGrid->isExportAction();
    $oGrid->setLimit(LIMITE_PAGINA);
    $oGrid->setTotal(count($recordset));
    $offset = $oGrid->calculateOffset();

    // Formato del arreglo de datos a mostrar
    $arrData = array();
    $sTagInicio = (!$bExportando) ? '<b>' : '';
    $sTagFinal = ($sTagInicio != '') ? '</b>' : '';
    $recordSlice = $bExportando
        ? $recordset 
        : array_slice($recordset, $offset, LIMITE_PAGINA);

    $oGrid->enableExport();
    $oGrid->setURL($url);
    $oGrid->setData($recordSlice);
    
    if($paramFiltro['report_type'] == 'Detailed') 
	    $arrColumnas = array( 'Call id','Time Stamp','Caller ID','Menu','Data','More Details' );
    else
	    $arrColumnas = array( 'Menu','Count' );

    $oGrid->setColumns($arrColumnas);
    $oGrid->setTitle(_tr('IVR Category'));
    $oGrid->pagingShow(true);
    $oGrid->setNameFile_Export(_tr('IVR_Category'));

    $smarty->assign('modalClass','modal-lg');
    $smarty->assign('modalContent','<iframe id="celdetails" onLoad="celFrameLoaded();" src="" frameborder=0 width="100%" height="100px"></iframe>');

    $cel_code = "
        function showCel(uniqueid) {
            $('#celdetails').attr('src','index.php?menu=cdrreport&rawmode=yes&uniqueid='+uniqueid);
            $('#gridModal').modal();
            alto = parent.document.body.clientHeight - 150;
            $('#gridModal').css('maxHeight',alto);
            $('#gridModal').css('overflow','scroll');
        }

        function celFrameLoaded() {
            fh = $('#celdetails').contents().find('html').height();
            if(fh==0) {fh=100;}
            $('#celdetails').height(fh);
            $('#gridModal').find('.modal-body').css({
              height: fh,
            });
            $('.modal-dialog').css('top',$(window).scrollTop());
        }

        $('#gridModal').on('hidden.bs.modal', function () {
            $('#celdetails').attr('src','index.php?menu=cdrreport&rawmode=yes&loading=yes');
        })
        $('#gridModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    ";

    $smarty->assign('customJS',$cel_code);
    $htmlFilter.$smarty->fetch("$local_templates_dir/datatables.tpl"); 
    $oGrid->showFilter($htmlFilter);
    return $oGrid->fetchGrid();
}

function format_time($iSec){

    $iMin = ($iSec - ($iSec % 60)) / 60; $iSec %= 60;
    $iHora =  ($iMin - ($iMin % 60)) / 60; $iMin %= 60;
    return sprintf('%02d:%02d:%02d', $iHora, $iMin, $iSec);

}
?>
