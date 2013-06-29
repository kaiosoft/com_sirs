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
$hari = JRequest::getVar('hari');

$helper = new sirsHelper;

	$lists = array();
	$kliniklist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Klinik' ), 'id', 'klinik' );
	$kliniklist			= array_merge( $kliniklist, $this->data['klinikList']);
	$lists['klinik']		= JHTML::_('select.genericlist', $kliniklist, 'klinik_id', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'id', 'klinik',$klinik_id);
	
	$stafflist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Dokter' ), 'id', 'nama' );
	$stafflist			= array_merge( $stafflist, $this->data['staffList']);
	$lists['staff']		= JHTML::_('select.genericlist', $stafflist, 'dokter_id', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'id', 'nama',$dokter_id);
	
	$harilist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Hari' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '1', JText::_( 'Senin' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '2', JText::_( 'Selasa' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '3', JText::_( 'Rabu' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '4', JText::_( 'Kamis' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '5', JText::_( 'Jumat' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '6', JText::_( 'Sabtu' ), 'hari', 'value' );						
	$harilist[]		= JHTML::_('select.option',  '7', JText::_( 'Minggu' ), 'hari', 'value' );						
	$lists['hari']	= JHTML::_('select.genericlist', $harilist, 'hari', 'onchange="document.adminForm.submit();" class="inputbox" size="1"', 'hari', 'value',$hari);
