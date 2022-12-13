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


    $pDB = new paloDB($arrConf["cadena_dsn"]);
    $pDB_cdr = new paloDB($arrConf["cdr_dsn"]);
    if (!is_object($pDB_cdr->conn) || $pDB->errMsg!="") {
        $smarty->assign('mb_message', _tr('Error when connecting to database')." ".$pDB->errMsg);
        return NULL;
    }
 
    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $smarty->assign('mb_message', _tr('Error when connecting to database')." ".$pDB->errMsg);
        return NULL;
    }

    return listadoIVRcategory($pDB,$pDB_cdr, $smarty, $module_name, $local_templates_dir);
}

function listadoIVRCategory($pDB,$pDB_cdr, $smarty, $module_name, $local_templates_dir){

    $oCalls = new paloSantoLoginLogout($pDB);
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
	'date_ranges'     =>  array(
       	  'LABEL'                     =>  _tr('Date Range'),
       	  'REQUIRED'                  =>  'no',
       	  'INPUT_TYPE'                =>  'SELECT',
       	  'INPUT_EXTRA_PARAM'         =>  Array( "" => "",'last_7_days' => 'Last 7 Days','last_30_days' => 'Last 30 Days' ),
       	  'VALIDATION_TYPE'           =>  'text',
       	  'ONCHANGE'                  =>  'submit();',
        ),
 
		
    );

    $oFilterForm = new paloForm($smarty, $arrFormElements);

    //echo date('Y-m-d', strtotime('-7 days'))
 
    // Parámetros base y validación de parámetros
    $url = array('menu' => $module_name);
    $paramFiltroBase = $paramFiltro = array(
        'date_start'    =>  date('d M Y')." 00:00", 
        'date_end'      =>  date('d M Y')." 23:59",
	'date_ranges'   =>  ''
    );
    foreach (array_keys($paramFiltro) as $k) {
        if (!is_null(getParameter($k))){
            $paramFiltro[$k] = getParameter($k);
        }
    }
    switch($paramFiltro['date_ranges']){
	case 'last_7_days':
			   $paramFiltro['date_start'] = date('d M Y 00:00', strtotime('-7 days'));
			   $paramFiltro['date_end'] = date('d M Y 23:59', strtotime('-1 days'));
			   break;
	case 'last_30_days':
			   $paramFiltro['date_start'] = date('d M Y 00:00', strtotime('-30 days'));
			   $paramFiltro['date_end'] = date('d M Y 23:59', strtotime('-1 days'));
			   break;
			    
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
    $date_start = date('Y-m-d H:i:s',strtotime($paramFiltro['date_start'].":00"));
    $date_end   = date('Y-m-d H:i:s',strtotime($paramFiltro['date_end'].":59"));

     $recordset = $oCalls->getSummery($date_start,$date_end,$pDB_cdr);
    
    if (!is_array($recordset)) {
        $smarty->assign(array(
            'mb_title'      =>  _tr('Query Error'),
            'mb_message'    =>  $oCalls->errMsg,
        ));
    	$recordset = array();
    }
    $total = 0;
     $mapaEstados = array(
                    'abandonada'    =>  _tr('Abandoned'),
                    'Abandoned'     =>  _tr('Abandoned'),
                    'terminada'     =>  _tr('Success'),
                    'Success'       =>  _tr('Success'),
                    'Activa'        =>  _tr('LiveCall'),
                    'fin-monitoreo' =>  _tr('End Monitor'),
                    'Failure'       =>  _tr('Failure'),
                    'NoAnswer'      =>  _tr('NoAnswer'),
                    'OnQueue'       =>  _tr('OnQueue'),
                    'Placing'       =>  _tr('Placing'),
                    'Ringing'       =>  _tr('Ringing'),
                    'ShortCall'     =>  _tr('ShortCall'),
                );
 
    foreach($recordset as $in => $record){
	$sdate = urlencode($paramFiltro['date_start']);
	$edate = urlencode($paramFiltro['date_end']);
	$trans = isset($mapaEstados[$record[0]]) ? $mapaEstados[$record[0]]:$record[0];
    	$recordset[$in][0] = ($bExportando)? "<a target='_blank' href=index.php?menu=calls_detail&date_start={$sdate}&date_end={$edate}&call_type={$record[0]}>{$trans}</a>":$trans;
	$total += $record[1];
	
    }
    $oGrid = new paloSantoGrid($smarty);
    $bExportando = $oGrid->isExportAction();
    $oGrid->setLimit(LIMITE_PAGINA);
    $oGrid->setTotal(count($recordset));
    $offset = $oGrid->calculateOffset();

    // Formato del arreglo de datos a mostrar
    $arrData = array();
    $sTagInicio = (!$bExportando) ? "<b>" : '';
    $sTagFinal = ($sTagInicio != '') ? "</b>" : '';
    $recordSlice = $bExportando
        ? $recordset 
        : array_slice($recordset, $offset, LIMITE_PAGINA);

    $oGrid->enableExport();
    $oGrid->setURL($url);
    $oGrid->setData($recordSlice);
    
    $arrColumnas = array( 'Call Type','Count' );

    $oGrid->setColumns($arrColumnas);
    $oGrid->setTitle(_tr('Consolidated Report'));
    $oGrid->pagingShow(true);
    $oGrid->setNameFile_Export(_tr('Consolidated Report'));
    $oGrid->showFilter($htmlFilter);
    return $oGrid->fetchGrid();
}

function format_time($iSec){

    $iMin = ($iSec - ($iSec % 60)) / 60; $iSec %= 60;
    $iHora =  ($iMin - ($iMin % 60)) / 60; $iMin %= 60;
    return sprintf('%02d:%02d:%02d', $iHora, $iMin, $iSec);

}
?>
