    <script type="text/javascript" src="jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="swfobject.js"></script>
    <script type="text/javascript" src="jquery.uploadify.v2.1.4.min.js"></script>
    <script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
      $('#file_upload').uploadify({
        'uploader'  : 'uploadify.swf',
        'script'    : 'uploadify.php',
        'cancelImg' : 'cancel.png',
        'folder'    : 'upload/',
        'auto'      : true,
		'onComplete'  : function(event, ID, fileObj, response, data) {
      alert('Berhasil mengupload foto ' + fileObj.name );
	  $('.imgReview').attr('src','upload/'+fileObj.name);
	  $('.imgReview').fadeIn('slow');
    }
      });
    });
    // ]]>
    </script>
    <link rel="stylesheet" type="text/css" href="uploadify.css" />
    <img src="" class="imgReview" height="100" style="display:none;" />
    <input id="file_upload" type="file" name="file_upload" />