?>
<form action="index.php" method="post" name="adminForm">
<?php echo $lists['klinik']." ".$lists['staff']." ".$lists['hari']; ?>
	<table width="158" class="adminlist">
		<thead>
			<tr>
				<th width="3%">
					<input type="checkbox" name="toggle" onclick="checkAll(<?php echo count( $this->data['jadwal'] ); ?>);" />
			  </th>
				<th class="left"><?php echo JText::_('COM_SIRS_JADWAL_TITLE_DOKTER'); ?></th>
				<th class="left"><?php echo JText::_('COM_SIRS_JADWAL_TITLE_JADWAL'); ?></th>
			</tr>
		</thead>		
		<tbody>
		<?php for($i=0; $i < count($this->data['jadwal']); $i++){ 
				$row = &$this->data['jadwal'][$i];
				$checked 	= JHTML::_('grid.checkedout',   $row, $i ); ?>
			<tr class="row<?= $i % 2; ?>">
				<td class="center"><?php echo $checked; ?></td>
				<td><?php echo $this->data['jadwal'][$i]->nama;?></td>
				<td><?php 
				echo "<table width='100%'>";
				echo "<tr><th>Senin</th><th>Selasa</th><th>Rabu</th><th>Kamis</th><th>Jum'at</th><th>Sabtu</th><th>Minggu</th></tr>";
				for($j=1;$j<=7;$j++)
				{
					if($j == 1)
					{
						if(!empty($this->data['jadwal'][$i]->start[1]))
						{
							echo "<td>";
							for($k=0;$k<count($this->data['jadwal'][$i]->start[1]);$k++)
							{
								$klinik = $helper->getDataByParam("id","='".$this->data['jadwal'][$i]->klinik[1][$k]."'","#__sirs_klinik");
								echo "<img src='components/com_sirs/assets/images/delete.png' height='10' tag='".$this->data['jadwal'][$i]->idJadwal[1][$k]."' class='removeJadwal' />
								<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&cid=".$this->data['jadwal'][$i]->idJadwal[1][$k]."'>".$this->data['jadwal'][$i]->start[1][$k]." - ".$this->data['jadwal'][$i]->finish[1][$k]."</a> [".$klinik->klinik."] <br />";
							}
							echo "<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=1&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
						else
						{
							echo "<td><a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=1&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
					}
					else if($j == 2)
					{
						if(!empty($this->data['jadwal'][$i]->start[2]))
						{
							echo "<td>";
							for($k=0;$k<count($this->data['jadwal'][$i]->start[2]);$k++)
							{
								$klinik = $helper->getDataByParam("id","='".$this->data['jadwal'][$i]->klinik[2][$k]."'","#__sirs_klinik");
								echo "<img src='components/com_sirs/assets/images/delete.png' height='10' tag='".$this->data['jadwal'][$i]->idJadwal[2][$k]."' class='removeJadwal' />
								<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&cid=".$this->data['jadwal'][$i]->idJadwal[2][$k]."'>".$this->data['jadwal'][$i]->start[2][$k]." - ".$this->data['jadwal'][$i]->finish[2][$k]."</a> [".$klinik->klinik."] <br />";
							}
							echo "<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=2&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
						else
						{
							echo "<td><a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=2&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
					}
					else if($j == 3)
					{
						if(!empty($this->data['jadwal'][$i]->start[3]))
						{
							echo "<td>";
							for($k=0;$k<count($this->data['jadwal'][$i]->start[3]);$k++)
							{
								$klinik = $helper->getDataByParam("id","='".$this->data['jadwal'][$i]->klinik[3][$k]."'","#__sirs_klinik");
								echo "<img src='components/com_sirs/assets/images/delete.png' height='10' tag='".$this->data['jadwal'][$i]->idJadwal[3][$k]."' class='removeJadwal' />
								<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&cid=".$this->data['jadwal'][$i]->idJadwal[3][$k]."'>".$this->data['jadwal'][$i]->start[3][$k]." - ".$this->data['jadwal'][$i]->finish[3][$k]."</a> [".$klinik->klinik."] <br />";
							}
							echo "<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=3&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
						else
						{
							echo "<td><a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=3&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
					}
					else if($j == 4)
					{
						if(!empty($this->data['jadwal'][$i]->start[4]))
						{
							echo "<td>";
							for($k=0;$k<count($this->data['jadwal'][$i]->start[4]);$k++)
							{
								$klinik = $helper->getDataByParam("id","='".$this->data['jadwal'][$i]->klinik[4][$k]."'","#__sirs_klinik");
								echo "<img src='components/com_sirs/assets/images/delete.png' height='10' tag='".$this->data['jadwal'][$i]->idJadwal[4][$k]."' class='removeJadwal' />
								<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&cid=".$this->data['jadwal'][$i]->idJadwal[4][$k]."'>".$this->data['jadwal'][$i]->start[4][$k]." - ".$this->data['jadwal'][$i]->finish[4][$k]."</a> [".$klinik->klinik."] <br />";
							}
							echo "<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=4&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
						else
						{
							echo "<td><a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=4&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
					}
					else if($j == 5)
					{
						if(!empty($this->data['jadwal'][$i]->start[5]))
						{
							echo "<td>";
							for($k=0;$k<count($this->data['jadwal'][$i]->start[5]);$k++)
							{
								$klinik = $helper->getDataByParam("id","='".$this->data['jadwal'][$i]->klinik[5][$k]."'","#__sirs_klinik");
								echo "<img src='components/com_sirs/assets/images/delete.png' height='10' tag='".$this->data['jadwal'][$i]->idJadwal[5][$k]."' class='removeJadwal' />
								<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&cid=".$this->data['jadwal'][$i]->idJadwal[5][$k]."'>".$this->data['jadwal'][$i]->start[5][$k]." - ".$this->data['jadwal'][$i]->finish[5][$k]."</a> [".$klinik->klinik."] <br />";
							}
							echo "<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=5&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
						else
						{
							echo "<td><a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=5&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
					}
					else if($j == 6)
					{
						if(!empty($this->data['jadwal'][$i]->start[6]))
						{
							echo "<td>";
							for($k=0;$k<count($this->data['jadwal'][$i]->start[6]);$k++)
							{
								$klinik = $helper->getDataByParam("id","='".$this->data['jadwal'][$i]->klinik[6][$k]."'","#__sirs_klinik");
								echo "<img src='components/com_sirs/assets/images/delete.png' height='10' tag='".$this->data['jadwal'][$i]->idJadwal[6][$k]."' class='removeJadwal' />
								<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&cid=".$this->data['jadwal'][$i]->idJadwal[6][$k]."'>".$this->data['jadwal'][$i]->start[6][$k]." - ".$this->data['jadwal'][$i]->finish[6][$k]."</a> [".$klinik->klinik."] <br />";
							}
							echo "<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=6&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
						else
						{
							echo "<td><a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=6&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
					} 
					else
					{
						if(!empty($this->data['jadwal'][$i]->start[7]))
						{
							echo "<td>";
							for($k=0;$k<count($this->data['jadwal'][$i]->start[7]);$k++)
							{
								$klinik = $helper->getDataByParam("id","='".$this->data['jadwal'][$i]->klinik[7][$k]."'","#__sirs_klinik");
								echo "<img src='components/com_sirs/assets/images/delete.png' height='10' tag='".$this->data['jadwal'][$i]->idJadwal[7][$k]."' class='removeJadwal' />
								<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&cid=".$this->data['jadwal'][$i]->idJadwal[7][$k]."'>".$this->data['jadwal'][$i]->start[7][$k]." - ".$this->data['jadwal'][$i]->finish[7][$k]."</a> [".$klinik->klinik."] <br />";
							}
							echo "<a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=7&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
						else
						{
							echo "<td><a href='index.php?option=com_sirs&c=jadwal&task=editJadwal&hari=7&dokter_id=".$this->data['jadwal'][$i]->id."'><img src='components/com_sirs/assets/images/new.png' height='10' /></a></td>";
						}
					}
					
				}
				echo "</tr>";
				echo "</table>";
				
				?>
				</td>
			</tr>
		<?php } ?>
        <td colspan="9">
			<?php echo $this->data['pageNav']->getListFooter(); ?>		</td>
		</tr>
		</tbody>
  </table>
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="jadwal" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="task" value="" />
</form>
<script src="http://code.jquery.com/jquery-1.7.2.js"></script>
<script>
	$(document).ready(function()
	{
		$('.removeJadwal').click(function()
		{
			var idJadwal = $(this).attr('tag');
			var conf = confirm('Anda yakin akan menghapus jadwal ini');
			if(conf == true)
			{
				$.ajax({
					type:"POST",
					url:"<?php echo JURI::Base(); ?>index.php",
					data:{option:"com_sirs",c:"jadwal",task:"jadwal.delete",cid:idJadwal,type:"ajax"},
				}).done(function(show)
				{
					alert(show);
					document.location.reload();
				});
			}
			else
			{
				alert('perintah dibatalkan');
			}
		});
	});
</script>