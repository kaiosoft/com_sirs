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

class SirsControllerKlinik extends JController
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
		JRequest::setVar('view', 'klinik' );
		
		$task = JRequest::getVar('task');
		JRequest::setVar('task',$task);
		$id = JRequest::getVar('id');
		
		switch($task){
			case "klinik.add":
			case "klinik.edit":
			JRequest::setVar('layout','add');
			break;
			
			case "klinik.save":
			$this->save();
			break;
			
			case "klinik.cancel":
			$this->cancel();
			break;
			
			case "klinik.delete":
			$this->remove();
			break;
			
			case "defaultKlinik";
			$this->makeDefault($id);
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

		$row =& JTable::getInstance('klinik', 'Table');
		$post = JRequest::get('post');
		$id	= JRequest::getVar( 'id', array(0), 'post', 'array' );		
		$post['id'] = (int) $id[0];
		$db =& JFactory::getDBO();

		//Memeriksa pengisian ulang data yang sama (duplicate date)
		$sql = "SELECT * FROM #__sirs_klinik WHERE klinik='".$post['klinik']."'";
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
			$msg = JText::_( 'Data Klinik Telah Di Simpan' );
		} else {
			$msg = JText::_( 'Ada Kesalahan Dalam Menyimpan Data' );
		} 
		
		// Check the table in so it can be edited.... we are done with it anyway
		$row->checkin();
		$link = 'index.php?option=com_sirs&c=klinik';
		$this->setRedirect($link, $msg); 
		
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sirs&c=klinik', $msg );
	}

	function remove()
	{
		global $mainframe;
		
		// Check for request forgeries
		//JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(0), 'method', 'array' );
		$n		= count( $cid ); 
		 
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a section to delete', true ) );
		}
		
		JArrayHelper::toInteger( $cid );

		$cid = implode(',', $cid);		
		$q = 'DELETE FROM #__sirs_klinik WHERE id IN ('.$cid.')';
		$db->setQuery( $q );
	
		if (!$db->query()) {
			JError::raiseWarning( 500, $db->getError() );
		}

		$text = "Klinik telah di hapus";
		$this->setMessage( JText::sprintf( $text, $n ) ); 
		$this->setRedirect( 'index.php?option=com_sirs&c=klinik' ); 
		
	}
	
	function makeDefault($id)
	{
		$db	=& JFactory::getDBO();
		
		$sql = "UPDATE #__sirs_klinik SET status='0' WHERE status='1'";
		$db->setQuery($sql);
		$res = $db->query();
		
		$sql2 = "UPDATE #__sirs_klinik SET status='1' WHERE id='".$id."'";
		$db->setQuery($sql2);
		$res2 = $db->query();
	}
		
}

?>