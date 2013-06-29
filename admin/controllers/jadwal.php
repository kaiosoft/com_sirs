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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class SirsControllerJadwal extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
	}

	/**
	 * Display the list of Klinik
	 */
	function display()
	{
		JRequest::setVar('view', 'jadwal' );
		
		$task = JRequest::getVar('task');
		JRequest::setVar('task',$task);
		
		switch($task){
			case "jadwal.add":
			case "jadwal.edit":
			JRequest::setVar('layout','add');
			break;
			
			case "editJadwal":
			JRequest::setVar('layout','editjadwal');
			break;
			
			case "jadwal.save":
			$this->save();
			break;
			
			case "jadwal.cancel":
			$this->cancel();
			break;
			
			case "jadwal.delete":
			$this->remove();
			break;
			
			default:
			JRequest::setVar('layout','default');
			break;
		}
		
		parent::display(); 
	}

	/**
	 * Save method
	 */
	function save()
	{ 
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$row =& JTable::getInstance('jadwal', 'Table');
		$post = JRequest::get('post');
		$id	= JRequest::getVar( 'id', array(0), 'post', 'array' );		
		$post['id'] = (int) $id[0];
		$db =& JFactory::getDBO();
		
		//Memeriksa pengisian ulang data yang sama (duplicate date)
		$sql = "SELECT * FROM #__sirs_jadwal WHERE dokter_id='".$post['dokter_id']."' && hari='".$post['hari']."' && sjam='".$post['sjam']."' && fjam='".$post['fjam']."' && klinik_id='".$post['klinik_id']."'";
		$db->setQuery($sql);
		$res = $db->loadResult();
			
		if(($post['id'] == 0) && (!empty($res)))
		{
			echo "<script>alert('Maaf Data yang anda masukkan sudah terdapat di database');history.back(-1);</script>";
			exit();
		}
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		if ($row->store($post)) {
			$msg = JText::_( 'Data jadwal Telah Di Simpan' );
		} else {
			$msg = JText::_( 'Ada Kesalahan Dalam Menyimpan Data' );
		} 
		
		// Check the table in so it can be edited.... we are done with it anyway
		$row->checkin();
		$link = 'index.php?option=com_sirs&c=jadwal';
		$this->setRedirect($link, $msg); 
		
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sirs&c=jadwal', $msg );
	}

	function remove()
	{
		error_reporting(0);
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(0), 'method', 'array' );
		$type 	= JRequest::getVar('type');
		$app 	= JFactory::getApplication();
		$n		= count( $cid ); 
		 
		if (count( $cid ) < 1) {
			$text = "Pilih data yang ingin dihapus terlebih dulu";
			if($type != "ajax")
			{
				$app->redirect( 'index.php?option=com_sirs&c=jadwal',$text,"error" ); 
			}
		}
		
		JArrayHelper::toInteger( $cid );

		$cid = implode(',', $cid);		
		if($type != "ajax")
		{
		$q = 'DELETE FROM #__sirs_jadwal WHERE dokter_id IN ('.$cid.')';
		}
		else
		{
		$q = 'DELETE FROM #__sirs_jadwal WHERE id IN ('.$cid.')';
		}
		$db->setQuery( $q );
	
		if (!$db->query()) {
			$text = "Gagal menghapus data";
			$mode = "error";
		}

		$text = "jadwal telah di hapus";
		if($type != "ajax")
		{
			$app->redirect( 'index.php?option=com_sirs&c=jadwal',$text,$mode ); 
		}
		else 
		{
			echo $text;
			break;
		}
		
	}
		
}

?>