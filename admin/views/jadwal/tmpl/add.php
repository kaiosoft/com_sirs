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
	
	$db =& JFactory::getDBO();
	
	$sql = "SELECT distinct dokter_id FROM #__sirs_jadwal";
	$db->setQuery($sql);
	$rows = $db->loadObjectList();
	
	$jadwal = array();
	foreach($rows as $row)
	{
		$jadwal[] = $row->dokter_id;
	}
	
	if(empty($jadwal))
	{
		$sql = "SELECT * FROM #__sirs_staff";
	}
	else
	{
		$sql = "SELECT * FROM #__sirs_staff WHERE id NOT IN (".implode(",",$jadwal).")";
	}
	$db->setQuery($sql);
	$listStaff = $db->loadObjectList();
	
	
	$stafflist[]		= JHTML::_('select.option',  '0', JText::_( 'Pilih Dokter' ), 'id', 'nama' );
	$stafflist			= array_merge( $stafflist, $listStaff);
	$lists['staff']		= JHTML::_('select.genericlist', $stafflist, 'dokter_id', 'class="inputbox" size="1"', 'id', 'nama',$this->data['jadwal'][0]->dokter_id);
	
	$kliniklist[]		= JHTML::_('select.option',  '0', JText::_( 'Pilih Klinik' ), 'id', 'klinik' );
	$kliniklist			= array_merge( $kliniklist, $this->data['klinikList']);
	$lists['klinik']		= JHTML::_('select.genericlist', $kliniklist, 'klinik_id', 'class="inputbox" size="1"', 'id', 'klinik',$this->data['jadwal'][0]->klinik_id);
	
	$harilist[]		= JHTML::_('select.option',  '0', JText::_( 'Pilih Hari' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '1', JText::_( 'Senin' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '2', JText::_( 'Selasa' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '3', JText::_( 'Rabu' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '4', JText::_( 'Kamis' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '5', JText::_( 'Jumat' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '6', JText::_( 'Sabtu' ), 'hari', 'value' );						
	$lists['hari']	= JHTML::_('select.genericlist', $harilist, 'hari', 'class="inputbox" size="1"', 'hari', 'value',$this->data['jadwal'][0]->hari);
	
	$jamlist[]		= JHTML::_('select.option',  '', JText::_( 'Pilih Jam' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '07.00', JText::_( '07.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '07.30', JText::_( '07.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '08.00', JText::_( '08.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '08.30', JText::_( '08.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '09.00', JText::_( '09.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '09.30', JText::_( '09.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '10.00', JText::_( '10.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '10.30', JText::_( '10.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '11.00', JText::_( '11.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '11.30', JText::_( '11.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '12.00', JText::_( '12.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '12.30', JText::_( '12.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '13.00', JText::_( '13.00' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '13.30', JText::_( '13.30' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '14.00', JText::_( '14.00' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '14.30', JText::_( '14.30' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '15.00', JText::_( '15.00' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '15.30', JText::_( '15.30' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '16.00', JText::_( '16.00' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '16.30', JText::_( '16.30' ), 'jam', 'value' );																		
	$jamlist[]		= JHTML::_('select.option',  '17.00', JText::_( '17.00' ), 'jam', 'value' );											
	$jamlist[]		= JHTML::_('select.option',  '17.30', JText::_( '17.30' ), 'jam', 'value' );	
	$jamlist[]		= JHTML::_('select.option',  '18.00', JText::_( '18.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '18.30', JText::_( '18.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '19.00', JText::_( '19.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '19.30', JText::_( '19.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '20.00', JText::_( '20.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '20.30', JText::_( '20.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '21.00', JText::_( '21.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '21.30', JText::_( '21.30' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '22.00', JText::_( '22.00' ), 'jam', 'value' );
	$jamlist[]		= JHTML::_('select.option',  '22.30', JText::_( '22.30' ), 'jam', 'value' );												
	$lists['sjam']	= JHTML::_('select.genericlist', $jamlist, 'sjam', 'class="inputbox" size="1"', 'jam', 'value',$this->data['jadwal'][0]->sjam);
	$lists['fjam']	= JHTML::_('select.genericlist', $jamlist, 'fjam', 'class="inputbox" size="1"', 'jam', 'value',$this->data['jadwal'][0]->fjam);

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
Joomla.submitbutton = function(task)
{
	if(task == 'jadwal.save')
	{
		
		if((document.getElementById('dokter_id').value == "0") ||	(document.getElementById('hari').value == "0")
		 || (document.getElementById('sjam').value == "0") || (document.getElementById('fjam').value == "0")
		 || (document.getElementById('klinik_id').value == "0"))
		{
			alert('Semua fields bertanda bintang harus terisi');
		}
		else
		{
			document.getElementById('task').value="jadwal.save";
			document.adminForm.submit();
		}
	}
	else
	{
		document.getElementById('task').value="jadwal.cancel";
		document.adminForm.submit();
	}
}
</script>
<form action="index.php" method="post" name="adminForm">
  <table width="100%" border="0" cellpadding="4" cellspacing="1" class="admintable">
    <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_JADWAL_FIELD_DOKTER'); ?> * : </td>
      <td width="82%"><?php echo $lists['staff']; ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_JADWAL_FIELD_HARI'); ?> * : </td>
      <td width="82%"><?php echo $lists['hari']; ?></td>
    </tr>
	
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_JADWAL_FIELD_SJAM'); ?> * : </td>
      <td width="82%"><?php echo $lists['sjam']; ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_JADWAL_FIELD_FJAM'); ?> * : </td>
      <td width="82%"><?php echo $lists['fjam']; ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_JADWAL_FIELD_KLINIK'); ?> * : </td>
      <td width="82%"><?php echo $lists['klinik']; ?></td>
    </tr>
    	<tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_JADWAL_FIELD_ROOM'); ?>  : </td>
      <td width="82%"><input type="text" name="room" id="room" value="<?php echo $this->data['jadwal'][0]->room; ?>"></td>
    </tr>
	<tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_JADWAL_FIELD_KETERANGAN'); ?> : </td>
      <td width="82%"><textarea name="keterangan" cols="30" rows="3"></textarea></td>
    </tr>

    <?php if($row->id == 0){?>

    <?php } ?>
  </table>
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="jadwal" />
<input type="hidden" name="id" value="<?php echo $this->data['jadwal'][0]->id; ?>" />
<input type="hidden" id="task" name="task" value="" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>

<!-- quick style -->
<style>
.jadwalPraktek
{
float:left;
margin-right:10px;
}
</style>
