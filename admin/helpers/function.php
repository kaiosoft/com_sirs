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
 
class sirsHelper
{

	//get Config
	function getConfig($config)
	{
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__invest_config WHERE config='".$config."'";
		$db->setQuery($sql);
		$row = $db->loadObject();
		return $row->value;
	}
	
	//General Function for get array data or single by multiple parameter
	function getDataByParam($param,$value,$table,$show="single",$order="",$att=" && ")
	{
		$filter = $this->setFilter($param,$value,$att);
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM ".$table.$filter.$order;
		$db->setQuery($sql);
		if($show=="single")
		{
			$rows = $db->loadObject();
		}
		else
		{
			$rows = $db->loadObjectList();
		}
		return $rows;
	}
	
	function removeDataByParam($param,$value,$table)
	{
		$filter = $this->setFilter($param,$value);
		$db =& JFactory::getDBO();
		$sql = "Delete FROM ".$table.$filter;
		$db->setQuery($sql);
		$db->query();
	}
	
	//General filter with complete sign like [=,',(,)]
	/*example 
	$params = array("id","name");
	$values = array("='1'","='kaio'");
	*/
	function setFilter($params,$values,$delimiter=" && ")
	{
		$filter = " WHERE ";
		if(is_array($values))
		{
			for($i=0;$i<count($values);$i++)
			{
				if((!empty($params[$i])) && (!empty($values[$i])) && (strlen($values[$i]) > 3))
				{
					if(strlen($filter) <= 7)
					{
					$filter .= $params[$i].$values[$i];
					}
					else
					{
					$filter .= $delimiter.$params[$i].$values[$i];
					}
				}
			}
		}
		else
		{
			if((!empty($params)) && (!empty($values)) && (strlen($values) > 3))
			{
				$filter .= $params.$values;
			}
		}
		
		if(strlen($filter) <= 8)
		{
			$filter = "";
		}
		
		return $filter;
	}
	
	//unset where filter
	function unsetWhereFilter($filter)
	{
		$filter = str_replace("WHERE","&&",$filter);
		return $filter;
	}
	
	function registerUser($post,$group_id="2",$returnLink="index.php")
	{
		$db 	=& JFactory::getDBO();
		$app	=& JFactory::getApplication();
	
		// Create a new JUser object
		$user = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
			
		if($post['id']==0){
			// default password untuk guru baru
			$getPass = $this->getRandom(6,"random");
			$post['password']	= $getPass;
			$post['password2']	= $getPass;
		} else {
			$post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
			$post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);
		}

		
		if (!$user->bind($post))
		{
			$app->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
			$app->enqueueMessage($user->getError(), 'error');
			$link = $returnLink;
			return $app->redirect($link, $msg);
			exit();
		}
			
		/*
		 * Lets save the JUser object
		*/ 
			
		if (!$user->save())
		{
			$app->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
			$app->enqueueMessage($user->getError(), 'error'); // next version Error Handling
			$link = $returnLink;
			return $app->redirect($link, $msg);
			exit();
		}			
		
