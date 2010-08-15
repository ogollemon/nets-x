<?php 
print '<p style="color:red"><strong>' . $uploadBox . '</strong></p>';
print '<br /><br />'; 
?>
<div id="MultiUpload">
         <form method="post" action="<?php echo $html->url('/Attachments/upload')?>">
            <?php
            print $form->radio('Attachment.type', array("uploadFile"=>"uploadFile"),null,array());
            print $form->radio('Attachment.type', array("uploadTheme"=>"uploadTheme"),null,array());
            ?>
            <?php echo $form->submit('Next') ?>
            <?php echo $form->end();?>
</div> 
