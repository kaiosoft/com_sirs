<?php

	/**
	 *	Component SIRS for Jomla 1.5.x
	 *  Version : 1.0.0
	 *	Copyright (C) Kaio Piranti Lunak
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
	 *
	 *	Developer : Fatah Iskandar Akbar 
	 *  Email : info@kaiogroup.com
	 *	Date: Juni 2011
	**/

	defined('_JEXEC') or die('Restricted access');
	$lists = array();
	//build jenis kelamin list
		$sexlist[]		= JHTML::_('select.option',  '', JText::_( 'Pilih Jenis Kelamin' ), 'id', 'sex' );
		$sexlist[]		= JHTML::_('select.option',  'Laki - laki', JText::_( 'Laki - Laki' ), 'id', 'sex' );
		$sexlist[]		= JHTML::_('select.option',  'Perempuan', JText::_( 'Perempuan' ), 'id', 'sex' );

		$lists['sex']	= JHTML::_('select.genericlist', $sexlist, 'sex', 'class="inputbox" size="1"', 'id', 'sex', $row->sex );
?>
<div id="pageComp">
<link rel="stylesheet" type="text/css" href="components/com_penduduk/asset/penduduk.css" />
<div id="Notification" style="display:none; padding:10px; background:red; color:#FFFFFF; font-weight:bold;"></div>
<!-- <div class="jteks">Pendaftaran User Baru</div> -->
	<form method="post" name="adminForm" id="adminForm">
  	<table width="100%" border="0" cellpadding="4" cellspacing="1" id="tableRegistrasi">
	<tr>
      <td class="key">Username *</td>
      <td><input name="username" type="text" id="username" size="30" class="regInBox"/></td>
    </tr>
	<tr>
      <td class="key">Password *</td>
      <td><input name="password" type="password" id="password" class="regInBox" size="30"/></td>
    </tr>
    <tr>
      <td class="key">Konfirmasi Password *</td>
      <td><input name="password2" type="password" id="password2" class="regInBox" size="30"/></td>
    </tr>
    <tr>
      <td class="key">Nama *</td>
      <td><input name="name" type="text" id="name" class="regInBox" size="30"/></td>
    </tr>
     <tr>
      <td class="key">Jenis Kelamin</td>
      <td><?php echo $lists['sex']; ?></td>
    </tr>  
	<tr>
      <td class="key">Tempat Lahir</td>
      <td><input name="tempat" type="text" id="tempat" class="regInBox" size="30"/></td>
    </tr>
	<tr>
		<td class="key">Tgl Lahir</td>
		<td><?php echo JHTML::_('calendar','','tgl', 'tgl', '%Y-%m-%d'); ?> <i>format 1992-03-28</i></td>
	</tr>
    <tr>
      <td class="key">Telepon / Handphone</td>
      <td><input name="hp" type="text" id="hp" class="regInBox" size="30"/></td>
    </tr>
    <tr>
      <td class="key">Email *</td>
      <td><input name="email" type="email" id="email" class="regInBox" size="30"/></td>
    </tr>    
	<tr>
      <td class="key">Alamat</td>
      <td><textarea name="alamat" cols="25" rows="3" class="regInArea"><?php echo $row->alamat; ?></textarea></td>
    </tr>
    <tr>
		<td colspan="2" class="key"><span style="color:red;"><i>Kosongkan field medical Record jika anda pasien baru</i></span></td>
      </tr>
    <tr>
		<td class="key">Medical Record</td>
      <td><input name="medical_record" type="medical_record" id="medical_record" class="regInBox" size="30"/></td>
    </tr>
    <tr>
        <td colspan="2">
       <table>
       <tr><td height="30"></td></tr>
       <tr>
       <td> 
<div id="captcha"></div>
	<?php
	require_once('components/com_sirs/assets/recaptchalib.php');
	// Get a key from https://www.google.com/recaptcha/admin/create
	$publickey = "6LcDus0SAAAAAFGGGteRq1IQ1Of3-qxlOZM6umAF";
	//$privatekey = "6LcDus0SAAAAAANDtMEi2tdln7ThIgA7fhN8n9q5";
	echo recaptcha_get_html($publickey);
    ?>
        </td>
      <td>
      <input type="button" value="Register" id="regMem" onclick="submitForm();"> <!-- submitForm -->
      </td>
      </tr>
      </table>    
      </tr>
  </table>
  <p>&nbsp;</p>
  </p>
	<input type="hidden" name="c" value="Registrasi" />
  <input type="hidden" name="task" value="Registered" />
  <input type="hidden" name="option" value="com_sirs" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>


<script>
 
  function submitForm()
  {
	  var form = document.adminForm;
	  if((form.username.value == "") || (form.password.value == "") || (form.password2.value == "") || (form.name.value == "") || (form.email.value == ""))
	  {
			document.getElementById('Notification').style.display='block';
			document.getElementById('Notification').innerHTML='Semua Fields Bertanda Bintang Harus Terisi';
	  }
	  else
	  {
		  if(form.password.value != form.password2.value)
		  {
			 document.getElementById('Notification').style.display='block';
			document.getElementById('Notification').innerHTML='Password Dan Konfirmasi Password Harus Sesuai';
		  }
		  else
		  {
			  form.submit();
		  }
	  }
  }
  
  </script>

<!-- quick style -->
<style>
#tableRegistrasi
{
text-align:left;
}
#tableRegistrasi .key
{
	width:40%;
padding:10px;
font-size:12px;
font-weight:bold;
color:#555;
}
</style>