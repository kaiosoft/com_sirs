<?php
	/**
	 *	Sistem Informasi Rumah Sakit (SIRS) for Jomla 1.5.x
	 *  Version : 1.0.0
	 *	Copyright (C) Kaio Piranti Lunak
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
	 *
	 *	Developer: Fatah Iskandar Akbar 
	 *  Email : info@kaiogroup.com
	 *	Date: Mei 2011
	**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

	class SirsControllerJadwal extends JController
	{
		function display()
		{
			JRequest::setVar('view', 'jadwal' );
			parent::display(); 
		}
	}


?>