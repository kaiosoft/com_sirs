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

class SirsControllerReg extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
	}

	/**
	 * Display the list of Reg
	 */
	function display()
	{
		JRequest::setVar('view', 'reg' );
		
		$task = JRequest::getVar('task');
		JRequest::setVar('task',$task);
		
		switch($task){
			case "reg.add":
			case "reg.edit":
			JRequest::setVar('layout','add');
			break;
			
			case "reg.save":
			$this->save();
			break;
			
			case "reg.cancel":
			$this->cancel();
			break;
			
			case "reg.delete":
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

		$row =& JTable::getInstance('reg', 'Table');
		$post = JRequest::get('post');
		$id	= JRequest::getVar( 'id', array(0), 'post', 'array' );		
		echo $post['id'] = (int) $id[0];
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		if ($row->store($post)) {
			$msg = JText::_( 'Data reg Telah Di Simpan' );
		} else {
			$msg = JText::_( 'Ada Kesalahan Dalam Menyimpan Data' );
		} 
		
		// Check the table in so it can be edited.... we are done with it anyway
		$row->checkin();
		$link = 'index.php?option=com_sirs&c=reg';
		//$this->setRedirect($link, $msg); 
		
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sirs&c=reg', $msg );
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

		$q1 = 'SELECT * FROM #__sirs_reg_pasien WHERE id IN ('.$cid.') && status != "Confirmed"';
		$db->setQuery( $q1 );
		$result = $db->loadResult();
		if(empty($result))
		{
			$text = "Data Berstatus Confirmed tidak dapat dihapus";
		}
		

		$q = 'DELETE FROM #__sirs_reg_pasien WHERE id IN ('.$cid.') && status != "Confirmed"';
		$db->setQuery( $q );
	
		if (!$db->query()) {
			JError::raiseWarning( 500, $db->getError() );
		}

		if(empty($text))
		{
		$text = "Data telah di hapus";
		}
		$this->setMessage( JText::sprintf( $text, $n ) ); 
		$this->setRedirect( 'index.php?option=com_sirs&c=reg' ); 
		
	}
		
}

?>