<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('hosts', $admin.'hosts/');
$html->addCrumb('add', $admin.'hosts/add', array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h1>Add new host</h1>
<?php echo $form->create('Host');?>
	<fieldset>
 		<legend><?php __('Add Host');?></legend>
	<?php
		echo $form->input('ip');
		echo $form->input('name');
		echo $form->input('area');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->submit('Submit', array('class'=>'btn')); print $form->end(); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Hosts', true), array('action'=>'index'));?></li>
	</ul>
</div>
