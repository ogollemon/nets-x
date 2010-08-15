<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('hosts', $admin.'hosts/');
$html->addCrumb('edit', $admin.'hosts/edit/'.$this->data['Host']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>
<div class="padded">
<h1>Create new host</h1>
<?php echo $form->create('Host');?>
	<fieldset>
 		<legend><?php __('Edit Host');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('ip');
		echo $form->input('name');
		echo $form->input('area');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->submit('Submit', array('class'=>'btn')); print $form->end(); ?>
</div>
