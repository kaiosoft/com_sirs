<?php
	/**
	 *	Sistem Informasi Rumah Sakit (SIRS) for Jomla 1.5.x
	 *  Version : 1.0.0
	 *	Copyright (C) Kaio Piranti Lunak
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
	 *
	 *	Developer: Fatah Iskandar Akbar 
	 *  Email : info@kaiogroup.com
	 *	Date: Mei 2011
	**/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class SirsModelJadwal extends JModel
{
	function getAllDokter($filter,$pageNav)
	{
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
	
	function getAllJadwal($filter){
		$sql = "SELECT a.*,b.nama,b.profesi_id,c.klinik,d.title FROM #__sirs_jadwal AS a 
		LEFT JOIN #__sirs_staff AS b ON (b.id=a.dokter_id)
		LEFT JOIN #__sirs_klinik AS c ON (c.id=a.klinik_id) 
		LEFT JOIN #__sirs_profesi AS d ON (d.id=b.profesi_id) ".$filter." ORDER BY a.id";
		$this->_db->setQuery($sql, $pageNav->limitstart, $pageNav->limit);
		$rows = $this->_db->loadObjectList();
		return $rows;
	}
	
	function getJadwalByDokter($dokter_id){
		$sql = "SELECT a.*,b.klinik FROM #__sirs_jadwal AS a 
		LEFT JOIN #__sirs_klinik AS b ON (b.id=a.klinik_id) WHERE a.dokter_id = '".$dokter_id."' ORDER BY a.hari";
		$this->_db->setQuery($sql);
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

	function staffList()
	{
		$sql = "SELECT * FROM #__sirs_staff";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObjectList();
		
		return $res;
	}
	
	function store($post)
	{
		$row =& JTable::getInstance('reg', 'Table');
		$id	= JRequest::getVar( 'id', array(0), 'post', 'array' );		
		$post['id'] = (int) $id[0];
		
		$sql = "SELECT * FROM #__sirs_reg_pasien WHERE user_id='".$post['user_id']."' && status ='Pending'";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadResult();
		
		if($res >= 1)
		{
			return $msg = "Maaf Anda tidak dapat memboking dokter lain secara bersamaan, atau jika anda ingin memboking dokter lain silakan batalkan booking anda sebelumnya baru anda dapat memboking dokter lain";
		}
		else
		{
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		if ($row->store($post)) {
			$msg = JText::_( 'Data staff Telah Di Simpan' );
		} else {
			$msg = JText::_( 'Ada Kesalahan Dalam Menyimpan Data' );
		} 
		
		// Check the table in so it can be edited.... we are done with it anyway
		$row->checkin();
		}
	}
	
	
	function getDefaultKlinik()
	{
		$sql = "SELECT * FROM #__sirs_klinik WHERE status = '1'";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObject();
		
		return $res;
	}
	
	function cekBooking($user_id)
	{
		$sql = "SELECT a.*,b.nama,c.klinik FROM #__sirs_reg_pasien AS a LEFT JOIN #__sirs_staff AS b ON(b.id=a.dokter_id)
				LEFT JOIN #__sirs_klinik AS c ON (c.id=a.klinik_id) WHERE a.user_id = '".$user_id."' && a.status != 'canceled' && a.status != 'confirmed' ORDER BY id DESC";
		$this->_db->setQuery($sql);
		$res = $this->_db->loadObjectList();
		
		return $res;
	}
	
	function cancelBooking($id)
	{
		$sql = "UPDATE #__sirs_reg_pasien SET status='canceled' WHERE id='".$id."'";
		$this->_db->setQuery($sql);
		$res = $this->_db->query();
	}
	
	function removeBooking($id)
	{
		echo $sql = "DELETE FROM #__sirs_reg_pasien WHERE id='".$id."'";
		$this->_db->setQuery($sql);
		$res = $this->_db->query();
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