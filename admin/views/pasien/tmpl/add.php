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

$ttl = $this->data['pasien'][0]->ttl;
$total = strlen($ttl);
$lokasiKoma = strpos($ttl,',');
$tempat = substr($ttl,0,$lokasiKoma);
$tglLahir = substr($ttl,$lokasiKoma+2);

$lists = array();

$sexlist[]		= JHTML::_('select.option',  '', JText::_( 'Jenis Kelamin' ), 'sex', 'value' );
$sexlist[]		= JHTML::_('select.option',  'Laki - Laki', JText::_( 'Laki - Laki' ), 'sex', 'value' );
$sexlist[]		= JHTML::_('select.option',  'Perempuan', JText::_( 'Perempuan' ), 'sex', 'value' );
$lists['sex']	= JHTML::_('select.genericlist', $sexlist, 'sex', 'class="inputbox" size="1"', 'sex', 'value', $this->data['pasien'][0]->sex );	

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
Joomla.submitbutton = function(task)
{
	if(task == 'pasien.save')
	{
		 var memberid = document.getElementById('id').value;
		 
        if((document.getElementById('nama').value == "") ||	(document.getElementById('sex').value == "")
		 || (document.getElementById('medical_record').value == ""))
		{
			alert('Semua fields bertanda bintang harus terisi');
		}
		else
		{
			if(memberid == "")
			{
				if((document.getElementById('username').value == "") || (document.getElementById('email').value == ""))
				{
					alert('Username & Email harus terisi');
				}
				else
				{
					document.getElementById('task').value="pasien.save";
					document.adminForm.submit();
				}
			}
			else
			{
				document.getElementById('task').value="pasien.save";
				document.adminForm.submit();
			}
		}
	}
	else
	{
		document.getElementById('task').value="pasien.cancel";
		document.adminForm.submit();
	}
}
</script>
<form action="index.php" method="post" name="adminForm">
  <table width="100%" border="0" cellpadding="4" cellspacing="1" class="admintable">
	<tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_NAMA'); ?> * : </td>
      <td width="82%"><input name="nama" type="text" id="nama" value="<?php echo $this->data['pasien'][0]->nama; ?>" size="30"/></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_JENISKELAMIN'); ?> * : </td>
      <td width="82%"><?php echo $lists['sex']; ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_TEMPAT'); ?>  : </td>
      <td width="82%"><input name="tempat" type="text" id="tempat" value="<?php echo $tempat; ?>" size="30"/></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_TGLLAHIR'); ?> : </td>
      <td width="82%"> <?php echo JHTML::_('calendar', $tglLahir,'tglLahir', 'tglLahir', '%Y-%m-%d'); ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_HP'); ?>  : </td>
      <td width="82%"><input name="hp" type="text" id="hp" value="<?php echo $this->data['pasien'][0]->hp; ?>" size="30"/></td>
    </tr>
	<?php if($this->data['pasien'][0]->id == 0) { ?>
	 <tr>
      <td align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_USERNAME'); ?> * : </td>
      <td><input name="username" type="text" id="username" value="<?php echo $row->username; ?>" size="30"/></td>
    </tr>
    <tr>
      <td align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_EMAIL'); ?> * : </td>
      <td><input name="email" type="text" id="email" value="<?php echo $row->email; ?>" size="30"/></td>
    </tr>	
	<?php } ?>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_ALAMAT'); ?>  : </td>
      <td width="82%"><textarea name="alamat" id="alamat" cols="30" rows="3"><?php echo $this->data['pasien'][0]->alamat; ?></textarea></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_REG_FIELD_MEDICALRECORD'); ?>  * : </td>
      <td width="82%"><input name="medical_record" type="text" id="medical_record" value="<?php echo $this->data['pasien'][0]->medical_record; ?>" size="30"/></td>
    </tr>
  </table>
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="pasien" />
   <input type="hidden" id="id" name="id" value="<?php echo $this->data['pasien'][0]->id; ?>">
      <input type="hidden" name="user_id" value="<?php echo $this->data['pasien'][0]->user_id; ?>">
  <input type="hidden" id="task" name="task" value="" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>