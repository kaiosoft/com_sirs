<?php

 /*
 *	Sistem Informasi Rumah Sakit (SIRS) for Jomla 1.5.x
 *  Version : 1.0.0
 *	Copyright (C) Kaio Piranti Lunak
 *	Distributed under the terms of the GNU General Public License
 *	This software may be used without warrany provided and
 *  copyright statements are left intact.
 *
 *	Developer : Fatah Iskandar Akbar 
 *  Email : info@kaiogroup.com
 *	Date: Jan 2012
 */

defined('_JEXEC') or die;

// Access check.
/*if (!JFactory::getUser()->authorise('core.manage', 'com_sirs')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}*/

// Include dependancies
jimport('joomla.application.component.controller');
require_once( JPATH_COMPONENT.DS.'controller.php');
// Set the table directory
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sirs'.DS.'tables');

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sirs'.DS.'helpers'.DS.'function.php');


$controller = JRequest::getWord('c');

// Require specific controller if requested
if($controller==''){
	$controller = "jadwal";
}

$controller_path = strtolower($controller);
$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller_path.'.php';
require_once $path;

// Create the controller
$classname    = 'SirsController'.ucfirst($controller);
$controller   = new $classname( );

$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

?>