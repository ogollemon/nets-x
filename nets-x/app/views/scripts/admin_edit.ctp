<?php
//debug($hosts);return;
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($this->data['Scenario']['name'], $admin.'scenarios/edit/'.$this->data['Scenario']['id']);
$html->addCrumb('scripts', $admin.'scenarios/scripts/'.$this->data['Scenario']['id']);
$html->addCrumb($this->data['Script']['name'], $admin.'/scripts/edit/'.$this->data['Script']['id'].'/'.$this->data['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">

<h1><?php
$editType = (isset($add) && $add)? 'Add ' : 'Edit ' ;
print $editType.$scripttype_name.' script';
?></h1>

<?php
print $form->create('Script', array('action'=>'edit'));

print $form->hidden('Script.id', array('type'=>'text', 'label'=>false));
print $form->hidden('Script.scenario_id', array('type'=>'text', 'label'=>false, 'value'=>$this->data['Scenario']['id']));
print $form->hidden('Script.scripttype_id', array('type'=>'text', 'label'=>false));

print $form->input('Script.name', array('label'=>'Name:', 'size'=>50, 'error'=>array('required'=>'Please enter a name.')));
print $form->input('Script.description', array('type'=>'textarea', 'label'=>'description:',  'rows'=>1, 'cols'=>50, 'error'=>array('required'=>'Please enter a description.')));       
print $form->input('Script.script', array('type'=>'textarea', 'label'=>'shell script:', 'class'=>'shellscript', 'wrap'=>'off', 'error'=>array('required'=>'Please enter code.')));
print $form->input('Script.sequence_no', array('label'=>'sequence number in script stack:', 'size'=>2, 'error'=>array('required'=>'Please enter a sequence number in the stack.')));
//print $form->input('Script.deployment_package', array('label'=>'Deployment package name:', 'size'=>50, 'error'=>array('required'=>'Please enter a path for the deployment package.')));  
print $form->input(
    'Script.deployment_package',
    array(
        'type'=>'select',
        'options'=>$packages,
        'label'=>'Deployment package name:'
    )
);
?>

<fieldset><legend class="big">distribute script to these hosts:</legend>
<?php
print $form->input('Host.Host', array('type'=>'select', 'multiple'=>'checkbox', 'options'=>$hosts, 'label'=>false, 'style'=>'margin-bottom:0px')).'</td>';
?>
</fieldset>

<?php
print $form->submit('Submit', array('class'=>'btn'));
print $form->end();
?>
</div>