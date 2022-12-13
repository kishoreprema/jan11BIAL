<?php
  /* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
  Codificación: UTF-8
  +----------------------------------------------------------------------+
  | Issabel version 4.0.0-54                                               |
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
  $Id: index.php,v 1.1 2010-12-02 08:12:41 Alberto Santos asantos.palosanto.com Exp $ */
//include issabel framework
require_once "libs/paloSantoForm.class.php";
require_once "libs/paloSantoDB.class.php";
require_once "libs/paloSantoGrid.class.php";
require_once "libs/misc.lib.php";

require_once "modules/agent_console/libs/issabel2.lib.php";

function _moduleContent(&$smarty, $module_name)
{  
    include_once "modules/$module_name/configs/default.conf.php";
    include_once "modules/$module_name/libs/paloSantoReportsBreak.class.php";

    global $arrConf;
    $arrConf = array_merge($arrConf,$arrConfModule);
    // Obtengo la ruta del template a utilizar para generar el filtro.
    $base_dir = dirname($_SERVER['SCRIPT_FILENAME']);
    $templates_dir=(isset($arrConf['templates_dir']))?$arrConf['templates_dir']:'themes';
    $local_templates_dir="$base_dir/modules/$module_name/".$templates_dir.'/'.$arrConf['theme'];

    load_language_module($module_name);

    // Abrir conexión a la base de datos
    $pDB = new paloDB($arrConf['dsn_conn_database']);
    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $smarty->assign("mb_title", _tr("Error"));
        $smarty->assign("mb_message", _tr("Error when connecting to database")." ".$pDB->errMsg);
        return NULL;
    }

    // Cadenas estáticas a asignar
    $smarty->assign(array(
        "btn_consultar" =>  _tr('query'),
        "module_name"   =>  $module_name,
    ));


    //actions
    $action = getAction();
    $content = "";

    switch($action){
        default:
            $content = reportReportsBreak($smarty, $module_name, $local_templates_dir, $pDB);
            break;
    }
    return $content;
}

