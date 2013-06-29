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

class SirsViewCp extends JView
{

	function display($tpl = null)
	{
		
		$document= &JFactory::getDocument();		
		//$document->addScript('http://demo.siswaku.com/components/com_siswaku/assets/js/jquery-1.7.1.js');
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
		$this->addToolbar();				
		parent::display($tpl);		
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('SISTEM INFROMASI RUMAH SAKIT'),'profesi.png');
		//JToolBarHelper::deleteList('', 'helloworlds.delete');
		//JToolBarHelper::editList('helloworld.edit');
		//JToolBarHelper::addNew('helloworld.add');
	}
}

?>
