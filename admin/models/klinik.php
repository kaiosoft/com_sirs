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

class SirsModelKlinik extends JModel{

	function getAllKlinik($pageNav){
		$sql = "SELECT * FROM #__sirs_klinik ORDER BY id";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}

	function getKlinikById($id){
		$sql = "SELECT * FROM #__sirs_klinik WHERE id='".$id."'";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function klinikList()
	{
		$sql = "SELECT * FROM #__sirs_klinik";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObjectList();
		
		return $res;
	}
	
	function getTotal()
	{
		$query = "SELECT COUNT(*) FROM #__sirs_klinik";
		$this->_db->setQuery( $query );
		$total = $this->_db->loadResult();
		return $total;
	}

}

?>