function reportReportsBreak($smarty, $module_name, $local_templates_dir, &$pDB)
{
    // Obtener rango de fechas de consulta. Si no existe, se asume día de hoy
    $sFechaInicio = date('d M Y'). " 00:00";
    if (isset($_GET['txt_fecha_init'])) $sFechaInicio = $_GET['txt_fecha_init'];
    if (isset($_POST['txt_fecha_init'])) $sFechaInicio = $_POST['txt_fecha_init'];
    $sFechaFinal = date('d M Y')." 23:59";
    if (isset($_GET['txt_fecha_end'])) $sFechaFinal = $_GET['txt_fecha_end'];
    if (isset($_POST['txt_fecha_end'])) $sFechaFinal = $_POST['txt_fecha_end'];
    $agent = "";
    if (isset($_GET['agent'])) $agent = $_GET['agent'];
    if (isset($_POST['agent'])) $agent = $_POST['agent'];
     	
    $oReportsBreak = new paloSantoReportsBreak($pDB);

    $listaAgentes = $oReportsBreak->getAgents(); // Para llenar el select de agentes
    // Combo de agentes a partir de lista de agentes
    $comboAgentes = array('' => '('._tr('All Agents').')');
    foreach ($listaAgentes as $tuplaAgente) {
        if (!isset($comboAgentes[$tuplaAgente['number']])) {
            $sDesc = $tuplaAgente['number'].' - '.$tuplaAgente['name'];
            if ($tuplaAgente['estatus'] != 'A') $sDesc .= ' ('.$tuplaAgente['estatus'].')';
            $comboAgentes[$tuplaAgente['number']] = $sDesc;
        }
    }
    $arrFilterExtraVars = array(
        "txt_fecha_init"    => $sFechaInicio,
        "txt_fecha_end"     => $sFechaFinal,
	"agent" => $agent,
    );
    $arrFormElements = createFieldFilter($comboAgentes);
    $oFilterForm = new paloForm($smarty, $arrFormElements);
    
    // Validación de las fechas recogidas
    if (!$oFilterForm->validateForm($arrFilterExtraVars)) {
        $smarty->assign("mb_title", _tr("Validation Error"));
        $arrErrores=$oFilterForm->arrErroresValidacion;
        $strErrorMsg = '<b>'._tr('The following fields contain errors').'</b><br/>';
        foreach($arrErrores as $k => $v) {
            $strErrorMsg .= "$k, ";
        }
        $smarty->assign("mb_message", $strErrorMsg);
    }
    $htmlFilter = $oFilterForm->fetchForm("$local_templates_dir/filter.tpl", "", $arrFilterExtraVars);

    // Obtener fechas en formato yyyy-mm-dd
    $sFechaInicio = date('Y-m-d H:i:s',strtotime($sFechaInicio.":00"));
    $sFechaFinal   = date('Y-m-d H:i:s',strtotime($sFechaFinal.":59"));
 

    $oReportsBreak = new paloSantoReportsBreak($pDB);
    //begin grid parameters
    
    $bIssabelNuevo = method_exists('paloSantoGrid','setURL');

    $oGrid = new paloSantoGrid($smarty);
    $oGrid->enableExport();   // enable export.
    $oGrid->showFilter($htmlFilter);

    $arrColumnas = array(
        _tr('Agent Number'),
        _tr('Agent Name')
    );
    $bExportando = $bIssabelNuevo
        ? $oGrid->isExportAction()
        : ( (isset( $_GET['exportcsv'] ) && $_GET['exportcsv'] == 'yes') || 
            (isset( $_GET['exportspreadsheet'] ) && $_GET['exportspreadsheet'] == 'yes') || 
            (isset( $_GET['exportpdf'] ) && $_GET['exportpdf'] == 'yes')
          ) ;
    $datosBreaks = $oReportsBreak->getReportesBreak($sFechaInicio,$sFechaFinal,$agent);
    $mapa = array();    // Columna del break dado su ID
    $sTagInicio = (!$bExportando) ? '<b>' : '';
    $sTagFinal = ($sTagInicio != '') ? '</b>' : '';
    $filaTotales = array($sTagInicio._tr('Total').$sTagFinal, '');
    foreach ($datosBreaks['breaks'] as $idBreak => $sNombreBreak) {
        $mapa[$idBreak] = count($arrColumnas);
        $arrColumnas[] = $sNombreBreak;
        $filaTotales[] = 0; // Total de segundos usado por todos los agentes en este break
    }
    $mapa['TOTAL'] = count($arrColumnas);
    $filaTotales[] = 0; // Total de segundos usado por todos los agentes en todos los breaks
    $arrColumnas[] = _tr('Total');

    $arrData = array();
    foreach ($datosBreaks['reporte'] as $infoAgente) {
        $filaAgente = array(
            $infoAgente['numero_agente'],
            $infoAgente['nombre_agente'],
        );
        $iTotalAgente = 0;  // Total de segundos usados por agente en breaks

        // Valor inicial de todos los breaks es 0 segundos
        foreach (array_keys($datosBreaks['breaks']) as $idBreak) {
            $filaAgente[$mapa[$idBreak]] = '00:00:00';
        }
        
        // Asignar duración del break para este agente y break
        foreach ($infoAgente['breaks'] as $tuplaBreak) {
            $sTagInicio = (!$bExportando && $tuplaBreak['duracion'] > 0) ? '<font color="green">': '';
            $sTagFinal = ($sTagInicio != '') ? '</font>' : '';
            $filaAgente[$mapa[$tuplaBreak['id_break']]] = $sTagInicio.formatoSegundos($tuplaBreak['duracion']).$sTagFinal;
            $iTotalAgente += $tuplaBreak['duracion'];
            $filaTotales[$mapa[$tuplaBreak['id_break']]] += $tuplaBreak['duracion'];
            $filaTotales[$mapa['TOTAL']] += $tuplaBreak['duracion'];
        }

        // Total para todos los breaks de este agente
        $filaAgente[$mapa['TOTAL']] = formatoSegundos($iTotalAgente);

        $arrData[] = $filaAgente;
    }
    $sTagInicio = (!$bExportando) ? '<b>' : '';
    $sTagFinal = ($sTagInicio != '') ? '</b>' : '';
    foreach ($mapa as $iPos) $filaTotales[$iPos] = $sTagInicio.formatoSegundos($filaTotales[$iPos]).$sTagFinal;
    $arrData[] = $filaTotales;

    if ($bIssabelNuevo) {
        $oGrid->setURL(construirURL($arrFilterExtraVars));
        $oGrid->setData($arrData);
        $oGrid->setColumns($arrColumnas);
        $oGrid->setTitle(_tr("Reports Break"));
        $oGrid->pagingShow(false); 
        $oGrid->setNameFile_Export(_tr("Reports Break"));
     
        $smarty->assign("SHOW", _tr("Show"));
        return $oGrid->fetchGrid();
    } else {
        $url = construirURL($arrFilterExtraVars);
        $offset = 0;
        $total = count($datosBreaks['reporte']) + 1;
        $limit = $total;

        function _map_name($s) { return array('name' => $s); }
        $arrGrid = array("title"    =>  _tr('Reports Break'),
                "url"      => $url,
                "icon"     => "images/list.png",
                "width"    => "99%",
                "start"    => ($total==0) ? 0 : $offset + 1,
                "end"      => ($offset+$limit)<=$total ? $offset+$limit : $total,
                "total"    => $total,
                "columns"  => array_map('_map_name', $arrColumnas),
                );
        if (isset( $_GET['exportpdf'] ) && $_GET['exportpdf'] == 'yes' && method_exists($oGrid, 'fetchGridPDF'))
            return $oGrid->fetchGridPDF($arrGrid, $arrData);
        if (isset( $_GET['exportspreadsheet'] ) && $_GET['exportspreadsheet'] == 'yes' && method_exists($oGrid, 'fetchGridXLS'))
            return $oGrid->fetchGridXLS($arrGrid, $arrData);
        if ($bExportando) {
            $title = $sFechaInicio."-".$sFechaFinal;
            header("Cache-Control: private");
            header("Pragma: cache");
            header('Content-Type: text/csv; charset=utf-8; header=present');
            header("Content-disposition: attachment; filename=\"".$title.".csv\"");
        }
        if ($bExportando)
            return $oGrid->fetchGridCSV($arrGrid, $arrData);
        $sContenido = $oGrid->fetchGrid($arrGrid, $arrData);
        if (strpos($sContenido, '<form') === FALSE)
            $sContenido = "<form  method=\"POST\" style=\"margin-bottom:0;\" action=\"$url\">$sContenido</form>";
        return $sContenido;
    }
}


