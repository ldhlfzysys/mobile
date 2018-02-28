<?php
ini_set('display_errors',1); 
$payErrorUrl = "https://m.bdbbuy.com/payError.phtml?msg=用户取消";
echo '<script>url="'.$payErrorUrl.'";window.location.href=url;</script> ';
?>