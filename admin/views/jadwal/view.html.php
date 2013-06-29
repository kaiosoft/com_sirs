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
jimport('joomla.application.component.view');

class SirsViewJadwal extends JView
{

	function display($tpl = null)
	{
		// load model
		$app =& JFactory::getApplication();
		$modelJadwal =& JModel::getInstance('jadwal','SirsModel');
		$modelStaff =& JModel::getInstance('staff','SirsModel');
		$modelKlinik =& JModel::getInstance('klinik','SirsModel');
		
		$helper = new sirsHelper;
		
		$klinik_id = JRequest::getVar('klinik_id');
		$dokter_id = JRequest::getVar('dokter_id');
		$hari	   = JRequest::getVar('hari');
		
		if($klinik_id == 0)
		{
			$klinik_id = "";
		}
		if($dokter_id == 0)
		{
			$dokter_id = "";
		}
		if($hari == 0)
		{
			$hari = "";
		}

		
		$filter = $helper->setFilter(array("klinik_id","dokter_id","hari"),array("='".$klinik_id."'","='".$dokter_id."'","='".$hari."'")); //filter
				
		$task = JRequest::getVar('task');
		$id = JRequest::getVar('cid');
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelJadwal->getTotal($filter);
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		if(!is_array($id)){
			$id = explode(" ",$id);
		}
		
		if($task=="jadwal.edit" || $task=="jadwal.add"){
			$jadwal = $modelJadwal->getJadwalById($id[0]);
		}
		else if($task=='editJadwal')
		{
			$jadwal = $modelJadwal->getJadwalById($id[0]);
		}
		else {
			$getJadwal = $modelJadwal->getAllJadwal($filter,$pageNav);
			
			if(!empty($getJadwal))
			{
			$jadwal = array();
			$stdJadwal = new stdClass;
			$stdJadwal = array();
			foreach($getJadwal as $row)
			{
				$getJadwal = $helper->getDataByParam("dokter_id","='".$row->id."'","#__sirs_jadwal","array");
			
				$start = array();
				$finish = array();
				$klinik = array();
				foreach($getJadwal as $jadwalDokter)
				{
					switch($jadwalDokter->hari)
					{
						case 1:
						$start[$i][1][] = $jadwalDokter->sjam;
						$finish[$i][1][] = $jadwalDokter->fjam;
						$klinik[$i][1][] = $jadwalDokter->klinik_id;
						$idJadwal[$i][1][] = $jadwalDokter->id;
						break;
						
						case 2:
						$start[$i][2][] = $jadwalDokter->sjam;
						$finish[$i][2][] = $jadwalDokter->fjam;
						$klinik[$i][2][] = $jadwalDokter->klinik_id;
						$idJadwal[$i][2][] = $jadwalDokter->id;
						break;
						
						case 3:
						$start[$i][3][] = $jadwalDokter->sjam;
						$finish[$i][3][] = $jadwalDokter->fjam;
						$klinik[$i][3][] = $jadwalDokter->klinik_id;
						$idJadwal[$i][3][] = $jadwalDokter->id;
						break;
						
						case 4:
						$start[$i][4][] = $jadwalDokter->sjam;
						$finish[$i][4][] = $jadwalDokter->fjam;
						$klinik[$i][4][] = $jadwalDokter->klinik_id;
						$idJadwal[$i][4][] = $jadwalDokter->id;
						break;
						
						case 5:
						$start[$i][5][] = $jadwalDokter->sjam;
						$finish[$i][5][] = $jadwalDokter->fjam;
						$klinik[$i][5][] = $jadwalDokter->klinik_id;
						$idJadwal[$i][5][] = $jadwalDokter->id;
						break;
						
						case 6:
						$start[$i][6][] = $jadwalDokter->sjam;
						$finish[$i][6][] = $jadwalDokter->fjam;
						$klinik[$i][6][] = $jadwalDokter->klinik_id;
						$idJadwal[$i][6][] = $jadwalDokter->id;
						break;
						
						default:
						$start[$i][7][] = $jadwalDokter->sjam;
						$finish[$i][7][] = $jadwalDokter->fjam;
						$klinik[$i][7][] = $jadwalDokter->klinik_id;
						$idJadwal[$i][7][] = $jadwalDokter->id;
						break;
					}
				}
				
				$stdJadwal[$i]->id = $row->id;
				$stdJadwal[$i]->nama = $row->nama;
				$stdJadwal[$i]->start = $start[$i];
				$stdJadwal[$i]->finish = $finish[$i];
				$stdJadwal[$i]->klinik = $klinik[$i];
				$stdJadwal[$i]->idJadwal = $idJadwal[$i];
				$jadwal[] = $stdJadwal[$i];
				$i++;
			}
			}
		
		}
		
		$staffList = $modelStaff->staffList();
		$klinikList = $modelKlinik->klinikList();
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		//$document->addStyleSheet('http://demo.siswaku.com/components/com_siswaku/assets/css/boards.css');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
		
		$getJadwal = 
				
		$data = array();
		$data['jadwal'] = $jadwal;
		$data['staffList'] = $staffList;
		$data['klinikList'] = $klinikList;
		$data['pageNav'] = $pageNav;
		
		$this->assignRef('data',$data);
		$this->addToolbar($task);	
		parent::display($tpl);
		
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar($task) 
	{
		if($task=="jadwal.add" || $task=="jadwal.edit" || $task == "editJadwal"){
			JToolBarHelper::title(JText::_('COM_SIRS_JADWAL_ADD'));
			JToolBarHelper::save('jadwal.save');
			JToolBarHelper::cancel('jadwal.cancel');
		} else {
			JToolBarHelper::title(JText::_('COM_SIRS_JADWAL_MANAGER'),'jadwal');
			JToolBarHelper::deleteList('', 'jadwal.delete');
			//JToolBarHelper::editList('jadwal.edit');
			JToolBarHelper::addNew('jadwal.add');
		}
	}
		
}	

?>
