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

class SirsModelJabatan extends JModel{

	function getAllJabatan($pageNav){
		$sql = "SELECT * FROM #__sirs_jabatan ORDER BY id";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}

	function getJabatanById($id){
		$sql = "SELECT * FROM #__sirs_jabatan WHERE id='".$id."'";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function getTotal()
	{
		$query = "SELECT COUNT(*) FROM #__sirs_jabatan";
		$this->_db->setQuery( $query );
		$total = $this->_db->loadResult();
		return $total;
	}

}

?>