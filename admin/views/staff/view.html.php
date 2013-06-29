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

class SirsViewStaff extends JView
{

	function display($tpl = null)
	{
		// load model
		$app =& JFactory::getApplication();
		$modelStaff =& JModel::getInstance('staff','SirsModel');
		
		$task = JRequest::getVar('task');
		$id = JRequest::getVar('cid');
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelStaff->getTotal();
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		if(!is_array($id)){
			$id = explode(" ",$id);
		}
		
		if($task=="staff.edit" || $task=="staff.add"){
			$staff = $modelStaff->getStaffById($id[0]);
		} else {
			$staff = $modelStaff->getAllStaff($pageNav);
		}
		
		$deptList = $modelStaff->deptList();
		$jabatanList = $modelStaff->jabatanList();
		$profesiList = $modelStaff->profesiList();
		
		$list = array();
		$list['deptList'] = $deptList;
		$list['jabatanList'] = $jabatanList;
		$list['profesiLIst'] = $profesiList;
		
		JRequest::setVar('list',$list);
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		//$document->addStyleSheet('http://demo.siswaku.com/components/com_siswaku/assets/css/boards.css');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');		
				
		$data = array();
		$data['staff'] = $staff;
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
		if($task=="staff.add" || $task=="staff.edit"){
			JToolBarHelper::title(JText::_('COM_SIRS_STAFF_ADD'));
			JToolBarHelper::save('staff.save');
			JToolBarHelper::cancel('staff.cancel');
		} else {
			JToolBarHelper::title(JText::_('COM_SIRS_STAFF_MANAGER'),'staff.png');
			JToolBarHelper::deleteList('', 'staff.delete');
			JToolBarHelper::editList('staff.edit');
			JToolBarHelper::addNew('staff.add');
		}
	}
		
}	

?>
