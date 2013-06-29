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

class SirsViewDepartement extends JView
{

	function display($tpl = null)
	{
		// load model
		$app =& JFactory::getApplication();
		$modelDepartement =& JModel::getInstance('departement','SirsModel');
		
		$task = JRequest::getVar('task');
		$id = JRequest::getVar('cid');
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelDepartement->getTotal();
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		if(!is_array($id)){
			$id = explode(" ",$id);
		}
		
		if($task=="departement.edit" || $task=="departement.add"){
			$departement = $modelDepartement->getDepartementById($id[0]);
		} else {
			$departement = $modelDepartement->getAllDepartement($pageNav);
		}
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		//$document->addStyleSheet('http://demo.siswaku.com/components/com_siswaku/assets/css/boards.css');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
				
		$data = array();
		$data['departement'] = $departement;
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
		if($task=="departement.add" || $task=="departement.edit"){
			JToolBarHelper::title(JText::_('Add / Edit Departement'));
			JToolBarHelper::save('departement.save');
			JToolBarHelper::cancel('departement.cancel');
		} else {
			JToolBarHelper::title(JText::_('Departement'),'department.png');
			JToolBarHelper::deleteList('', 'departement.delete');
			JToolBarHelper::editList('departement.edit');
			JToolBarHelper::addNew('departement.add');
		}
	}
		
}	

?>
