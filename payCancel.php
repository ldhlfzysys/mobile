<?php
ini_set('display_errors',1); 
include_once('./config.php');
$payErrorUrl = $baseHost . "payError.phtml?msg=用户取消";
echo '<script>url="'.$payErrorUrl.'";window.location.href=url;</script> ';
?>