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
//print_r($this->data['departement']);
?>
<form action="index.php" method="post" name="adminForm">
	<table width="158" class="adminlist">
		<thead>
			<tr>
				<th width="3%">
					<input type="checkbox" name="toggle" onclick="checkAll(<?php echo count( $this->data['jabatan'] ); ?>);" />
			  </th>
				<th width="60%" class="left">jabatan</th>
			</tr>
		</thead>		
		<tbody>
		<?php for($i=0; $i < count($this->data['jabatan']); $i++){ 
				$row = &$this->data['jabatan'][$i];
				$checked 	= JHTML::_('grid.checkedout',   $row, $i ); ?>
			<tr class="row<?= $i % 2; ?>">
				<td class="center"><?php echo $checked; ?></td>
				<td><?php echo $this->data['jabatan'][$i]->jabatan;?></td>
			</tr>
		<?php } ?>
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
<input type="hidden" name="c" value="jabatan" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="task" value="" />
</form>
