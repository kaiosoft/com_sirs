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

class SirsViewProfesi extends JView
{

	function display($tpl = null)
	{
		// load model
		$app =& JFactory::getApplication();
		$modelProfesi =& JModel::getInstance('profesi','SirsModel');
		
		$task = JRequest::getVar('task');
		$id = JRequest::getVar('cid');
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelProfesi->getTotal();
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		if(!is_array($id)){
			$id = explode(" ",$id);
		}
		
		if($task=="profesi.edit" || $task=="profesi.add"){
			$profesi = $modelProfesi->getProfesiById($id[0]);
		} else {
			$profesi = $modelProfesi->getAllProfesi($pageNav);
		}
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		//$document->addStyleSheet('http://demo.siswaku.com/components/com_siswaku/assets/css/boards.css');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
				
		$data = array();
		$data['profesi'] = $profesi;
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
		if($task=="profesi.add" || $task=="profesi.edit"){
			JToolBarHelper::title(JText::_('COM_SIRS_PROFESI_ADD'));
			JToolBarHelper::save('profesi.save');
			JToolBarHelper::cancel('profesi.cancel');
		} else {
			JToolBarHelper::title(JText::_('COM_SIRS_PROFESI_MANAGER'),'profesi');
			JToolBarHelper::deleteList('', 'profesi.delete');
			JToolBarHelper::editList('profesi.edit');
			JToolBarHelper::addNew('profesi.add');
		}
	}
		
}	

?>
