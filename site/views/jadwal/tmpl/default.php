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
	
	defined('_JEXEC') or die('Restricted access');
	
	$user =& JFactory::getUser();
	
	//load model
	$modelJadwal =& JModel::getInstance('jadwal','SirsModel');
	$helper = new sirsHelper;
	
	$klinik_id = JRequest::getVar('klinik_id');
	$dokter_id = JRequest::getVar('dokter_id');
	$hari = JRequest::getVar('hari');

	$lists = array();
	$kliniklist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Klinik' ), 'id', 'klinik' );
	$kliniklist			= array_merge( $kliniklist, $this->data['klinikList']);
	$lists['klinik']		= JHTML::_('select.genericlist', $kliniklist, 'klinik_id', 'onchange="document.jadwalForm.submit();" class="inputbox" size="1"', 'id', 'klinik',$klinik_id);
	
	$stafflist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Dokter' ), 'id', 'nama' );
	$stafflist			= array_merge( $stafflist, $this->data['staffList']);
	$lists['staff']		= JHTML::_('select.genericlist', $stafflist, 'dokter_id', 'onchange="document.jadwalForm.submit();" class="inputbox" size="1"', 'id', 'nama',$dokter_id);
	
	$harilist[]		= JHTML::_('select.option',  '0', JText::_( 'Filter Berdasarkan Hari' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '1', JText::_( 'Senin' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '2', JText::_( 'Selasa' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '3', JText::_( 'Rabu' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '4', JText::_( 'Kamis' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '5', JText::_( 'Jumat' ), 'hari', 'value' );
	$harilist[]		= JHTML::_('select.option',  '6', JText::_( 'Sabtu' ), 'hari', 'value' );						
	$lists['hari']	= JHTML::_('select.genericlist', $harilist, 'hari', 'onchange="document.jadwalForm.submit();" class="inputbox" size="1"', 'hari', 'value',$hari);
	
	$helper = new sirsHelper;
	$klinik = $helper->getDataByParam("id","='".$klinik_id."'","#__sirs_klinik");
	
	
	
	echo "<div class='jadwalTitle'>JADWAL DOKTER</div><div>Untuk melakukan booking jadwal dokter online, silahkan klik tombol booking</div>".
	"<form method=post name=jadwalForm>".
	"<p>".$lists['klinik'].$lists['staff'].$lists['hari']."</p>";
	echo "<h2 class='judulFilter'>Jadwal Dokter Klinik ".$klinik->klinik."</h2>";
	if(!empty($this->data['dokter']))
	{
	foreach($this->data['dokter'] as $dokter)
	{
	$profilSingkat = substr($dokter->profil,0,200)."...";
	echo "<div id='boxDokter'>";
	
	echo "<div>
			<div style='float:left;width:35%;'><p>".$dokter->title." ".$dokter->nama."</p><img src=".JURI::root()."components/com_sirs/assets/doctor-icon.png height=100 /><p id=dokter></p></div>
			<div><p id=sort".$dokter->id.">".$profilSingkat."<input type=button value='Lihat Selengkapnya' id=buttonDesc class=".$dokter->id."></p><p class=desc".$dokter->id." style=display:none;>".$dokter->profil."</p></div>
		</div><div style='clear:both'></div>";
		
	echo "<div>";
		$jadwalDokter = $modelJadwal->getJadwalByDokter($dokter->id);
		echo "<table width='100%'>";
		$JJam = array();
		$JKeterangan = array();
		$JKlinik = array();
		$JId = array();
		foreach($jadwalDokter as $jadwal)
		{
			
			switch($jadwal->hari)
			{
				case 1:
					if(!empty($klinik_id))
					{	
						if($klinik_id == $jadwal->klinik_id)
						{
							$JJam[1][] = $jadwal->sjam."-".$jadwal->fjam;
							$JKeterangan[1][] = $jadwal->keterangan;
							$JKlinik[1][] = $jadwal->klinik;
							$JId[1][] = $jadwal->id;
						}
						else
						{
						
						}
					}
					else
					{
						$JJam[1][] = $jadwal->sjam."-".$jadwal->fjam;
						$JKeterangan[1][] = $jadwal->keterangan;
						$JKlinik[1][] = $jadwal->klinik;
						$JId[1][] = $jadwal->id;
					}
				break;
				
				case 2:
					if(!empty($klinik_id))
					{	
						if($klinik_id == $jadwal->klinik_id)
						{
							$JJam[2][] = $jadwal->sjam."-".$jadwal->fjam;
							$JKeterangan[2][] = $jadwal->keterangan;					
							$JKlinik[2][] = $jadwal->klinik;
							$JId[2][] = $jadwal->id;
						}
						else
						{
						
						}
					}
					else
					{
						$JJam[2][] = $jadwal->sjam."-".$jadwal->fjam;
						$JKeterangan[2][] = $jadwal->keterangan;					
						$JKlinik[2][] = $jadwal->klinik;
						$JId[2][] = $jadwal->id;
					}
				break;
				
				case 3:
					if(!empty($klinik_id))
					{	
						if($klinik_id == $jadwal->klinik_id)
						{
							$JJam[3][] = $jadwal->sjam."-".$jadwal->fjam;
							$JKeterangan[3][] = $jadwal->keterangan;					
							$JKlinik[3][] = $jadwal->klinik;
							$JId[3][] = $jadwal->id;
						}
						else
						{
						
						}
					}
					else
					{
						$JJam[3][] = $jadwal->sjam."-".$jadwal->fjam;
						$JKeterangan[3][] = $jadwal->keterangan;					
						$JKlinik[3][] = $jadwal->klinik;
						$JId[3][] = $jadwal->id;
					}
				break;
				
				case 4:
					if(!empty($klinik_id))
					{	
						if($klinik_id == $jadwal->klinik_id)
						{
							$JJam[4][] = $jadwal->sjam."-".$jadwal->fjam;
							$JKeterangan[4][] = $jadwal->keterangan;					
							$JKlinik[4][] = $jadwal->klinik;
							$JId[4][] = $jadwal->id;
						}
						else
						{
						
						}
					}
					else
					{
						$JJam[4][] = $jadwal->sjam."-".$jadwal->fjam;
						$JKeterangan[4][] = $jadwal->keterangan;					
						$JKlinik[4][] = $jadwal->klinik;
						$JId[4][] = $jadwal->id;
					}
				break;
				
				case 5:
					if(!empty($klinik_id))
					{	
						if($klinik_id == $jadwal->klinik_id)
						{
							$JJam[5][] = $jadwal->sjam."-".$jadwal->fjam;					
							$JKeterangan[5][] = $jadwal->keterangan;					
							$JKlinik[5][] = $jadwal->klinik;
							$JId[5][] = $jadwal->id;
						}
						else
						{
							
						}
					}
					else
					{
						$JJam[5][] = $jadwal->sjam."-".$jadwal->fjam;					
						$JKeterangan[5][] = $jadwal->keterangan;					
						$JKlinik[5][] = $jadwal->klinik;
						$JId[5][] = $jadwal->id;
					}
				break;
				
				case 6:
					if(!empty($klinik_id))
					{	
						if($klinik_id == $jadwal->klinik_id)
						{
							$JJam[6][] = $jadwal->sjam."-".$jadwal->fjam;					
							$JKeterangan[6][] = $jadwal->keterangan;					
							$JKlinik[6][] = $jadwal->klinik;
							$JId[6][] = $jadwal->id;
						}
						else
						{
						
						}
					}
					else
					{
						$JJam[6][] = $jadwal->sjam."-".$jadwal->fjam;					
						$JKeterangan[6][] = $jadwal->keterangan;					
						$JKlinik[6][] = $jadwal->klinik;
						$JId[6][] = $jadwal->id;
					}
				break;
				
				default:
					if(!empty($klinik_id))
					{	
						if($klinik_id == $jadwal->klinik_id)
						{
							$JJam[7][] = $jadwal->sjam."-".$jadwal->fjam;
							$JKeterangan[7][] = $jadwal->keterangan;					
							$JKlinik[7][] = $jadwal->klinik;
							$JId[7][] = $jadwal->id;
						}
						else
						{
						
						}
					}
					else
					{
						$JJam[7][] = $jadwal->sjam."-".$jadwal->fjam;
						$JKeterangan[7][] = $jadwal->keterangan;					
						$JKlinik[7][] = $jadwal->klinik;
						$JId[7][] = $jadwal->id;
					}
				break;
			}
		}
		
			//head jadwal dokter
			echo "<tr>";
			if(!empty($JJam[1]))
			{
				echo "<th>Senin</th>";
			}
			if(!empty($JJam[2]))
			{
				echo "<th>Selasa</th>";
			}
			if(!empty($JJam[3]))
			{
				echo "<th>Rabu</th>";
			}
			if(!empty($JJam[4]))
			{
				echo "<th>Kamis</th>";
			}
			if(!empty($JJam[5]))
			{
				echo "<th>Jum'at</th>";
			}
			if(!empty($JJam[6]))
			{
				echo "<th>Sabtu</th>"; 
			}	
			if(!empty($JJam[7]))
			{
				echo "<th>Minggu</th>";
			}
			echo "</tr>";
			
			echo "<tr>";
			
			
			if(!empty($JJam[1])){
				echo "<td>";
				for($i=0;$i<count($JJam[1]);$i++)
				{
					echo " - ".$JJam[1][$i]." [klinik ".$JKlinik[1][$i]."] <br />".$JKeterangan[1][$i];
					
				}
				if(empty($user->id))
				{
					echo "<p>&nbsp;</p><a href='".JRoute::_('index.php?option=com_users&task=login')."' title='booking hanya untuk member'>Booking</a>";	
				}
				else
				{
					echo "<input type=button value='Booking Jadwal' id=doBooking class='".$dokter->id."1' >";
					echo "<div id=lightBooking class='light".$dokter->id."1' >
					<h2>Booking Jadwal Dokter</h2>
					Booking Dokter ".$dokter->title." ".$dokter->nama." Untuk Berobat Pada <br />
					Hari / Tanggal : Senin, ".$helper->pilihanHariBooking($helper->getTanggalByHari(1),$dokter->id,1)." <br />
					Jam / Waktu : ".$helper->pilihanJamBooking($JJam[1],$JId[1],$dokter->id,1)." <br />
					<input type=hidden value=".$klinik_id." id=klinik />
					<input type=button value=booking id=bookThis class='".$dokter->id."1' />
					</div>";
				}
				echo "</td>";
			}
			
			
			
			if(!empty($JJam[2])){
				echo "<td>";
				for($i=0;$i<count($JJam[2]);$i++)
				{
					echo " - ".$JJam[2][$i]." [klinik ".$JKlinik[2][$i]."] <br />".$JKeterangan[2][$i];
					
				}
				if(empty($user->id))
				{
					echo "<p>&nbsp;</p><a href='".JRoute::_('index.php?option=com_users&task=login')."' title='booking hanya untuk member'>Booking</a>";	
				}
				else
				{
					echo "<input type=button value='Booking Jadwal' id=doBooking class='".$dokter->id."2' >";
					echo "<div id=lightBooking class='light".$dokter->id."2' >
					<h2>Booking Jadwal Dokter</h2>
					Booking Dokter ".$dokter->title." ".$dokter->nama." Untuk Berobat Pada <br />
					Hari / Tanggal : Selasa, ".$helper->pilihanHariBooking($helper->getTanggalByHari(2),$dokter->id,2)." <br />
					Jam / Waktu : ".$helper->pilihanJamBooking($JJam[2],$JId[2],$dokter->id,2)." <br />			
					<input type=hidden value=".$klinik_id." id=klinik />
					<input type=button value=booking id=bookThis class='".$dokter->id."2' />
					</div>";
				}
				echo "</td>";
			}
			
			
			
			if(!empty($JJam[3])){
				echo "<td>";
				for($i=0;$i<count($JJam[3]);$i++)
				{
					echo " - ".$JJam[3][$i]." [klinik ".$JKlinik[3][$i]."] <br />".$JKeterangan[3][$i];
				}
				if(empty($user->id))
				{
					echo "<p>&nbsp;</p><a href='".JRoute::_('index.php?option=com_users&task=login')."' title='booking hanya untuk member'>Booking</a>";		
				}
				else
				{
					echo "<input type=button value='Booking Jadwal' id=doBooking class='".$dokter->id."3' >";
					echo "<div id=lightBooking class='light".$dokter->id."3' >
					<h2>Booking Jadwal Dokter</h2>
					Booking Dokter ".$dokter->title." ".$dokter->nama." Untuk Berobat Pada <br />
					Hari / Tanggal : Rabu, ".$helper->pilihanHariBooking($helper->getTanggalByHari(3),$dokter->id,3)." <br />
					Jam / Waktu : ".$helper->pilihanJamBooking($JJam[3],$JId[3],$dokter->id,3)." <br />
					<input type=hidden value=".$klinik_id." id=klinik />
					<input type=button value=booking id=bookThis class='".$dokter->id."3' />
					</div>";
				}
				echo "</td>";
			}
			
			
			
			if(!empty($JJam[4])){
				echo "<td>";
				for($i=0;$i<count($JJam[4]);$i++)
				{
					echo " - ".$JJam[4][$i]." [klinik ".$JKlinik[4][$i]."] <br />".$JKeterangan[4][$i];
				}
				if(empty($user->id))
				{
					echo "<p>&nbsp;</p><a href='".JRoute::_('index.php?option=com_users&task=login')."' title='booking hanya untuk member'>Booking</a>";	
				}
				else
				{
					echo "<input type=button value='Booking Jadwal' id=doBooking class='".$dokter->id."4' >";
					echo "<div id=lightBooking class='light".$dokter->id."4' >
					<h2>Booking Jadwal Dokter</h2>
					Booking Dokter ".$dokter->title." ".$dokter->nama." Untuk Berobat Pada <br />
					Hari / Tanggal : Kamis, ".$helper->pilihanHariBooking($helper->getTanggalByHari(4),$dokter->id,4)." <br />
					Jam / Waktu : ".$helper->pilihanJamBooking($JJam[4],$JId[4],$dokter->id,4)." <br />
					<input type=hidden value=".$klinik_id." id=klinik />
					<input type=button value=booking id=bookThis class='".$dokter->id."4' />
					</div>";
				}
				echo "</td>";
			}
			
			
			
			if(!empty($JJam[5])){
				echo "<td>";
				for($i=0;$i<count($JJam[5]);$i++)
				{
					echo " - ".$JJam[5][$i]." [klinik ".$JKlinik[5][$i]."] <br />".$JKeterangan[5][$i];
				}
				if(empty($user->id))
				{
					echo "<p>&nbsp;</p><a href='".JRoute::_('index.php?option=com_users&task=login')."' title='booking hanya untuk member'>Booking</a>";	
				}
				else
				{
					echo "<input type=button value='Booking Jadwal' id=doBooking class='".$dokter->id."5' >";
					echo "<div id=lightBooking class='light".$dokter->id."5' >
					<h2>Booking Jadwal Dokter</h2>
					Booking Dokter ".$dokter->title." ".$dokter->nama." Untuk Berobat Pada <br />
					Hari / Tanggal : Jum'at, ".$helper->pilihanHariBooking($helper->getTanggalByHari(5),$dokter->id,5)." <br />
					Jam / Waktu : ".$helper->pilihanJamBooking($JJam[5],$JId[5],$dokter->id,5)." <br />
					<input type=hidden value=".$klinik_id." id=klinik />
					<input type=button value=booking id=bookThis class='".$dokter->id."5' />
					</div>";
					
				}
				echo "</td>";
			}
			
			
			
			if(!empty($JJam[6])){
				echo "<td>";
				for($i=0;$i<count($JJam[6]);$i++)
				{
					echo " - ".$JJam[6][$i]." [klinik ".$JKlinik[6][$i]."] <br />".$JKeterangan[6][$i];
				}
				if(empty($user->id))
				{
					echo "<p>&nbsp;</p><a href='".JRoute::_('index.php?option=com_users&task=login')."' title='booking hanya untuk member'>Booking</a>";	
				}
				else
				{
					echo "<input type=button value='Booking Jadwal' id=doBooking class='".$dokter->id."6' >";
					echo "<div id=lightBooking class='light".$dokter->id."6' >
					<h2>Booking Jadwal Dokter</h2>
					Booking Dokter ".$dokter->title." ".$dokter->nama." Untuk Berobat Pada <br />
					Hari / Tanggal : Sabtu, ".$helper->pilihanHariBooking($helper->getTanggalByHari(6),$dokter->id,6)." <br />
					Jam / Waktu : ".$helper->pilihanJamBooking($JJam[6],$JId[6],$dokter->id,6)." <br />
					<input type=hidden value=".$klinik_id." id=klinik />
					<input type=button value=booking id=bookThis class='".$dokter->id."6' />
					</div>";
				}
				echo "</td>";
			}
			
			
			
			if(!empty($JJam[7])){
				echo "<td>";
				for($i=0;$i<count($JJam[7]);$i++)
				{
					echo " - ".$JJam[7][$i]." [klinik ".$JKlinik[7][$i]."] <br />".$JKeterangan[7][$i];
				}
				if(empty($user->id))
				{
					echo "<p>&nbsp;</p><a href='".JRoute::_('index.php?option=com_users&task=login')."' title='booking hanya untuk member'>Booking</a>";	
				}
				else
				{
					echo "<input type=button value='Booking Jadwal' id=doBooking class='".$dokter->id."7' >";
					echo "<div id=lightBooking class='light".$dokter->id."7' >
					<h2>Booking Jadwal Dokter</h2>
					Booking Dokter ".$dokter->title." ".$dokter->nama." Untuk Berobat Pada <br />
					Hari / Tanggal : Sabtu, ".$helper->pilihanHariBooking($helper->getTanggalByHari(7),$dokter->id,7)." <br />
					Jam / Waktu : ".$helper->pilihanJamBooking($JJam[7],$JId[7],$dokter->id,7)." <br />
					<input type=hidden value=".$klinik_id." id=klinik />
					<input type=button value=booking id=bookThis class='".$dokter->id."7' />
					</div>";
				}
				echo "</td>";
			}
			
			echo "</tr>";
			
			echo "</table>";
		
		echo "</div></div>";
	}
	echo $this->data['pageNav']->getListFooter();
	}
	
	echo "<div class=bgBlack></div>";
	
	echo "<input type=hidden name=option value=com_sirs>".
	"<input type=hidden name=c value=jadwal>".
	"<input type=hidden name=task value='' >".
	"</form>";
	
?>
<script src="components/com_sirs/assets/js/sirs.js"></script>
<link rel="stylesheet" type="text/css" href="components/com_sirs/assets/css/sirs.css"  />