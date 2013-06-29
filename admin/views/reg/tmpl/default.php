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

$klinik_id = JRequest::getVar('klinik_id');
$dokter_id = JRequest::getVar('dokter_id');
$mulai = JRequest::getVar('mulai');
$sampai = JRequest::getVar('sampai');
$fstatus = JRequest::getVar('fstatus');

$lists = array();
	$kliniklist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Klinik' ), 'id', 'klinik' );
	$kliniklist			= array_merge( $kliniklist, $this->data['klinikList']);
	$lists['klinik']		= JHTML::_('select.genericlist', $kliniklist, 'klinik_id', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'id', 'klinik',$klinik_id);
	
	$stafflist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Dokter' ), 'id', 'nama' );
	$stafflist			= array_merge( $stafflist, $this->data['staffList']);
	$lists['staff']		= JHTML::_('select.genericlist', $stafflist, 'dokter_id', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'id', 'nama',$dokter_id);
		
	$statuslist[]		= JHTML::_('select.option',  '', JText::_( 'Update Status Pendaftar' ), 'status', 'value' );
	$statuslist[]		= JHTML::_('select.option',  'Pending', JText::_( 'Pending' ), 'status', 'value' );
	$statuslist[]		= JHTML::_('select.option',  'Confirmed', JText::_( 'Confirmed' ), 'status', 'value' );
	$statuslist[]		= JHTML::_('select.option',  'Reject', JText::_( 'Reject' ), 'status', 'value' );							

	$lists['status']	= JHTML::_('select.genericlist', $statuslist, 'status', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'status', 'value');
	
	$fstatuslist[]		= JHTML::_('select.option',  '', JText::_( 'Filter berdasarkan status' ), 'status', 'value' );
	$fstatuslist[]		= JHTML::_('select.option',  'Pending', JText::_( 'Pending' ), 'status', 'value' );
	$fstatuslist[]		= JHTML::_('select.option',  'Confirmed', JText::_( 'Confirmed' ), 'status', 'value' );
	$fstatuslist[]		= JHTML::_('select.option',  'Reject', JText::_( 'Reject' ), 'status', 'value' );	
	$fstatuslist[]		= JHTML::_('select.option',  'Canceled', JText::_( 'Canceled' ), 'status', 'value' );							

	$lists['fstatus']	= JHTML::_('select.genericlist', $fstatuslist, 'fstatus', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'status', 'value',$fstatus);

?>
<form method="post" name="adminForm">
<?php echo $lists['klinik']." ".$lists['staff']." ".$lists['fstatus']." Periode Booking ".JHTML::_('calendar', $mulai,'mulai', 'mulai', '%Y-%m-%d','onchange="document.adminForm.submit();"')." sampai ".JHTML::_('calendar', $sampai,'sampai', 'sampai', '%Y-%m-%d','onchange="document.adminForm.submit();"'); ?>
<div style="float:right"><?php echo $lists['status']; ?></div>
	<table width="158" class="adminlist">
		<thead>
			<tr>
				<th width="3%">
					<input type="checkbox" name="toggle" onclick="checkAll(<?php echo count( $this->data['reg'] ); ?>);" />
			  </th>
				<th width="10%" class="left"><?php echo JText::_('COM_SIRS_REG_TITLE_NOREG'); ?></th>
				<th width="10%" class="left"><?php echo JText::_('COM_SIRS_REG_TITLE_USERID'); ?></th>
				<th width="10%" class="left"><?php echo JText::_('COM_SIRS_REG_TITLE_KLINIK'); ?></th>
				<th width="10%" class="left"><?php echo JText::_('COM_SIRS_REG_TITLE_DOKTER'); ?></th>
				<th width="10%" class="left"><?php echo JText::_('COM_SIRS_REG_TITLE_DATE_BOOKING'); ?></th>
				<th width="10%" class="left"><?php echo JText::_('COM_SIRS_REG_TITLE_DATE_REGISTRASI'); ?></th>
				<th width="10%" class="left"><?php echo JText::_('COM_SIRS_REG_TITLE_STATUS'); ?></th>																
			</tr>
		</thead>		
		<tbody>
		<?php for($i=0; $i < count($this->data['reg']); $i++){ 
		$row = &$this->data['reg'][$i];
			/*$lists['status']	= JHTML::_('select.genericlist', $statuslist, 'status['.$row->id.']', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'status', 'value');*/
				$checked 	= JHTML::_('grid.checkedout',   $row, $i ); ?>
			<tr class="row<?= $i % 2; ?>">
				<td class="center"><?php echo $checked; ?></td>
				<td><?php echo $row->no_reg;?></td>
				<td><?php echo $row->name;?></td>
				<td><?php echo $row->klinik;?></td>
				<td><?php echo $row->nama;  ?></td>
				<td><?php echo $row->booking;	?></td>
				<td><?php echo $row->tanggal;	 ?></td>
				<td><?php echo $row->status; ?></td>
			</tr>
		<?php } ?>
        <tr>
		<td colspan="9">
			<?php echo $this->data['pageNav']->getListFooter(); ?>		</td>
		</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="15">
					10
				</td>
			</tr>
		</tfoot>
  </table>
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="reg" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="task" value="" />
</form>
