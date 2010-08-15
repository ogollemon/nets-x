<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('interface configuration', $admin.'settings/interfaces', array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h1>Administration of the game&acute;s Network interfaces:</h1>

<fieldset><legend class="big">Game NICs:</legend>
<table border="0" cellspacing="2">
<?php foreach($this->data as $i=>$interface){ ?>
<tr>
    <td align="left" width="200" valign="top"><?php
    print $form->create('Setting', array('url'=>$admin.'settings/interfaces'));
    print $interface['Setting']['name']; ?>:</td>
    <td align="left" width="50" valign="top"><?php print $form->input('id', array('value'=>$interface['Setting']['id'])); print $form->input('value', array('value'=>$interface['Setting']['value'], 'label'=>false)); ?></td>
    <td align="left" width="250" valign="top">ip: <?php print $form->input('id', array('value'=>$interface['Setting']['id'])); print $form->input('ip', array('value'=>$interface['Setting']['ip'], 'label'=>false)); ?><br>
    netmask: <?php print $form->input('id', array('value'=>$interface['Setting']['id'])); print $form->input('netmask', array('value'=>$interface['Setting']['netmask'], 'label'=>false)); ?>
    <br>gateway: <?php print $form->input('id', array('value'=>$interface['Setting']['id'])); print $form->input('gateway', array('value'=>$interface['Setting']['gateway'], 'label'=>false)); ?></td>
    <td align="right" width="50" valign="top"><?php
    print $form->submit('Save', array('class'=>'btn'));
    print $form->end();
    ?></td>
    
</tr>
<?php } ?>
</table>
</fieldset>
<br />


</div>