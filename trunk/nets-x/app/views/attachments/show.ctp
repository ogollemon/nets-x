<?php  
$this->layout = false; //no layout, otherwise header will already be sent!
Header( 'Content-type: '.$mimeType);
//echo 'IMG DATA READ OUT CALLED';
print $content;
?>