		else
		{
			// get user id
			$sql = "SELECT id FROM #__users WHERE email='".$post['email']."' && username = '".$post['username']."'";
			$db->setQuery($sql);
			$post['user_id'] = $db->loadResult();
			
			//insert user_group
			$sql = "INSERT INTO #__user_usergroup_map (`user_id`, `group_id`) VALUES ('".$post['user_id']."','".$group_id."')";
			$db->setQuery($sql);
			$RESql = $db->query();
			
			$data = array();
			$data['user_id'] = $post['user_id'];
			$data['password'] = $getPass;
			
			return $data;
		}
			
	}
	
	function updateNameUsers($name,$id)
	{
		$db =& JFactory::getDBO();
		$sql = "UPDATE #__users SET name='".$name."' WHERE id='".$id."'";
		$db->setQuery($sql);
		$db->query();
	}
	
	function br2nl($string)
	{
		$total = substr_count($string,"<br />");
		for($i=0;$i<$total;$i++)
		{
			$string = str_replace("<br />","\n",$string);
		}
		return $string;
	}
	
	//send email
	public function sendMail($recipient="",$senderEmail="",$senderName="",$subject="",$msg="",$html="false")
	{
		$mailer =& JFactory::getMailer();
		
		$sender = array($senderEmail,$senderName);
		$mailer->setSender($sender);
		$mailer->addRecipient($recipient);
		$mailer->isHTML($html);
		if(strtolower($html) == "true")
		{
			$mailer->Encoding = 'base64';
		}
		$mailer->setSubject($subject);
		$mailer->setBody($msg);
				
		$send =& $mailer->Send();
		if ( $send !== true ) 
		{
			$text ='Terjadi masalah dalam mengirim email';
		} else {
			$text ='Kami telah mengirimkan anda email pemberitahuan';
		}
		
		return $text;
	}
	
	function pilihanHariBooking($pilihanHari,$dokter_id,$hari)
	{		
		$tgllist[]		= JHTML::_('select.option',  '', JText::_( 'Tgl Booking' ), 'tanggal', 'value' );
		$tgllist		= array_merge( $tgllist, $pilihanHari);
		$lists['tgl']	= JHTML::_('select.genericlist', $tgllist, 'tanggal'.$dokter_id.$hari, ' class="inputbox" size="1"', 'tanggal', 'value');
		
		//onchange=bookingDokter('.$dokter_id.',value,'.$klinik_id.')
		
		return $lists['tgl'];
	}

	function pilihanJamBooking($pilihanJam,$id,$dokterId,$hari)
	{		
		$lists = "<select name='jam' id='jam".$dokterId.$hari."'>";
		foreach($pilihanJam as $key=>$val)
		{
			$lists .= "<option value='".$id[$key]."'>".$val."</option>";
		}
		$lists .= "</select>";
		
		return $lists;
	}

	function getTanggalByHari($hari)
	{	
		//dapatkan hari dan tanggal hari ini
		$nowHari = date('w');
		$nowTgl = date('d');
		$nowBulan = date('m');
		$nowTahun = date('Y');
		$jumHari = cal_days_in_month(CAL_GREGORIAN, $nowBulan, $nowTahun);
		
		if($nowHari > $hari)
		{
			
			//dapatkan kalkulasi tanggal di hari tersebut
			$hasil = $nowHari - $hari;
			$tglhari = 7 - $hasil;
			$tgl = $nowTgl + $tglhari;
			$bulan = $nowBulan;
			$tahun = $nowTahun;	
			
			//jika tanggal melebihi jumlah hari bulan tersebut
			if($tgl > $jumHari)
			{
				$tgl = $tgl - $jumHari;
				$bulan = ($nowBulan + 1);
			
				//jika bulan melebihi 12 bulan, ganti tahun
				if($bulan > 12)
				{
					$bulan = $bulan - 12;
					$tahun = $nowTahun + 1;
				}
			}
			
			//jika tanggal / bulan memiliki 1 angka maka di tambahkan 0 didepannya
			if(strlen($tgl) == 1)
			{
					$tgl = "0".$tgl;
			}
			
			if(strlen($bulan) == 1)
			{
					$bulan = "0".$bulan;
			}
			
			//mencari tanggal berikutnya pada hari tersebut
			
			$nextTgl = $tgl + 7;
			$bulan2 = $nowBulan;
			$tahun2 = $nowTahun;	
			
			if($nextTgl > $jumHari)
			{
				$nextTgl = $nextTgl - $jumHari;
				$bulan2 = ($nowBulan + 1);
				
				//jika bulan melebihi 12 bulan, ganti tahun
				if($bulan2 > 12)
				{
					$bulan2 = $bulan2 - 12;
					$tahun2 = $nowTahun + 1;
				}
				
			}
			
			if(strlen($nextTgl) == 1)
			{
				$nextTgl = "0".$nextTgl;
			}
				
			if(strlen($bulan2) == 1)
			{
				$bulan2 = "0".$bulan2;
			}
			
			$tglPilihan = array();
			$tglPilihan[$tgl."-".$bulan."-".$tahun] = $tgl."-".$bulan."-".$tahun;
			$tglPilihan[$nextTgl."-".$bulan2."-".$tahun2] = $nextTgl."-".$bulan2."-".$tahun2;
			
			return $tglPilihan;
		}
		
		else
		{
			$hasil = $hari - $nowHari;
			$tgl = $nowTgl + $hasil;
			$bulan = $nowBulan;
			$tahun = $nowTahun;	
			
			if($tgl > $jumHari)
			{
				$tgl = $tgl - $jumHari;
				$bulan = ($nowBulan + 1);
				
				//jika bulan melebihi 12 bulan, ganti tahun
				if($bulan > 12)
				{
					$bulan = $bulan - 12;
					$tahun = $nowTahun + 1;
				}
				
			}
			
			//jika tanggal / bulan memiliki 1 angka maka di tambahkan 0 didepannya
			if(strlen($tgl) == 1)
			{
				$tgl = "0".$tgl;
			}
				
			if(strlen($bulan) == 1)
			{
				$bulan = "0".$bulan;
			}
			
			$nextTgl = $tgl + 7;
			$bulan2 = $nowBulan;
			$tahun2 = $nowTahun;	
			
			if($nextTgl > $jumHari)
			{		
				$nextTgl = $nextTgl - $jumHari;
				$bulan2 = ($nowBulan + 1);
				
				//jika bulan melebihi 12 bulan, ganti tahun
				if($bulan2 > 12)
				{
					$bulan2 = $bulan2 - 12;
					$tahun2 = $nowTahun + 1;
				}	
			}
			
			if(strlen($nextTgl) == 1)
			{
				$nextTgl = "0".$nextTgl;
			}
				
			if(strlen($bulan2) == 1)
			{
				$bulan2 = "0".$bulan2;
			}
			
			$tglPilihan = array();
			$tglPilihan[$tgl."-".$bulan."-".$nowTahun] = $tgl."-".$bulan."-".$nowTahun;
			$tglPilihan[$nextTgl."-".$bulan2."-".$nowTahun] = $nextTgl."-".$bulan2."-".$nowTahun;
			
			return $tglPilihan;
		}
	}
	
}

?>