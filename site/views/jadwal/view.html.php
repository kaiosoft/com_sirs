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
jimport('joomla.application.component.view');

class SirsViewJadwal extends JView
{
	function display($tpl = null)
	{
		//load model
		$app =& JFactory::getApplication();
		$modelJadwal =& JModel::getInstance('jadwal','SirsModel');
		
		$user =& JFactory::getUser();
		$helper = new sirsHelper;
		
		//cek booking dokter
		$cekBooking = $modelJadwal->cekBooking($user->id);
		if(!empty($cekBooking))
		{
			echo "<div id=info>
			<h2>Informasi Booking</h2>";
			foreach($cekBooking as $booking)
			{
				echo "<p>Pada ".$booking->tanggal.", Anda membooking Dokter ".$booking->nama." klinik ".$booking->klinik." untuk berobat pada ".$booking->booking;
				if($booking->status == "Approve")
				{
					echo " status telah di setujui segera cek email / ponsel anda untuk keterangan lebih lanjut [<a href=# onclick=batalkan('".$booking->id."')>Batalkan]</a>";
				}
				else if($booking->status == "Pending")
				{
					echo " status masih tunggu [<a href=# onclick=batalkan('".$booking->id."')>Batalkan]</a>";
				}
				else
				{
					echo " booking dibatalkan / tidak mendapat persetujuan silakan lakukan booking pada jadwal lainnya [<a href=index.php?option=com_sirs&task=remove&id=".$booking->id.">Hapus]</a>";
				}
				echo "<hr>";
			}
			echo "</div>";
		}
		
		//get data from url
		$namaDokter = JRequest::getVar('namaDokter');
		if(!empty($namaDokter))
		{
			$getDokter = $helper->getDataByParam("nama"," LIKE '%".$namaDokter."%'","#__sirs_staff");
			$dokter_id = $getDokter->id;
			JRequest::setVar('dokter_id',$dokter_id);
		}
		else
		{
			$dokter_id = JRequest::getVar('dokter_id');
			if($dokter_id == 0)
			{
				$dokter_id = "";
			}
		}		
		
		$klinik_id = JRequest::getVar('klinik_id');
		if($klinik_id == 0)
		{
			$klinik_id = "";
		}
		
		$hari = JRequest::getVar('hari');
		if($hari == 0)
		{
			$hari = "";
		}
		
		
		$id = JRequest::getVar('id');
		$klinikDefault = $modelJadwal->getDefaultKlinik();
		
		$now = date('Y-m-d');
		$tgl = JRequest::getVar('tgl');
		
		//create filter
		$filter = $helper->setFilter(array("klinik_id","dokter_id","hari"),array("='".$klinik_id."'","='".$dokter_id."'","='".$hari."'"));
		
		$task = JRequest::getVar('task');
		switch($task)
		{
			case "bookingDokter":
			
				$bookingData = JRequest::getVar('bookingData');
				$bookingData = explode(",",$bookingData);
				$post = array();
				$noreg = rand(11111111,99999999);
				$post['no_reg'] = "WEB".$noreg;
				
				//prepare data
				$getJadwal = $helper->getDataByParam("id","='".$bookingData[0]."'","#__sirs_jadwal");
				
				$post['user_id'] = $user->id;
				$post['dokter_id'] = $getJadwal->dokter_id;
				$post['klinik_id'] = $getJadwal->klinik_id;
				
				$tglBooking = $bookingData[1];
				//ubah format
				$thn = substr($tglBooking,6,4);
				$bln = substr($tglBooking,3,2);
				$tgl = substr($tglBooking,0,2);
				$date = $thn."-".$bln."-".$tgl;
				
				$time = $getJadwal->sjam;
				
				$post['booking'] = $date." ".$time;
				$post['tanggal'] = $now;
				$post['status'] = "Pending";		
				
				$save = $modelJadwal->store($post);
				if(!empty($save))
				{
					$msg = "Maaf, terjadi kesalahan dalam penyimpanan data silakan ulangi kembali";
					$mode = "error";
				}
				else
				{
				$msg = "Anda telah membooking untuk berobat tanggal ".$date." pada periode jam ".$getJadwal->sjam." - ".$getJadwal->fjam." No Registrasi ".$post['no_reg']." Cek Email / Hp anda untuk mengetahui informasi selanjutnya";
        
				//send Email
				 $EmailMsg = "Saudara ".$user->name." anda telah melakukan booking jadwal berobat dengan rincian 
				  "."\n"."tanggal berobat : ".substr($bookingData,4,10)."\n"."periode jam ".substr($bookingData,15,11)."\n"."No Registrasi : ".$post['no_reg'].
				  "\n\n"."Silakan datang ke Rumah Sakit Syarif Hidayatullah pada waktu yang telah anda pilih, dan simpan No Registrasi anda karena akan dibutuhkan saat anda berobat pada Rumah Sakit Syarif Hidayatullah".
				  "\n\n"."Terima kasih"."\n"."Hormat kami"."\n\n"."Rumah Sakit Syarif Hidayatullah";
				$helper->sendMail($user->email,"info@rssyarifhidayatullah.com","Rs. Syarif Hidayatullah","Permintaan Pendaftaran Berobat",$EmailMsg,$html="false");
                
				}
				$app->redirect(JRoute::_('index.php?option=com_sirs&c=jadwal'),$msg,$mode);
	
			break;
			case "canceled":
			$modelJadwal->cancelBooking($id);
			break;
			
			case "remove":
			$modelJadwal->removeBooking($id);
			$app->redirect(JRoute::_('index.php?option=com_sirs&c=jadwal'));
			break;
		}
		
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	
			// get the total number of records
		$total = $modelJadwal->getTotal($filter);
			
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		//get data from model
		//$jadwal = $modelJadwal->getAllJadwal($filter);
		$dokter = $modelJadwal->getAllDokter($filter,$pageNav);
		$klinikList = $modelJadwal->klinikList();
		$staffList = $modelJadwal->staffList();
		
		$data = array();
		$data['jadwal'] = $jadwal;
		$data['dokter'] = $dokter;
		$data['klinikList'] = $klinikList;
		$data['staffList'] = $staffList;
		$data['pageNav'] = $pageNav;
		
		$this->assignRef('data',$data);
		?>
		<script src="components/com_sirs/assets/js/jquery-1.7.1.js"></script>
		<?php
		parent::display($tpl);
		echo "<p>&nbsp;</p><div style=float:right;font-size:11px;>Powered By <a href=http://www.kaiogroup.com>Kaio Software</a></div>";
	}
}
?>
<script>
function batalkan(idReg)
{
	var conf=confirm('anda yakin membatalkan ini');
	if(conf == true)
	{
		window.open('index.php?option=com_sirs&task=canceled&id='+idReg,'_self');
	}
	else
	{
		alert('batal');
	}
}
</script>

<!-- quick style -->
<style>
#info
{
border-radius:8px;
border:1px dotted #ccc;
position:relative;
clear:both;
background:#FFFFD9;
color:#999999;
padding:10px;
}
</style>