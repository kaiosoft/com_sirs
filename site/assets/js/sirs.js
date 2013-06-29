// JavaScript Document
$(document).ready(function()
{	
	$('input[type=button][id=buttonDesc]').click(openDesc);
	function openDesc()
	{
	  var classThis = $(this).attr('class');
	  $('#sort'+classThis).fadeOut('slow');
	  $('.desc'+classThis).fadeIn('slow');
	}
	
	$('input[type=button][id=doBooking]').click(bookingJadwal);
	function bookingJadwal()
	{
		var classThis = $(this).attr('class');
		$('.light'+classThis).fadeIn('slow');
		$('.bgBlack').fadeIn('slow');
		
		$('.bgBlack').click(function()
		{
			$('.light'+classThis).fadeOut('slow');
			$('.bgBlack').fadeOut('fast');
		});
	}
	
	$('input[type=button][id=bookThis]').click(bookThis);
	function bookThis()
	{
		var classThis = $(this).attr('class');		
		var tgl = $('#tanggal'+classThis).attr('value');
		var id = $('#jam'+classThis).attr('value');		
		var jam = $('#jam'+classThis+' option:selected').text();		
		//var klinik = $('#klinik').attr('value');	
		var dokter = classThis.charAt(0);
    
		//alert(tgl+" dan "+jam+" klinik "+klinik+" Dokter "+dokter);
    if((tgl == "") || (jam == ""))
		{
			alert('Tanggal dan jam harus terisi');
		}
    /*else if(klinik == null)
    {
      alert('Pilih klilik telebih dahulu');
    }*/
		else
		{
			var conf = confirm('Yakin anda ingin membooking pada tgl ' + tgl + ' pada periode jam ' + jam);
			if(conf == true)
			{
				window.open('index.php?option=com_sirs&task=bookingDokter&bookingData=' + id + ',' + tgl,'_parent');	
			}
			else
			{
				alert('Boooking dibatalkan');
			}
		}
    
	}
	
});