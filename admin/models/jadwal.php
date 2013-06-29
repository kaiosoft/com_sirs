<?php

 /*
 *	Sistem Informasi Rumah Sakit (SIRS) for Jomla 1.7
 *  Version : 1.2
 *	Copyright (C) Kaio Piranti Lunak
 *	Distributed under the terms of the GNU General Public License
 *	This software may be used without warrany provided and
 *  copyright statements are left intact.
 *
 *	Developer : Fatah Iskandar Akbar 
 *  Email : info@kaiogroup.com
 *	Date: Jan 2012
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class SirsModelJadwal extends JModel{

	function getAllJadwal($filter,$pageNav){
		
		$dokterId = $this->dokterInJadwal($filter);
	
		$sql = "SELECT * FROM #__sirs_staff WHERE id IN (".implode($dokterId,",").") ORDER BY id";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function dokterInJadwal($filter)
	{
		$sql = "SELECT distinct dokter_id FROM #__sirs_jadwal ".$filter;
		$this->_db->setQuery($sql);
		$jadwal = $this->_db->loadObjectList();
		
		$dokterId = array();
		foreach($jadwal as $row)
		{
			$dokterId[] = $row->dokter_id;
		}
		
		return $dokterId;
	}

	function getJadwalById($id){
		$sql = "SELECT * FROM #__sirs_jadwal WHERE id='".$id."'";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function getTotal($filter)
	{
		$query = "SELECT count(distinct dokter_id) FROM #__sirs_jadwal ";
		$this->_db->setQuery( $query );
		$total = $this->_db->loadResult();
		return $total;
	}

}

?>