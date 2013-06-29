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

class SirsViewKlinik extends JView
{

	function display($tpl = null)
	{
		// load model
		$app =& JFactory::getApplication();
		$modelKlinik =& JModel::getInstance('klinik','SirsModel');
		
		$task = JRequest::getVar('task');
		$id = JRequest::getVar('cid');
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelKlinik->getTotal();
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		if(!is_array($id)){
			$id = explode(" ",$id);
		}
		
		if($task=="klinik.edit" || $task=="klinik.add"){
			$klinik = $modelKlinik->getKlinikById($id[0]);
		} else {
			$klinik = $modelKlinik->getAllKlinik($pageNav);
		}
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		//$document->addStyleSheet('http://demo.siswaku.com/components/com_siswaku/assets/css/boards.css');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
				
		$data = array();
		$data['klinik'] = $klinik;
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
		if($task=="klinik.add" || $task=="klinik.edit"){
			JToolBarHelper::title(JText::_('COM_SIRS_KLINIK_ADD'));
			JToolBarHelper::save('klinik.save');
			JToolBarHelper::cancel('klinik.cancel');
		} else {
			JToolBarHelper::title(JText::_('COM_SIRS_KLINIK_MANAGER'),'klinik.png');
			JToolBarHelper::deleteList('', 'klinik.delete');
			JToolBarHelper::editList('klinik.edit');
			JToolBarHelper::addNew('klinik.add');
		}
	}
		
}	

?>
