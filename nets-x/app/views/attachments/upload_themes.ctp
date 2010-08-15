<?php ?>			
<div id="MultiUpload">
    <?php echo $form->create('Attachment',array('type'=>'file', 'id' => 'main_form', 'action' => 'uploadThemes')); ?> 
        <!-- Uses specific settings -->
		<br/><br/>Enter your theme name:
		<?php echo $form->text('ThemeName'); ?><br/><br/>
        Maximal 3 files please
        <input type="file" name="userfile"><br clear="all"/>
    <?php echo $form->end('Send'); ?>
</div> 
<?php ?>