function createFieldFilter($comboAgentes)
{
    $arrFormElements = array
    (
        "txt_fecha_init"  => array
        (
            "LABEL"                     => _tr('Start Date'),
            "REQUIRED"                  => "yes",
            "INPUT_TYPE"                => "DATE",
            "INPUT_EXTRA_PARAM"         => array("TIME" => true, "FORMAT" => "%d %b %Y %H:%M"),
            "VALIDATION_TYPE"           => "ereg",
            "VALIDATION_EXTRA_PARAM"    => "^[[:digit:]]{1,2}[[:space:]]+[[:alnum:]]{3}[[:space:]]+[[:digit:]]{4}[[:space:]]+[[:digit:]]{1,2}:[[:digit:]]{1,2}$" 
        ),
        "txt_fecha_end"  => array
        (
            "LABEL"                     => _tr('End Date'),
            "REQUIRED"                  => "yes",
            "INPUT_TYPE"                => "DATE",
            "INPUT_EXTRA_PARAM"         => array("TIME" => true, "FORMAT" => "%d %b %Y %H:%M"),
            "VALIDATION_TYPE"           => "ereg",
            "VALIDATION_EXTRA_PARAM"    => "^[[:digit:]]{1,2}[[:space:]]+[[:alnum:]]{3}[[:space:]]+[[:digit:]]{4}[[:space:]]+[[:digit:]]{1,2}:[[:digit:]]{1,2}$" 
        ),
	  'agent'     =>  array(
            'LABEL'                     =>  _tr('No.Agent'),
            'REQUIRED'                  =>  'no',
            'INPUT_TYPE'                =>  'SELECT',
            'INPUT_EXTRA_PARAM'         =>  $comboAgentes,
            'VALIDATION_TYPE'           =>  'ereg',
            'VALIDATION_EXTRA_PARAM'    =>  '^[[:digit:]]+$',
            'ONCHANGE'                  =>  'submit();',
        ),
 
    );
    return $arrFormElements;
}


function getAction()
{
    return "report"; 
}

function formatoSegundos($iSeg)
{
    $iHora = $iMinutos = $iSegundos = 0;
    $iSegundos = $iSeg % 60; $iSeg = ($iSeg - $iSegundos) / 60;
    $iMinutos = $iSeg % 60; $iSeg = ($iSeg - $iMinutos) / 60;
    $iHora = $iSeg;
    return sprintf('%02d:%02d:%02d', $iHora, $iMinutos, $iSegundos);
}
?>
