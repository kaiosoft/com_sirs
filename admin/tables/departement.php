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
class TableDepartement extends JTable
{
	var $id			= null;
	var $kode 		= null;
	var $nama_dept	= null;
	var $checked_out = null;
	var $checked_out_time = null;

	function __construct( &$db )
	{
		parent::__construct( '#__sirs_departement', 'id', $db );
	}

}
?>
