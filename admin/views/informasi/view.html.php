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

class SirsViewInformasi extends JView
{

	function display($tpl = null)
	{
		$document =& JFactory::getDocument();
		$document->addStyleSheet('components/com_sirs/assets/css/style.css');
		$this->addToolbar();	
		?>
		Version Log : <br />
		Fitur Backend :<br />
		<ul>
		<li>Master data untuk Department, Klinik, Jabatan, Staff, Jadwal Dokter, Registrasi Pasien, Pasien</li>
		<li>Tambah, edit, hapus Master Data Sirs</li>
		<li>Pengelolaan Jadwal Dokter</li>
		<li>Pengelolaan data pasien terdaftar</li>
		</ul>
		<p></p>
		
		Fitur Frontend :<br />
		<ul>
		<li>Menampilkan Informasi Dokter</li>
		<li>Menampilkan jadwal praktek</li>
		<li>Registrasi pasien</li>
		<li>Pasien yang merupakan member dapat membooking jadwal dokter yang tersedia sesuai hari, dan periode dokter jaga</li>
		</ul><p></p>
		
		Version :<br />
		1.2 Beta<p></p>
		
        Release Date :<br />
        Juli 2012<p></p>
        
		<ul>
		<li>pengembangan dan penyelesaian bug</li>
		<li>penambahan fitur - fitur lain</li></ul>		
		<p></p>
		
		Copyright :<br />
		Kaio Piranti Lunak
		<p></p>
		
		Developer :<br />
		<ul>
		<li>Fatah Iskandar Akbar</li>
		</ul>
		<p></p>
		
		Email :<br />
		info@kaiogroup.com 
		<p></p>		
		
		Powered By :<a href="http://kaiogroup.com">Kaio Piranti Lunak</a>
		<?php
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
			JToolBarHelper::title(JText::_('Informasi Product'),'informasi.png');
	}
		
}	

?>
