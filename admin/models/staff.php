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

class SirsModelStaff extends JModel{

	function getAllStaff($pageNav){
		$sql = "SELECT a.*,b.nama_dept,c.jabatan,d.profesi FROM #__sirs_staff AS a 
		LEFT JOIN #__sirs_departement AS b ON (b.id=a.dept_id) 
		LEFT JOIN #__sirs_jabatan AS c ON (c.id=a.jabatan_id)
		LEFT JOIN #__sirs_profesi AS d ON (d.id=a.profesi_id) ORDER BY id";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}

	function getStaffById($id){
		$sql = "SELECT * FROM #__sirs_staff WHERE id='".$id."'";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function deptList()
	{
		$sql = "SELECT * FROM #__sirs_departement";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObjectList();	
		
		return $res;
	}
	
	function jabatanList()
	{
		$sql = "SELECT * FROM #__sirs_jabatan";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObjectList();	
		
		return $res;
	}
	
	function profesiList()
	{
		$sql = "SELECT * FROM #__sirs_profesi";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObjectList();	
		
		return $res;
	}
	
	function staffList()
	{
		$sql = "SELECT * FROM #__sirs_staff";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObjectList();
		
		return $res;
	}
	
	function getTotal()
	{
		$query = "SELECT COUNT(*) FROM #__sirs_staff";
		$this->_db->setQuery( $query );
		$total = $this->_db->loadResult();
		return $total;
	}

}

?>