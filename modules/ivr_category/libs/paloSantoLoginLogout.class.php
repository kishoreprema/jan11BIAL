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

require_once('libs/paloSantoDB.class.php');

class paloSantoLoginLogout {

    private $_DB; // instancia de la clase paloDB
    var $errMsg;

    function paloSantoLoginLogout(&$pDB)
    {
        // Se recibe como parámetro una referencia a una conexión paloDB
        if (is_object($pDB)) {
            $this->_DB =& $pDB;
            $this->errMsg = $this->_DB->errMsg;
        } else {
            $dsn = (string)$pDB;
            $this->_DB = new paloDB($dsn);

            if (!$this->_DB->connStatus) {
                $this->errMsg = $this->_DB->errMsg;
                // debo llenar alguna variable de error
            } else {
                // debo llenar alguna variable de error
            }
        }
    }

    function ivr_menus(){

	$ivr_menus = Array("" => "");
	$sql = "SELECT distinct eventtype FROM cel order by eventtype";
	$records  = $this->_DB->fetchTable($sql);
            foreach($records as $key => $record)
                    $ivr_menus[$record[0]] =  $record[0];
        return $ivr_menus;

    }
    
    function leerRegistrosIVRCategory($sMenu, $sFechaInicio, $sFechaFin){

	$cond = "";
        $sRegexp = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
        if (!preg_match($sRegexp, $sFechaInicio)) {
            $this->errMsg = _tr('(internal) Invalid start date, must be yyyy-mm-dd hh:mm:ss');
        	return NULL;
        }
        if (!preg_match($sRegexp, $sFechaFin)) {
            $this->errMsg = _tr('(internal) Invalid end date, must be yyyy-mm-dd hh:mm:ss');
            return NULL;
        }
	if(isset($sMenu) and !empty($sMenu))
		$cond = "AND eventtype='{$sMenu}'";

    	$sql = <<<SQL_REGISTROS
		SELECT uniqueid,eventtime,cid_num,userdeftype,appdata From cel 
		WHERE userdeftype != "" and eventtime between '{$sFechaInicio}' and '{$sFechaFin}'
		     {$cond}
		ORDER BY uniqueid,eventtime desc 
SQL_REGISTROS;

        $recordset = $this->_DB->fetchTable($sql);

	foreach($recordset as $in => $record)
	 $recordset[$in][] = '<a onclick="showCel(\''.$record[0].'\')"> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> </a>';

        if (!is_array($recordset)) {
            $this->errMsg = $this->_DB->errMsg;
        	return NULL;
        }
	return $recordset;

    }
    function leerRegistrosIVRCategorySummery($sMenu, $sFechaInicio, $sFechaFin){

	     $cond = "";
       	     $sRegexp = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
       	     if (!preg_match($sRegexp, $sFechaInicio)) {
       	         $this->errMsg = _tr('(internal) Invalid start date, must be yyyy-mm-dd hh:mm:ss');
       	             return NULL;
       	     }
       	     if (!preg_match($sRegexp, $sFechaFin)) {
       	         $this->errMsg = _tr('(internal) Invalid end date, must be yyyy-mm-dd hh:mm:ss');
       	         return NULL;
       	     }
       	     if(isset($sMenu) and !empty($sMenu))
       	             $cond = "AND eventtype='{$sMenu}'";  

	     $sql = "SELECT userdeftype,count(userdeftype) FROM cel
		     WHERE userdeftype != '' and eventtime between '{$sFechaInicio}' and '{$sFechaFin}'
                     {$cond}
		     GROUP BY userdeftype";
             $recordset = $this->_DB->fetchTable($sql);
             if (!is_array($recordset)) {
                 $this->errMsg = $this->_DB->errMsg;
             	return NULL;
             }
	     return $recordset;

    }

}
?>
