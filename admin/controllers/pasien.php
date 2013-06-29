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

class SirsControllerPasien extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
	}

	/**
	 * Display the list of Pasien
	 */
	function display()
	{
		JRequest::setVar('view', 'pasien' );
		
		$task = JRequest::getVar('task');
		JRequest::setVar('task',$task);
		$id = JRequest::getVar('id');
		
		switch($task){
			case "pasien.add":
			case "pasien.edit":
			JRequest::setVar('layout','add');
			break;
			
			case "pasien.save":
			$this->save();
			break;
			
			case "pasien.cancel":
			$this->cancel();
			break;
			
			case "pasien.delete":
			$this->remove();
			break;
			
			case "defaultpasien";
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
			global $mainframe;
			// Check for request forgeries
			JRequest::checkToken() or jexit( 'Invalid Token' );
			
			$row =& JTable::getInstance('pasien', 'Table');
			$post = JRequest::get('post');
			$db		=& JFactory::getDBO();
			
			if($post['id'] == 0)
			{
			
			$acl	=& JFactory::getACL();
			$me		= & JFactory::getUser();
			
			//Memeriksa pengisian ulang data yang sama (duplicate date)
			$ceksql = "SELECT * FROM #__users WHERE username='".$post['username']."' || email='".$post['email']."'";
			$db->setQuery($ceksql);
			$cekres = $db->loadResult();
				
			if(($post['id'] == 0) && (!empty($cekres)))
			{
				echo "<script>alert('Maaf Username / Email yang anda masukkan telah terdaftar gunakan username / email lain');history.back(-1);</script>";
				exit();
			}
			
			// Create a new JUser object
			$user = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
			
			$post['name']	= JRequest::getVar('nama', '', 'post', 'nama');
			$post['username']	= JRequest::getVar('username', '', 'post', 'username');
			$post['password']	= "123456";
			$post['password2']	= "123456";

			
			$post['checked_out']	= '';
			$post['checked_out_time']	= '';
			
			$post['checked_out']	= '';
			$post['checked_out_time']	= '';
			
			if (!$user->bind($post))
			{
				$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
				$mainframe->enqueueMessage($user->getError(), 'error');
				$mainframe->redirect( 'index.php?option=com_sirs&c=pasien&Itemid=59', $user->getError() );
				return false;
				//return $this->execute('edit');
			}
	
			// set group id
			$user->set('gid', 18);
			$user->set('sendEmail', 1);
			
			
	
			// Set the usertype based on the ACL group name
			
			/*
			 * Lets save the JUser object
			 */
			
			if (!$user->save())
			{
				$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
				$mainframe->enqueueMessage($user->getError(), 'error');
				$mainframe->redirect( 'index.php?option=com_sirs&c=pasien', $user->getError() );
			}
			
			// get user id
			$sql = "SELECT id FROM #__users WHERE email='".$post['email']."' && username = '".$post['username']."'";
			$db->setQuery($sql);
			$post['user_id'] = $db->loadResult();
			
			//insert user_group
			$ESql = "INSERT INTO #__user_usergroup_map (`user_id`, `group_id`) VALUES ('".$post['user_id']."','2')";
			$db->setQuery($ESql);
			$RESql = $db->query();
			
			}
			
			//update name to users	
			if($post['id'] != 0)
			{
				$updateName = "UPDATE #__users SET name='".$post['nama']."' WHERE id='".$post['user_id']."'";
				$db->setQuery($updateName);
				$db->query();
			}
			
			$post['ttl'] = $post['tempat'].", ".$post['tglLahir'];	
	
			if (!$row->bind( $post )) {
				JError::raiseError(500, $row->getError() );
			}
	
			if ($row->store($post)) {
				$msg = JText::_( 'Berhasil Menyimpan Data' );
			} else {
				$msg = JText::_( 'Ada kesalahan dalam melakukan pendafataran' );
			} 
			$row->checkin();
			$link = 'index.php?option=com_sirs&c=pasien';			
			$this->setRedirect($link, $msg); 
			
			
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sirs&c=pasien', $msg );
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
		
		$getUser = "SELECT a.id FROM #__users AS a LEFT JOIN #__sirs_pasien AS b ON (b.user_id=a.id) WHERE b.id IN (".$cid.")";
		$db->setQuery($getUser);
		$RgetUser = $db->loadObjectList();
		
		$deleteMember = "DELETE FROM #__sirs_pasien WHERE id IN (".$cid.")";
		$db->setQuery($deleteMember);
		$RdeleteMember = $db->query();
		
		if (!$RdeleteMember) {
			//JError::raiseWarning( 500, $db->getError() );
			$extMsg = "Maaf, terjadi kesalahan dalam penghapusan data";
		}
		
		$ids = array();
		foreach($RgetUser as $id)
		{
			$ids[] = $id->id;
			
		}
		
		$pilihan = implode(',',array_values($ids));
		$deleteUser = "DELETE FROM #__users WHERE id IN (".$pilihan.")";
		$db->setQuery( $deleteUser );
		$RdeleteUser = $db->query();
		
		$deleteUserMap = "DELETE FROM #__user_usergroup_map WHERE user_id IN (".$pilihan.")";
		$db->setQuery( $deleteUserMap );
		$RdeleteUserMap = $db->query();

		if(!empty($exMsg))
		{
			$text = $exMsg;
		}
		else
		{
			$text = "Data pasien telah di hapus";
		}
		$this->setMessage( JText::sprintf( $text, $n ) ); 
		$this->setRedirect( 'index.php?option=com_sirs&c=pasien' ); 
		
	}
		
}

?>