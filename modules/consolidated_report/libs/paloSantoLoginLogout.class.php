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

    function paloSantoLoginLogout(&$pDB){
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

    function getSummery($sFechaInicio,$sFechaFin,$pDB_cdr){

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
	$sql = "SELECT count(distinct uniqueid) from asteriskcdrdb.cel
		WHERE  userdeftype='language_menu' AND eventtime BETWEEN '{$sFechaInicio}' AND '{$sFechaFin}'";
	$record = $pDB_cdr->getFirstRowQuery($sql);
	$total = (int)$record[0];

	$sql = "SELECT count(id) FROM call_entry
		WHERE datetime_entry_queue BETWEEN '{$sFechaInicio}' AND '{$sFechaFin}'";
	$record = $this->_DB->getFirstRowQuery($sql);
	$total_queue = (int)$record[0];
	
	$recordset[] = Array("Calls Received By Queue",$total_queue);
	$recordset[] = Array("Calls Finished At IVR",$total - $total_queue);
	$recordset[] = Array("Total Calls",$total);
	
	$sql = "SELECT status,count(id) FROM call_entry 
		WHERE datetime_entry_queue BETWEEN '{$sFechaInicio}' AND '{$sFechaFin}'
		GROUP BY status";
	$table = $this->_DB->fetchTable($sql);
	foreach($table as $in => $record)
		$recordset[] = Array($record[0],$record[1]);
		
	$sql = "SELECT SUBSTRING(SEC_TO_TIME(AVG(duration_wait)),1,8),SUBSTRING(SEC_TO_TIME(MAX(duration_wait)),1,8) FROM call_entry	
		WHERE datetime_entry_queue BETWEEN '{$sFechaInicio}' AND '{$sFechaFin}'";
	$record = $this->_DB->getFirstRowQuery($sql);
	$recordset[] = Array("Average Wait Duration",$record[0]);
	$recordset[] = Array("Maximum Wait Duration",$record[1]);

	$table["avg_wait"] = $record[1];
	$table["max_wait"] = $record[1];
	
	$sql = "SELECT SUBSTRING(SEC_TO_TIME(AVG(duration)),1,8) FROM call_entry	
		WHERE status='terminada' AND datetime_entry_queue  BETWEEN '{$sFechaInicio}' AND '{$sFechaFin}'";
	$record = $this->_DB->getFirstRowQuery($sql);
	$recordset[] = Array("Average Call Duration",$record[0]);

	return $recordset;

    }

}
?>
