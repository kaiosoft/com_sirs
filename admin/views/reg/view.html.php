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

class SirsViewReg extends JView
{
	public $statusDaftar,$idDaftar;

	function display($tpl = null)
	{
		// load model
		$app =& JFactory::getApplication();
		$modelReg =& JModel::getInstance('reg','SirsModel');
		$modelStaff =& JModel::getInstance('staff','SirsModel');
		$modelKlinik =& JModel::getInstance('klinik','SirsModel');
		
		$klinik_id = JRequest::getVar('klinik_id');
		$dokter_id = JRequest::getVar('dokter_id');
		$mulai = JRequest::getVar('mulai');
		$sampai = JRequest::getVar('sampai');
		$fstatus = JRequest::getVar('fstatus');
		
		
		$filter = "WHERE"; //filter
		if(!empty($klinik_id))
		{
		$filter .= " a.klinik_id = '".$klinik_id."'";
		}
		if(!empty($dokter_id))
		{
			if(strlen($filter) <= 7)
			{
			$filter .= " a.dokter_id = '".$dokter_id."'";
			}
			else
			{
			$filter .= " && a.dokter_id = '".$dokter_id."'";
			}
		}
		
		if($mulai == $sampai)
		{
			if(strlen($filter) <= 7)
			{
			$filter .= " a.booking like '%".$mulai."%'";
			}
			else
			{
			$filter .= " && a.booking like '%".$mulai."%'";	
			}
		}
		else
		{
		if(!empty($mulai))
		{
			if(strlen($filter) <= 7)
			{
			$filter .= " a.booking >= '".$mulai."'";
			}
			else
			{
			$filter .= " && a.booking >= '".$mulai."'";	
			}
		}
		
		if(!empty($sampai))
		{
			if(strlen($filter) <= 7)
			{
			$filter .= " a.booking <= '".$sampai."'";
			}
			else
			{
			$filter .= " && a.booking <= '".$sampai."'";	
			}
		}
		}
		
		if(!empty($fstatus))
		{
			if(strlen($filter) <= 7)
			{
			$filter .= " a.status = '".$fstatus."'";
			}
			else
			{
			$filter .= " && a.status = '".$fstatus."'";	
			}
		}
		
		if(strlen($filter) <= 7)
		{
			$filter = "";
		}
		
		$task = JRequest::getVar('task');
		$id = JRequest::getVar('cid');
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelReg->getTotal();
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		if(!is_array($id)){
			$id = explode(" ",$id);
		}
		
		if($task=="reg.edit" || $task=="reg.add"){
			$reg = $modelReg->getRegById($id[0]);
		} else {
			$reg = $modelReg->getAllReg($filter,$pageNav);
		}
		
		if(!empty($_POST['status']))
		{
			/*$status = array_filter($_POST['status']);
			$modelReg->changeStatus($status);
			header('location:index.php?option=com_sirs&c=reg');*/
			$this->statusDaftar = $_POST['status'];
			$this->updateStatus();
			
		}
		
		$staffList = $modelStaff->staffList();
		$klinikList = $modelKlinik->klinikList();
		$userList = $modelReg->userList();
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		//$document->addStyleSheet('http://demo.siswaku.com/components/com_siswaku/assets/css/boards.css');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
				
		$data = array();
		$data['reg'] = $reg;
		$data['staffList'] = $staffList;
		$data['klinikList'] = $klinikList;
		$data['userList'] = $userList;
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
		if($task=="reg.add" || $task=="reg.edit"){
			JToolBarHelper::title(JText::_('COM_SIRS_REG_ADD'));
			JToolBarHelper::save('reg.save');
			JToolBarHelper::cancel('reg.cancel');
		} else {
			JToolBarHelper::title(JText::_('COM_SIRS_REG_MANAGER'),'regpasien');
			JToolBarHelper::deleteList('', 'reg.delete');
			//JToolBarHelper::editList('reg.edit');
			//JToolBarHelper::addNew('reg.add');
		}
	}
	
	function updateStatus()
	{
		$app =& JFactory::getApplication();
		
		// Check for request forgeries
		//JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$db		=& JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(0), 'method', 'array' );
		$n		= count( $cid );  
		 
		if (count( $cid ) < 1) {
			echo "Pilih terlebih dulu data yang akan anda update";
			return false;
		}
		else if(count($cid) == 1)
		{
			if(array_sum($cid) == 0)
			{
			echo "Pilih terlebih dulu data yang akan anda update";
			return false;
			}
		}
		
		JArrayHelper::toInteger( $cid );

		$cid = implode(',', $cid);		
		$cekUser = 'SELECT * FROM #__sirs_reg_pasien WHERE id IN ('.$cid.') && status != "Confirmed"';
		$db->setQuery( $cekUser );
		$RcekUser = $db->loadResult();
		
		if(empty($RcekUser))
		{
			$text = "Data berstatus Confirmed tidak dapat di edit";
		}
		
		$q = 'UPDATE #__sirs_reg_pasien SET status="'.$this->statusDaftar.'" WHERE id IN ('.$cid.') && status != "Confirmed"';
		$db->setQuery( $q );
	
		if (!$db->query()) {
			$text = "Maaf terjadi kesalahan pada sistem";
			return false;		
		}
    
    $sql = "SELECT a.*,b.email from #__sirs_reg_pasien as a LEFT JOIN #__users as b ON b.id=a.user_id WHERE a.id IN (".$cid.") ";
    $db->setQuery($sql);
    $result = $db->loadObjectList();
    
    $mailer =& JFactory::getMailer();
    
    foreach($result as $res)
    {
    $sender = array('info@kaiogroup.com','RS Syarif Hidayatullah');
    $mailer->setSender($sender);
    $mailer->addRecipient($res->email);
    
    if($this->statusDaftar == "Reject")
	{
      $body = "Maaf Permintaan untuk berobat pada tanggal ".$res->booking." dengan nomer antrian ".$res->no_reg." di tolak karena sesuatu hal"."\n".
      "silakan lakukan pendaftaran kembali";
      break;
    
    //$body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
    $mailer->setSubject('Penindaklanjutan Permintaan Berobat');
    $mailer->setBody($body);
    
    //print_r($pasien);
    $send =& $mailer->Send();
    if ( $send !== true ) {
        $text ='Error sending email: ' . $send->message;
    } else {
        $text ='Mail sent';
    }
	}
    
    }
    	if(empty($text))
		{
		$text = "Status Telah Di Update";
		}
		//$app->message( JText::sprintf( $text, $n ) ); 
		$app->redirect( 'index.php?option=com_sirs&c=reg',$text ); 
	}
		
}	

?>
