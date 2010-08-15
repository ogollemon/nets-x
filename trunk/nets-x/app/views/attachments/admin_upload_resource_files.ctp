<?php ?>
<div id="MultiUploadFiles"> 
    <?php 
    //this calls the admin routine in the attachment controller
    echo $form->create('Attachment',array('type'=>'file', 'id' => 'main_form', 'action' => 'uploadResourceFiles/' . $scenario_id)); ?>  
    <?php 
//the hidden input tells the attachment controller where it should dump the files because the upload routine is also used to upload theme files in another place
    print $form->hidden('Attachment.scenario_id', array('label'=>false, 'value'=>$scenario_id)); 
    ?>
        I want to upload resource files for the new scenario to the database.
    </br></br>
        Maximal 3 files please.
        <input type="file" name="userfile"><br clear="all"/> 
    <?php echo $form->end('Send'); ?> 
 
</div>
<?php ?>
