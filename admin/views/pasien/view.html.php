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

class SirsViewPasien extends JView
{

	function display($tpl = null)
	{
		// load model
		$app =& JFactory::getApplication();
		$modelPasien =& JModel::getInstance('pasien','SirsModel');
		
		$task = JRequest::getVar('task');
		$id = JRequest::getVar('cid');
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelPasien->getTotal();
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		if(!is_array($id)){
			$id = explode(" ",$id);
		}
		
		if($task=="pasien.edit" || $task=="pasien.add"){
			$pasien = $modelPasien->getPasienById($id[0]);
		} else {
			$pasien = $modelPasien->getAllPasien($pageNav);
		}
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		//$document->addStyleSheet('http://demo.siswaku.com/components/com_siswaku/assets/css/boards.css');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
				
		$data = array();
		$data['pasien'] = $pasien;
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
		if($task=="pasien.add" || $task=="pasien.edit"){
			JToolBarHelper::title(JText::_('COM_SIRS_PASIEN_ADD'));
			JToolBarHelper::save('pasien.save');
			JToolBarHelper::cancel('pasien.cancel');
		} else {
			JToolBarHelper::title(JText::_('COM_SIRS_PASIEN_MANAGER'),'pasien');
			JToolBarHelper::deleteList('', 'pasien.delete');
			JToolBarHelper::editList('pasien.edit');
			JToolBarHelper::addNew('pasien.add');
		}
	}
		
}	

?>
