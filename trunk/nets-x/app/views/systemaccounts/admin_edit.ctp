<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('systemaccounts', $admin.'systemaccounts/');
$html->addCrumb('edit', $admin.'systemaccounts/edit/'.$this->data['Systemaccount']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h1>Edit System account</h1>
<?php echo $form->create('Systemaccount');?>
	<fieldset>
 		<legend><?php __('Edit system account');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('passwd_clear');
	?>
	</fieldset>
<?php echo $form->submit('Save', array('class'=>'btn')); echo $form->end();?>
</div>
