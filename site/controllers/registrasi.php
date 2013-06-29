<?php
 
	/**
	 *	Component Penduduk for Jomla 1.5.x
	 *  Version : 1.0.0
	 *	Copyright (C) Kaio Piranti Lunak
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
	 *
	 *	Developer : Fatah Iskandar Akbar 
	 *  Email : info@kaiogroup.com
	 *	Date: Juni 2011
	**/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class SirsControllerRegistrasi extends JController
{
	
	function display() {
		$app =& JFactory::getApplication();
		if(JRequest::getVar('task') == "Registered")
		{
			require_once('components/com_sirs/assets/recaptchalib.php');	  
  			$privatekey = "6LcDus0SAAAAAANDtMEi2tdln7ThIgA7fhN8n9q5";
  			$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

 		if (!$resp->is_valid) {
		// What happens when the CAPTCHA was entered incorrectly
		/*die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
			 "(reCAPTCHA said: " . $resp->error . ")");*/
			$app->redirect('index.php?option=com_sirs&c=Registrasi','Masukkan Kode Captcha dengan benar','error');
			 exit();
		  } else {
		// Your code here to handle a successful verification

		}
		
			// Check for request forgeries
			JRequest::checkToken() or jexit( 'Invalid Token' );
			
			$acl	=& JFactory::getACL();
			$me		= & JFactory::getUser();
			$db		=& JFactory::getDBO();
			
			// Create a new JUser object
			$user = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
			$row =& JTable::getInstance('pasien', 'Table');
			
			$post = JRequest::get('post');
			$post['name']	= JRequest::getVar('name', '', 'post', 'name');
			$post['nama']	= $post['name'];
			$post['username']	= JRequest::getVar('username', '', 'post', 'username');
			$post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
			$post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);

			
			$post['checked_out']	= '';
			$post['checked_out_time']	= '';
			
			$post['checked_out']	= '';
			$post['checked_out_time']	= '';
			
			if (!$user->bind($post))
			{
				$app->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
				$app->enqueueMessage($user->getError(), 'error');
				$app->redirect( 'index.php?option=com_sirs&c=Registrasi&Itemid=59', $user->getError() );
				//return false;
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
				$app->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
				$app->enqueueMessage($user->getError(), 'error');
				$app->redirect( 'index.php?option=com_sirs&c=Registrasi&Itemid=59', $user->getError() );
			}
			
			// get user id
			$sql = "SELECT id FROM #__users WHERE email='".$post['email']."' && username = '".$post['username']."'";
			$db->setQuery($sql);
			$post['user_id'] = $db->loadResult();
			
			$post['ttl'] = $_POST['tempat'].", ".$_POST['tgl'];
			

			//insert user_group
			$ESql = "INSERT INTO #__user_usergroup_map (`user_id`, `group_id`) VALUES ('".$post['user_id']."','2')";
			$db->setQuery($ESql);
			$RESql = $db->query();
	
			if (!$row->bind( $post )) {
				JError::raiseError(500, $row->getError() );
			}
	
			if ($row->store($post)) {
				$msg = JText::_( 'Pendafataran Telah Berhasil, Silakan Login Pada Form Login' );
			} else {
				$msg = JText::_( 'Ada kesalahan dalam melakukan pendafataran' );
			} 
					
			// Check the table in so it can be edited.... we are done with it anyway
			$row->checkin();
			$link = 'index.php';
			$app->redirect($link, $msg);
		}
		else
		{
			$user = JFactory::getUser();
			if($user->id != 0)
			{
				$app->redirect('index.php'.'Anda telah terdaftar');
			}
			else
			{
			JRequest::setVar('view', 'registrasi' );
			parent::display();
			}
		}
	}
	
}
?>