<link rel="stylesheet" href="app/assets/css/print.css" type="text/css" media="print">
<?php


$code = (isset($_GET['code']))? $_GET['code'] : ( (isset($_POST['code']))? $_POST['code'] : '') ; 
$src  = "invitaion2013.php?code=".$code ;

?>
<br/>
<center>
<input name="button" type="button" value="Imprimer votre invitation" onClick="window.print()"  />
</center>
<br/>
<?php
echo '<center><img src="'.$src.'"> </center>';
	$size = @getimagesize($src); 
   $fp = @fopen($src, "rb"); 
   if ($size && $fp) 
   { 
      header("Content-type: {".$size['mime']."}"); 
      header("Content-Length: " . filesize($src)); 
      header("Content-Disposition: attachment; filename=$filename"); 
      header('Content-Transfer-Encoding: binary'); 
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');  
      fpassthru($fp); 
      exit; 
   } 
?>
