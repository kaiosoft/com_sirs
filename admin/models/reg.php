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

class SirsModelReg extends JModel{

	function getAllReg($filter,$pageNav){
		$sql = "SELECT a.*,b.name,c.nama,d.klinik 
				FROM #__sirs_reg_pasien AS a LEFT JOIN #__users AS b ON (b.id=a.user_id)
				LEFT JOIN #__sirs_staff AS c ON (c.id=a.dokter_id) LEFT JOIN #__sirs_klinik AS d 
				ON (d.id=a.klinik_id) ".$filter." ORDER BY a.booking desc";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}

	function getRegById($id){
		$sql = "SELECT * FROM #__sirs_reg_pasien WHERE id='".$id."'";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function userList()
	{
		$sql = "SELECT id,username,name FROM #__users";
		$this->_db->setQuery($sql);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function getTotal()
	{
		$query = "SELECT COUNT(*) FROM #__sirs_reg_pasien";
		$this->_db->setQuery( $query );
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function changeStatus($status)
	{
		foreach($status as $key => $val)
		{
		}
		
		echo $sql = "UPDATE #__sirs_reg_pasien SET status='".$val."' WHERE id='".$key."'";
		$this->_db->setQuery($sql);
		$res = $this->_db->query();
	}

}

?>