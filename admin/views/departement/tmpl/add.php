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
?>
<script type="text/javascript">
Joomla.submitbutton = function(task)
{
	if(task == 'departement.save')
	{
		 
        if((document.getElementById('nama_dept').value == "") || (document.getElementById('kode').value == ""))
		{
			alert('Semua Fields harus terisi');
		}
		else
		{
			document.getElementById('task').value="departement.save";
			document.adminForm.submit();
		}
	}
	else
	{
		document.getElementById('task').value="departement.cancel";
		document.adminForm.submit();
	}
}
</script>
<form action="index.php" method="post" name="adminForm">
  <table width="100%" border="0" cellpadding="4" cellspacing="1" class="admintable">
    <tr>
      <td width="18%" align="right" class="key">Nama Departement * : </td>
      <td width="82%"><input name="nama_dept" type="text" id="nama_dept" value="<?php echo $this->data['departement'][0]->nama_dept; ?>" size="30"/></td>
    </tr>
    <tr>
      <td align="right" class="key">Kode  * : </td>
      <td><input name="kode" type="text" id="kode" value="<?php echo $this->data['departement'][0]->kode; ?>" size="30"/></td>
    </tr>

    <?php if($row->id == 0){?>

    <?php } ?>
  </table>
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="departement" />
<input type="hidden" name="id" value="<?php echo $this->data['departement'][0]->id; ?>" />
<input type="hidden" id="task" name="task" value="" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>