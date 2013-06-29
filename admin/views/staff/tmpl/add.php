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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$list = JRequest::getVar('list');
$lists = array();

$deptlist[]		= JHTML::_('select.option',  '0', JText::_( 'Pilih Departement' ), 'id', 'nama_dept' );
$deptlist		= array_merge( $deptlist, $list['deptList']);
$lists['dept']	= JHTML::_('select.genericlist', $deptlist, 'dept_id', 'class="inputbox" size="1"', 'id', 'nama_dept', $this->data['staff'][0]->dept_id );	

$jabatanlist[]		= JHTML::_('select.option',  '0', JText::_( 'Pilih Jabatan' ), 'id', 'jabatan' );
$jabatanlist		= array_merge( $jabatanlist, $list['jabatanList']);
$lists['jabatan']	= JHTML::_('select.genericlist', $jabatanlist, 'jabatan_id', 'class="inputbox" size="1"', 'id', 'jabatan', $this->data['staff'][0]->jabatan_id );	

$proflist[]		= JHTML::_('select.option',  '0', JText::_( 'Pilih Profesi' ), 'id', 'profesi' );
$proflist		= array_merge( $proflist, $list['profesiLIst']);
$lists['profesi']	= JHTML::_('select.genericlist', $proflist, 'profesi_id', 'class="inputbox" size="1"', 'id', 'profesi',$this->data['staff'][0]->profesi_id );	
?>

    <script type="text/javascript" src="components/com_sirs/assets/uploadify/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="components/com_sirs/assets/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="components/com_sirs/assets/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
    <script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
      $('#file_upload').uploadify({
        'uploader'  : 'components/com_sirs/assets/uploadify/uploadify.swf',
        'script'    : 'components/com_sirs/assets/uploadify/uploadify.php',
        'cancelImg' : 'components/com_sirs/assets/uploadify/cancel.png',
        'folder'    : '../assets/uploadify/upload/',
		'buttonText'  : 'Upload Foto',
        'auto'      : true,
		'onComplete'  : function(event, ID, fileObj, response, data) {
      alert('Berhasil mengupload foto ' + fileObj.name + ' pada ' + fileObj.filePath);
	  $('.imgReview').attr('src','components/com_sirs/assets/uploadify/upload/'+fileObj.name);
	  $('.imgReview').fadeIn('slow');
	  $('#foto').value(fileObj.name);
    }
      });
    });
    // ]]>
    </script>
    <script language="javascript" src="components/com_ajib/assets/js/ajaxscript.js"></script>
<script type="text/javascript">
Joomla.submitbutton = function(task)
{
	if(task == 'staff.save')
	{
		 var memberid = document.getElementById('id').value;
		 
        if((document.getElementById('nama').value == "") ||	(document.getElementById('nip').value == ""))
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
					document.getElementById('task').value="staff.save";
					document.adminForm.submit();
				}
			}
			else
			{
				document.getElementById('task').value="staff.save";
				document.adminForm.submit();
			}
		}
	}
	else
	{
		document.getElementById('task').value="staff.cancel";
		document.adminForm.submit();
	}
}
</script>
    <link rel="stylesheet" type="text/css" href="components/com_sirs/assets/uploadify/uploadify.css" />

    


<form action="index.php" method="post" name="adminForm">
  <table width="100%" border="0" cellpadding="4" cellspacing="1" class="admintable">
    <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_NAMA'); ?> * : </td>
      <td width="82%"><input name="nama" type="text" id="nama" value="<?php echo $this->data['staff'][0]->nama; ?>" size="30"/></td>
    </tr>
    <?php if($this->data['staff'][0]->id == 0) { ?>
	 <tr>
      <td align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_USERNAME'); ?> * : </td>
      <td><input name="username" type="text" id="username" value="<?php echo $row->username; ?>" size="30"/></td>
    </tr>
    <tr>
      <td align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_EMAIL'); ?> * : </td>
      <td><input name="email" type="text" id="email" value="<?php echo $row->email; ?>" size="30"/></td>
    </tr>	
	<?php } ?>
	<tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_PROFIL'); ?> : </td>
      <td width="82%"><textarea id="profil" name="profil" cols="30" rows="3"><?php echo $this->data['staff'][0]->profil; ?></textarea></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_NIP'); ?> * : </td>
      <td width="82%"><input name="nip" type="text" id="nip" value="<?php echo $this->data['staff'][0]->nip; ?>" size="30"/></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_HP'); ?> : </td>
      <td width="82%"><input name="hp" type="text" id="hp" value="<?php echo $this->data['staff'][0]->hp; ?>" size="30"/></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_DEPARTEMENT'); ?> : </td>
      <td width="82%"><?php echo $lists['dept']; ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_JABATAN'); ?> : </td>
      <td width="82%"><?php echo $lists['jabatan']; ?></td>
    </tr>
	 <tr>
      <td width="18%" align="right" class="key"><?php echo JText::_('COM_SIRS_STAFF_FIELD_PROFESI'); ?> : </td>
      <td width="82%"><?php echo $lists['profesi']; ?></td>
    </tr>

    <?php if($row->id == 0){?>

    <?php } ?>
  </table>
  
    <div class="foto" style="position:absolute; left:700px; top:300px; display:none;">
    <img src="" class="imgReview" height="100" style="display:none;" /><br />
    <input id="file_upload" type="file" name="file_upload" />
    </div>
  
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="staff" />
<input type="hidden" id="id" name="id" value="<?php echo $this->data['staff'][0]->id; ?>" />
<input type="hidden" name="user_id" value="<?php echo $this->data['staff'][0]->user_id; ?>">
<input type="hidden" id="task" name="task" value="" />
<input type="hidden" id="foto" name="foto" value="<?php echo $this->data['staff'][0]->foto; ?>" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>