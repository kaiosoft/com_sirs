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
 

defined('_JEXEC') or die;
$lists = array();
	$statuslist[]		= JHTML::_('select.option',  '', JText::_( 'Status' ), 'status', 'value' );
	$statuslist[]		= JHTML::_('select.option',  'Pending', JText::_( 'Pending' ), 'status', 'value' );
	$statuslist[]		= JHTML::_('select.option',  'Confirmed', JText::_( 'Confirmed' ), 'status', 'value' );
	$statuslist[]		= JHTML::_('select.option',  'Reject', JText::_( 'Reject' ), 'status', 'value' );	
	$lists['status']	= JHTML::_('select.genericlist', $statuslist, 'status', 'class="inputbox" size="1"', 'status', 'value',$this->data['reg'][0]->status);	
	
	$kliniklist[]		= JHTML::_('select.option',  '0', JText::_( 'Nama klinik' ), 'id', 'klinik' );
	$kliniklist			= array_merge( $kliniklist, $this->data['klinikList']);
	$lists['klinik']		= JHTML::_('select.genericlist', $kliniklist, 'klinik_id', '" class="inputbox" size="1"', 'id', 'klinik',$this->data['reg'][0]->klinik_id);
	
	$stafflist[]		= JHTML::_('select.option',  '0', JText::_( 'Nama Dokter' ), 'id', 'nama' );
	$stafflist			= array_merge( $stafflist, $this->data['staffList']);
	$lists['dokter']		= JHTML::_('select.genericlist', $stafflist, 'dokter_id', 'class="inputbox" size="1"', 'id', 'nama',$this->data['reg'][0]->dokter_id);
	
	$userlist[]		= JHTML::_('select.option',  '0', JText::_( 'Nama Member' ), 'id', 'name' );
	$userlist			= array_merge( $userlist, $this->data['userList']);
	$lists['user']		= JHTML::_('select.genericlist', $userlist, 'user_id', 'class="inputbox" size="1"', 'id', 'name',$this->data['reg'][0]->user_id);
?>

<form action="index.php" method="post" name="adminForm">
  <table width="100%" border="0" cellpadding="4" cellspacing="1" class="admintable">
    <tr>
      <td width="18%" align="right" class="key">Nomer registrasi * : </td>
      <td width="82%"><input name="no_reg" type="text" id="reg" value="<?php echo $this->data['reg'][0]->no_reg; ?>" size="30"/></td>
    </tr>
	  <tr>
      <td width="18%" align="right" class="key">User_id * : </td>
      <td width="82%"><?php echo $lists['user']; ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key">Dokter * : </td>
      <td width="82%"><?php echo $lists['dokter']; ?></td>
    </tr>
	  <tr>
      <td width="18%" align="right" class="key">klinik * : </td>
      <td width="82%"><?php echo $lists['klinik']; ?></td>
    </tr>
	<tr>
      <td width="18%" align="right" class="key">Tanggal Booking * : </td>
      <td width="82%"><input name="booking" type="text" id="booking" value="<?php echo $this->data['reg'][0]->booking; ?>" size="30"/></td>
    </tr>
	<tr>
      <td width="18%" align="right" class="key">Tanggal Pendaftaran * : </td>
      <td width="82%"><input name="tanggal" type="text" id="tanggal" value="<?php echo $this->data['reg'][0]->tanggal; ?>" size="30"/></td>
    </tr>
	<tr>
      <td width="18%" align="right" class="key">Status * : </td>
      <td width="82%"><?php echo $lists['status']; ?></td>
    </tr>

    <?php if($row->id == 0){?>

    <?php } ?>
  </table>
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="reg" />
<input type="hidden" name="id" value="<?php echo $this->data['reg'][0]->id; ?>" />
<input type="hidden" name="task" value="" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>