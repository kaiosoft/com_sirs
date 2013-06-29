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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package		Joomla
 * @subpackage	SIRS
 */
class TableReg extends JTable
{
	var $id			= null;
	var $no_reg		= null;
	var $user_id	= null;
	var $dokter_id	= null;
	var $klinik_id	= null;
	var $booking	= null;
	var $tanggal	= null;
	var $status		= null;

	function __construct( &$db )
	{
		parent::__construct( '#__sirs_reg_pasien', 'id', $db );
	}

}
?>
