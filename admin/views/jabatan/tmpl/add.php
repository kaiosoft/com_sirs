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
	if(task == 'jabatan.save')
	{
		 
        if(document.getElementById('jabatan').value == "")
		{
			alert('Fields harus terisi');
		}
		else
		{
			document.getElementById('task').value="jabatan.save";
			document.adminForm.submit();
		}
	}
	else
	{
		document.getElementById('task').value="jabatan.cancel";
		document.adminForm.submit();
	}
}
</script>

<form action="index.php" method="post" name="adminForm">
  <table width="100%" border="0" cellpadding="4" cellspacing="1" class="admintable">
    <tr>
      <td width="18%" align="right" class="key">Nama jabatan * : </td>
      <td width="82%"><input name="jabatan" type="text" id="jabatan" value="<?php echo $this->data['jabatan'][0]->jabatan; ?>" size="30"/></td>
    </tr>

    <?php if($row->id == 0){?>

    <?php } ?>
  </table>
<input type="hidden" name="option" value="com_sirs" />
<input type="hidden" name="c" value="jabatan" />
<input type="hidden" name="id" value="<?php echo $this->data['jabatan'][0]->id; ?>" />
<input type="hidden" id="task" name="task" value="" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>